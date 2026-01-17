<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Clinic;
use App\Models\Medicine;
use App\Models\Specialization;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Sample Doctors
        $doctors = [
            [
                'name' => 'Dr. John Smith',
                'license_number' => 'DOC001',
                'phone' => '081234567890',
                'email' => 'john.smith@example.com',
                'bio' => 'Experienced general practitioner with 10 years of practice.',
                'consultation_fee' => 150000,
                'is_available' => true,
                'specializations' => [1], // General Practitioner
            ],
            [
                'name' => 'Dr. Sarah Johnson',
                'license_number' => 'DOC002',
                'phone' => '081234567891',
                'email' => 'sarah.johnson@example.com',
                'bio' => 'Specialist in cardiovascular diseases.',
                'consultation_fee' => 300000,
                'is_available' => true,
                'specializations' => [2], // Cardiologist
            ],
            [
                'name' => 'Dr. Michael Chen',
                'license_number' => 'DOC003',
                'phone' => '081234567892',
                'email' => 'michael.chen@example.com',
                'bio' => 'Pediatric specialist caring for children.',
                'consultation_fee' => 200000,
                'is_available' => true,
                'specializations' => [4], // Pediatrician
            ],
        ];

        foreach ($doctors as $docData) {
            $specializations = $docData['specializations'];
            unset($docData['specializations']);
            
            $doctor = Doctor::create($docData);
            $doctor->specializations()->attach($specializations);
        }

        // Sample Clinics
        $clinics = [
            [
                'name' => 'CareLink Medical Center',
                'address' => 'Jl. Sudirman No. 123',
                'city' => 'Jakarta',
                'phone' => '021-5551234',
                'email' => 'info@carelinkmc.com',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'opening_time' => '08:00',
                'closing_time' => '20:00',
                'facilities' => 'Emergency Room, Laboratory, Pharmacy, X-Ray',
            ],
            [
                'name' => 'Healthy Life Clinic',
                'address' => 'Jl. Thamrin No. 45',
                'city' => 'Bandung',
                'phone' => '022-4441234',
                'email' => 'info@healthylife.com',
                'latitude' => -6.9175,
                'longitude' => 107.6191,
                'opening_time' => '09:00',
                'closing_time' => '21:00',
                'facilities' => 'General Consultation, Laboratory, Pharmacy',
            ],
        ];

        foreach ($clinics as $clinicData) {
            Clinic::create($clinicData);
        }

        // Sample Medicines
        $medicines = [
            [
                'name' => 'Paracetamol 500mg',
                'category' => 'Pain Relief',
                'description' => 'Pain reliever and fever reducer',
                'manufacturer' => 'Generic Pharma',
                'price' => 15000,
                'stock' => 100,
                'requires_prescription' => false,
            ],
            [
                'name' => 'Vitamin C 1000mg',
                'category' => 'Vitamin',
                'description' => 'Immune system booster',
                'manufacturer' => 'Health Plus',
                'price' => 50000,
                'stock' => 50,
                'requires_prescription' => false,
            ],
            [
                'name' => 'Ibuprofen 400mg',
                'category' => 'Pain Relief',
                'description' => 'Anti-inflammatory pain reliever',
                'manufacturer' => 'MediCare',
                'price' => 25000,
                'stock' => 75,
                'requires_prescription' => false,
            ],
            [
                'name' => 'Amoxicillin 500mg',
                'category' => 'Antibiotic',
                'description' => 'Antibiotic for bacterial infections',
                'manufacturer' => 'PharmaLab',
                'price' => 45000,
                'stock' => 30,
                'requires_prescription' => true,
            ],
        ];

        foreach ($medicines as $medicineData) {
            Medicine::create($medicineData);
        }
    }
}