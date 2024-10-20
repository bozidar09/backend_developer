<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    // dopuštenje što se smije popuniti
    // protected $fillable = ['type', 'price', 'late_fee'];

    // dopuštenje što se jedino treba zaštititi 
    protected $guarded = ['id'];

    public function movies() {
        return $this->hasMany(Movie::class);
    }
}
