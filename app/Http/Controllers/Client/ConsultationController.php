<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['doctor', 'clinic'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('client.consultations.index', compact('consultations'));
    }

    public function create(Request $request)
    {
        $doctor = null;
        $clinic = null;

        if ($request->filled('doctor_id')) {
            $doctor = Doctor::with('clinics')->findOrFail($request->doctor_id);
        }

        if ($request->filled('clinic_id')) {
            $clinic = Clinic::findOrFail($request->clinic_id);
        }

        $doctors = Doctor::where('is_available', true)->get();
        $clinics = Clinic::all();

        return view('client.consultations.create', compact('doctors', 'clinics', 'doctor', 'clinic'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'clinic_id' => 'required|exists:clinics,id',
            'consultation_date' => 'required|date|after:today',
            'consultation_time' => 'required',
            'symptoms' => 'required|string|min:10',
        ], [
            'doctor_id.required' => __('validation.required', ['attribute' => 'Doctor']),
            'clinic_id.required' => __('validation.required', ['attribute' => 'Clinic']),
            'consultation_date.required' => __('validation.required', ['attribute' => 'Date']),
            'consultation_date.after' => 'Consultation date must be in the future',
            'symptoms.required' => __('validation.required', ['attribute' => 'Symptoms']),
            'symptoms.min' => 'Please describe your symptoms in at least 10 characters',
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);

        $consultation = Consultation::create([
            'booking_code' => 'CONS-' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,
            'clinic_id' => $request->clinic_id,
            'consultation_date' => $request->consultation_date,
            'consultation_time' => $request->consultation_time,
            'symptoms' => $request->symptoms,
            'fee' => $doctor->consultation_fee,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('client.dashboard')
            ->with('success', "Consultation booked successfully! Booking code: {$consultation->booking_code}");
    }

    public function show(Consultation $consultation)
    {
        if ($consultation->user_id !== auth()->id()) {
            abort(403);
        }

        $consultation->load(['doctor.specializations', 'clinic']);

        return view('client.consultations.show', compact('consultation'));
    }

    public function cancel(Consultation $consultation)
    {
        if ($consultation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($consultation->status !== 'pending') {
            return redirect()->back()->with('error', 'Cannot cancel this consultation');
        }

        $consultation->update(['status' => 'cancelled']);

        return redirect()->route('client.consultations.index')
            ->with('success', 'Consultation cancelled');
    }
}