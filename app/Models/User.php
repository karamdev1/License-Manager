<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'username',
        'password',
        'permissions',
        'status',
        'reff',
        'created_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->user_id)) {
                $user->user_id = (string) Str::uuid();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
