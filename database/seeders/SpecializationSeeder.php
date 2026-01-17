<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = [
            ['name' => 'General Practitioner', 'description' => 'Primary care physician'],
            ['name' => 'Cardiologist', 'description' => 'Heart specialist'],
            ['name' => 'Dermatologist', 'description' => 'Skin specialist'],
            ['name' => 'Pediatrician', 'description' => 'Children specialist'],
            ['name' => 'Orthopedist', 'description' => 'Bone and joint specialist'],
            ['name' => 'Neurologist', 'description' => 'Nervous system specialist'],
            ['name' => 'Psychiatrist', 'description' => 'Mental health specialist'],
            ['name' => 'Dentist', 'description' => 'Dental specialist'],
        ];

        foreach ($specializations as $spec) {
            Specialization::create($spec);
        }
    }
}