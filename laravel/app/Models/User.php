<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function rentals() {
        return $this->hasMany(Rental::class);
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function fullNameId() {
        return $this->first_name . ' ' . $this->last_name . ' (' . $this->member_id . ')';
    }
}
