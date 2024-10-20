<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copy extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function movie() {
        return $this->belongsTo(Movie::class);
    }

    public function format() {
        return $this->belongsTo(Format::class);
    }

    public function rentals() {
        return $this->belongsToMany(Rental::class)->withPivot('return_date')->using(CopyRental::class);
    }
}
