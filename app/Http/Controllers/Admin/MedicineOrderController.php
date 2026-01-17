<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicineOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineOrderController extends Controller
{
    public function index()
    {
        $orders = MedicineOrder::with(['user', 'items.medicine'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, MedicineOrder $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        // If cancelling, restore stock
        if ($validated['status'] === 'cancelled' && $order->status !== 'cancelled') {
            DB::beginTransaction();
            try {
                foreach ($order->items as $item) {
                    $item->medicine->increment('stock', $item->quantity);
                }
                $order->update(['status' => $validated['status']]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
            }
        } else {
            $order->update(['status' => $validated['status']]);
        }

        return redirect()->back()
            ->with('success', "Order status updated to: {$validated['status']}");
    }

    public function destroy(MedicineOrder $order)
    {
        // Restore stock before deleting
        DB::beginTransaction();
        try {
            if ($order->status !== 'cancelled' && $order->status !== 'delivered') {
                foreach ($order->items as $item) {
                    $item->medicine->increment('stock', $item->quantity);
                }
            }
            $order->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete order: ' . $e->getMessage());
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully');
    }
}