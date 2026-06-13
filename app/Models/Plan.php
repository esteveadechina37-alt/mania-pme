<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'billing_period', 'is_active', 'is_free'
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
        'is_free'   => 'boolean',
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'plan_module');
    }
}