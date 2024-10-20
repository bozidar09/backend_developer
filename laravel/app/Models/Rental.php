<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'return_date' => 'immutable_datetime',
            'rental_date' => 'immutable_datetime',
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function copies() {
        return $this->belongsToMany(Copy::class)->withPivot('return_date')->using(CopyRental::class);
    }
}
