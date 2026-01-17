<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function index(Request $request)
    {
        $query = Clinic::query();

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $clinics = $query->paginate(12);
        $cities = Clinic::distinct()->pluck('city');

        return view('client.clinics.index', compact('clinics', 'cities'));
    }

    public function show(Clinic $clinic)
    {
        $clinic->load('doctors.specializations');
        return view('client.clinics.show', compact('clinic'));
    }
}