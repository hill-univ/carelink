<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::where('stock', '>', 0)
                         ->where('requires_prescription', false);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $medicines = $query->paginate(12);
        $categories = Medicine::distinct()->pluck('category');

        return view('client.medicines.index', compact('medicines', 'categories'));
    }

    public function show(Medicine $medicine)
    {
        return view('client.medicines.show', compact('medicine'));
    }
}