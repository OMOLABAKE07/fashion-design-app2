<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'gender',
        'notes',
        'status',
    ];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
