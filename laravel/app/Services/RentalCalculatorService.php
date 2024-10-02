<?php

namespace App\Services;

use App\Models\Rental;

class RentalCalculatorService
{
    public function calculate(Rental $rental) 
    {
        $rental->price_total = 0;
        foreach ($rental->copies as $copy) {
            $returnDate = $copy->pivot->return_date ?? now();
            $lateDays = $rental->rental_date->diffInDays($returnDate);
            
            if ($lateDays <= 1) {
                $copy->late_days = 0;
                $copy->late_total = 0;
                $copy->price_total = round($copy->movie->price->price * $copy->format->coefficient, 2);
            } else {
                $copy->late_days = $lateDays - 1;
                $copy->late_total = round($copy->late_days * $copy->movie->price->late_fee * $copy->format->coefficient, 2);
                $copy->price_total = round($copy->movie->price->price * $copy->format->coefficient, 2) + $copy->late_total;
            }
            $rental->price_total += $copy->price_total;
        } 

        return $rental;
    }
}