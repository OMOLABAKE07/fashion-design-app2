<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncQueue extends Model
{
    use HasFactory;

    protected $table = 'sync_queue';

    protected $fillable = [
        'timestamp',
        'operation',
        'entity_type',
        'data',
        'attempts',
        'last_attempt',
        'status',
    ];

    protected $casts = [
        'data' => 'array',
        'timestamp' => 'datetime',
        'last_attempt' => 'datetime',
    ];
}
