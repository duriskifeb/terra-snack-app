<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * Kontrol akses ke panel Filament berdasarkan role.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        if ($panel->getId() === 'stand') {
            return $this->role === 'stand_staff';
        }

        return false;
    }

    /**
     * Kolom yang bisa diisi secara mass-assignment.
     */
    protected $fillable = [
        'name',
        'phone',
        'password',
        'role',
        'phone'
    ];

    /**
     * Kolom yang disembunyikan saat model di-serialize.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Tipe data casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Laravel 10+ bisa otomatis hash
        ];
    }

    /**
     * Relasi ke tabel order.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

     public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }
}
