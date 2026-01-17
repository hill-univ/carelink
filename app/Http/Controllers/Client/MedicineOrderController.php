<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\MedicineOrder;
use App\Models\MedicineOrderItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MedicineOrderController extends Controller
{
    public function index()
    {
        $orders = MedicineOrder::with('items.medicine')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('client.orders.index', compact('orders'));
    }

    public function create()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('client.medicines.index')
                ->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('client.orders.create', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
        ], [
            'shipping_address.required' => __('validation.required', ['attribute' => 'Shipping address']),
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('client.medicines.index')
                ->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();
        try {
            $total = 0;
            $orderItems = [];

            // Validate stock and calculate total
            foreach ($cart as $id => $item) {
                $medicine = Medicine::findOrFail($id);
                
                if ($medicine->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$medicine->name}");
                }

                $subtotal = $medicine->price * $item['quantity'];
                $total += $subtotal;

                $orderItems[] = [
                    'medicine_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $medicine->price,
                    'subtotal' => $subtotal,
                ];

                // Reduce stock
                $medicine->decrement('stock', $item['quantity']);
            }

            // Create order
            $order = MedicineOrder::create([
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'shipping_address' => $request->shipping_address,
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('client.dashboard')
                ->with('success', "Order placed successfully! Order code: {$order->order_code}. Total: Rp " . number_format($order->total_amount, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(MedicineOrder $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.medicine');

        return view('client.orders.show', compact('order'));
    }

    public function cancel(MedicineOrder $order)
    {
        // Check ownership
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only pending orders can be cancelled
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled');
        }

        DB::beginTransaction();
        try {
            // Restore medicine stock
            foreach ($order->items as $item) {
                $item->medicine->increment('stock', $item->quantity);
            }

            // Update order status
            $order->update(['status' => 'cancelled']);

            DB::commit();

            return redirect()->route('client.orders.index')
                ->with('success', 'Order cancelled successfully. Stock has been restored.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }
}

