<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'email',
        'latitude',
        'longitude',
        'opening_time',
        'closing_time',
        'facilities',
        'image',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class)
            ->withPivot('schedule_days', 'start_time', 'end_time')
            ->withTimestamps();
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}