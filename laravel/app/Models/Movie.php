<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function genre() {
        return $this->belongsTo(Genre::class);
    }

    public function price() {
        return $this->belongsTo(Price::class);
    }

    public function copies() {
        return $this->hasMany(Copy::class);
    }
}
