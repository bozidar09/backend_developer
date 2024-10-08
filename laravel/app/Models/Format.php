<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function copies() {
        return $this->hasMany(Copy::class);
    }
}
