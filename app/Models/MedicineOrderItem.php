<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_order_id',
        'medicine_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function medicineOrder()
    {
        return $this->belongsTo(MedicineOrder::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}