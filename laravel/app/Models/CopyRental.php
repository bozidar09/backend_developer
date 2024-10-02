<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Relations\Pivot;
 
class CopyRental extends Pivot
{
    protected function casts(): array
    {
        return [
            'return_date' => 'immutable_datetime',
        ];
    }
}