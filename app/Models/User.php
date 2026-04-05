<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'curp',
        'name',
        'lastname',
        'lastname2',
        'state',
        'municipality',
        'locality',
        'colony',
        'street',
        'exterior_number',
        'interior_number',
        'zip_code',
        'phone',
        'adscription',
        'role',
        'email',
        'password',
        'permissions',
        'plantel_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'permissions' => 'array',
        ];
    }

    public function plantel()
    {
        return $this->belongsTo(Plantel::class);
    }
}
