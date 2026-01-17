<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'doctor_id',
        'clinic_id',
        'consultation_date',
        'consultation_time',
        'symptoms',
        'diagnosis',
        'prescription',
        'status',
        'fee',
        'payment_status',
    ];

    protected $casts = [
        'consultation_date' => 'date',
        'fee' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}