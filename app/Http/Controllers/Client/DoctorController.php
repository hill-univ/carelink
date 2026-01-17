<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::with('specializations')->where('is_available', true);

        if ($request->filled('specialization')) {
            $query->whereHas('specializations', function($q) use ($request) {
                $q->where('specialization_id', $request->specialization);
            });
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $doctors = $query->paginate(12);
        $specializations = Specialization::all();

        return view('client.doctors.index', compact('doctors', 'specializations'));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load('specializations', 'clinics');
        return view('client.doctors.show', compact('doctor'));
    }
}