<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'sector',
        'logo',
        'employees_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // Une entreprise a plusieurs utilisateurs
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Récupérer uniquement l'admin de l'entreprise
    public function admin()
    {
        return $this->hasOne(User::class)->where('is_admin', true);
    }
}