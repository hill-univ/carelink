<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClinicController extends Controller
{
    public function index()
    {
        $clinics = Clinic::paginate(10);
        return view('admin.clinics.index', compact('clinics'));
    }

    public function create()
    {
        return view('admin.clinics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('clinics', 'public');
        }

        Clinic::create($validated);

        return redirect()->route('admin.clinics.index')
            ->with('success', __('Clinic created successfully'));
    }

    public function show(Clinic $clinic)
    {
        $clinic->load('doctors');
        return view('admin.clinics.show', compact('clinic'));
    }

    public function edit(Clinic $clinic)
    {
        return view('admin.clinics.edit', compact('clinic'));
    }

    public function update(Request $request, Clinic $clinic)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'facilities' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($clinic->image) {
                Storage::disk('public')->delete($clinic->image);
            }
            $validated['image'] = $request->file('image')->store('clinics', 'public');
        }

        $clinic->update($validated);

        return redirect()->route('admin.clinics.index')
            ->with('success', __('Clinic updated successfully'));
    }

    public function destroy(Clinic $clinic)
    {
        if ($clinic->image) {
            Storage::disk('public')->delete($clinic->image);
        }
        
        $clinic->delete();

        return redirect()->route('admin.clinics.index')
            ->with('success', __('Clinic deleted successfully'));
    }
}