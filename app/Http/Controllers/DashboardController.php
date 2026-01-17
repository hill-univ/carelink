<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Clinic;
use App\Models\Medicine;
use App\Models\Consultation;
use App\Models\MedicineOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        $data = [
            'doctors' => Doctor::count(),
            'clinics' => Clinic::count(),
            'medicines' => Medicine::count(),
            'consultations' => Consultation::count(),
            'medicineOrders' => MedicineOrder::count(),
            'recentConsultations' => Consultation::with(['user', 'doctor', 'clinic'])
                ->latest()
                ->take(5)
                ->get(),
            'recentOrders' => MedicineOrder::with('user')
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }

    public function client()
    {
        $userId = auth()->id();
        
        $data = [
            'consultations' => Consultation::where('user_id', $userId)->count(),
            'orders' => MedicineOrder::where('user_id', $userId)->count(),
            'recentConsultations' => Consultation::with(['doctor', 'clinic'])
                ->where('user_id', $userId)
                ->latest()
                ->take(5)
                ->get(),
            'recentOrders' => MedicineOrder::with('items.medicine')
                ->where('user_id', $userId)
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('client.dashboard', $data);
    }
}