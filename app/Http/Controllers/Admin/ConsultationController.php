<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['user', 'doctor', 'clinic'])
            ->latest()
            ->paginate(15);

        return view('admin.consultations.index', compact('consultations'));
    }

    public function updateStatus(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $consultation->update(['status' => $validated['status']]);

        return redirect()->back()
            ->with('success', "Consultation status updated to: {$validated['status']}");
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('admin.consultations.index')
            ->with('success', 'Consultation deleted successfully');
    }
}