<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $table = 'users';

    // sin proteccion de asignacion masiva, asi el alta y la edicion de perfil
    // aceptan cualquier campo del formulario de golpe
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_admin' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    // ayuda para plantillas y middleware
    public function esAdmin(): bool
    {
        return $this->is_admin || $this->role === 'admin';
    }
}
