<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('specializations')->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        $specializations = Specialization::all();
        return view('admin.doctors.create', compact('specializations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:doctors',
            'phone' => 'required|string',
            'email' => 'required|email',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'consultation_fee' => 'required|numeric|min:0',
            'specializations' => 'required|array',
        ], [
            'name.required' => __('validation.required', ['attribute' => __('Doctor name')]),
            'license_number.required' => __('validation.required', ['attribute' => __('License number')]),
            'license_number.unique' => __('validation.unique', ['attribute' => __('License number')]),
            'specializations.required' => __('validation.required', ['attribute' => __('Specializations')]),
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        $doctor = Doctor::create($validated);
        $doctor->specializations()->attach($request->specializations);

        return redirect()->route('admin.doctors.index')
            ->with('success', __('Doctor created successfully'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('specializations', 'clinics');
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $specializations = Specialization::all();
        return view('admin.doctors.edit', compact('doctor', 'specializations'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:doctors,license_number,' . $doctor->id,
            'phone' => 'required|string',
            'email' => 'required|email',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'consultation_fee' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'specializations' => 'required|array',
        ]);

        if ($request->hasFile('photo')) {
            if ($doctor->photo) {
                Storage::disk('public')->delete($doctor->photo);
            }
            $validated['photo'] = $request->file('photo')->store('doctors', 'public');
        }

        $doctor->update($validated);
        $doctor->specializations()->sync($request->specializations);

        return redirect()->route('admin.doctors.index')
            ->with('success', __('Doctor updated successfully'));
    }

    public function destroy(Doctor $doctor)
    {
        if ($doctor->photo) {
            Storage::disk('public')->delete($doctor->photo);
        }
        
        $doctor->delete();

        return redirect()->route('admin.doctors.index')
            ->with('success', __('Doctor deleted successfully'));
    }
}