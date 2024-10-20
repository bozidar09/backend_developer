<?php

namespace App\Http\Controllers;

use App\Models\Copy;
use App\Models\Rental;
use App\Models\User;
use App\Services\RentalCalculatorService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $copies = Copy::join('movies', 'movies.id', '=', 'copies.movie_id')
                ->join('formats', 'formats.id', '=', 'copies.format_id')
                ->select('copies.barcode', 'movies.id as movies_id', 'movies.title', 'movies.year',  
                'formats.id as formats_id', 'formats.type', DB::raw('count(movies.id) as amount'))
                ->where('copies.available', 1)
                ->groupBy('copies.barcode', 'movies.id', 'formats.id')
                ->orderBy('movies.title')
                ->get();
        $rentals = Rental::whereNull('return_date')->with('user', 'copies.format', 'copies.movie.price', 'copies.movie.genre')
            ->orderBy('rentals.rental_date', 'desc')->paginate(20);

        $rentalCalculator = new RentalCalculatorService();

        foreach ($rentals as $rental) {
            $rental = $rentalCalculator->calculate($rental);
        }

        return view('admin.dashboard.index', compact('users', 'copies', 'rentals'));
    }

    
    public function returnMovie(Rental $rental, Copy $copy)
    {

        DB::transaction(function() use($copy, $rental) {

            $date = now();

            $rental->copies()->updateExistingPivot($copy, ['return_date' => $date]);

            $copy->update([
                'available' => 1,
            ]);

            $flag = false;
            $copyRentals = DB::table('copy_rental')->where('copy_rental.rental_id', $rental->id)->where('copy_rental.copy_id', '!=', $copy->id)->get();
            if(count($copyRentals) != null) {
                foreach ($copyRentals as $copyRental) {
                    if ($copyRental->return_date == null) {
                        $flag = true;
                    }
                }   
            }

            $rental->update([
                'updated_at' => $date,
                'return_date' => $flag === false ? $date : null,
            ]);
        });
        
        return redirect()->route('dashboard.index')->with('success', 'Uspješno vraćen film');
    }
}
