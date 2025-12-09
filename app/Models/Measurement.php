<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_id',
        'customer_name',
        'measurement_date',
        'notes',
        'measurements',
        'categories',
    ];

    // 🧩 Automatically convert JSON to array when retrieved
    protected $casts = [
        'measurements' => 'array',
        'categories' => 'array',
        'measurement_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
