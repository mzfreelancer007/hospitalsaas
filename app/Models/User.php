<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = ['hospital_id', 'name', 'email', 'phone', 'password', 'is_active'];
    protected $hidden = ['password', 'remember_token'];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole(string $key): bool
    {
        return $this->roles()->where('key', $key)->exists();
    }

    public function hasPermission(string $key): bool
    {
        return $this->roles()->whereHas('permissions', fn ($q) => $q->where('key', $key))->exists();
    }
}
