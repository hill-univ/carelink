<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'license_number',
        'phone',
        'email',
        'bio',
        'photo',
        'consultation_fee',
        'is_available',
    ];

    protected $casts = [
        'consultation_fee' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function specializations()
    {
        return $this->belongsToMany(Specialization::class);
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class)
            ->withPivot('schedule_days', 'start_time', 'end_time')
            ->withTimestamps();
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}