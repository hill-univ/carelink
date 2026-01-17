<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'manufacturer',
        'price',
        'stock',
        'image',
        'requires_prescription',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'requires_prescription' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(MedicineOrderItem::class);
    }
}