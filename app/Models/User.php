<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'client_code',
        'package_id',
        'theme_id',
        'verification_code',
        'is_verified',
        'is_active',
        'role',
        'expires_at',
        'notes',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin' && $this->is_active;
        }

        if ($panel->getId() === 'client') {
            return $this->role === 'client'
                && $this->is_active
                && $this->is_verified
                && (!$this->expires_at || now()->lt($this->expires_at));
        }

        return false;
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
