<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentalRequest;
use App\Models\Copy;
use App\Models\Rental;
use App\Models\User;
use App\Services\RentalCalculatorService;
// use DateTimeImmutable;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('user', 'copies.format', 'copies.movie')->orderBy('rentals.id')->paginate(20);

        return view('admin.rentals.index', compact('rentals'));
    }


    public function create()
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
        
        return view('admin.rentals.create', compact('users', 'copies'));
    }


    public function store(RentalRequest $request)
    {
        
        $data = $request->validate([
            'user' => ['required', 'integer', 'gt:0', 'exists:users,id'],
            'copy' => ['required', 'string', 'exists:copies,barcode'],
        ]);

        DB::transaction(function() use($data) {

            $rental = Rental::create([
                'user_id' => $data['user'],
                'rental_date' => now(),
            ]);

            $copy = Copy::where('barcode', $data['copy'])->where('available', 1)->first();
            $copy->update(['available' => 0]);
            
            $rental->copies()->attach($copy->id);
        });

        return redirect()->back()->with('success', 'Uspješno spremljena posudba');
    }


    public function show(Rental $rental)
    {
        $rental = Rental::where('id', $rental->id)->with('user', 'copies.format', 'copies.movie.price', 'copies.movie.genre')->first();

        // $rental->price_total = 0;
        // foreach ($rental->copies as $copy) {
        //     // $returnDate = new DateTimeImmutable($copy->pivot->return_date) ?? new DateTimeImmutable();
        //     // $lateDays = (new DateTimeImmutable($rental->rental_date))->diff($returnDate)->format('%a');
        //     $returnDate = $copy->pivot->return_date ?? now();
        //     $lateDays = $rental->rental_date->diffInDays($returnDate);
            
        //     if ($lateDays <= 1) {
        //         $copy->late_days = 0;
        //         $copy->late_total = 0;
        //         $copy->price_total = round($copy->movie->price->price * $copy->format->coefficient, 2);
        //     } else {
        //         $copy->late_days = $lateDays - 1;
        //         $copy->late_total = round($copy->late_days * $copy->movie->price->late_fee * $copy->format->coefficient, 2);
        //         $copy->price_total = round($copy->movie->price->price * $copy->format->coefficient, 2) + $copy->late_total;
        //     }
        //     $rental->price_total += $copy->price_total;
        // } 

        $rental = (new RentalCalculatorService())->calculate($rental);

        return view('admin.rentals.show', compact('rental'));
    }


    public function edit(Rental $rental)
    {
        $rental = Rental::where('id', $rental->id)->with(['user', 'copies.movie', 'copies.format'])->first();
        
        $rental->rental_date = $rental->rental_date;
        foreach ($rental->copies as $copy) {
            $copy->pivot->return_date = $copy->pivot->return_date ?? null;
        }

        return view('admin.rentals.edit', compact('rental'));
    }


    public function update(RentalRequest $request, Rental $rental)
    {
        $rental = Rental::where('id', $rental->id)->with(['user', 'copies.movie', 'copies.format'])->first();

        DB::transaction(function() use($request, $rental) {

            $rules['rental_date'] = ['required', 'date', 'beforeOrEqual:' . date('Y-m-d H:i:s')];       
            foreach ($rental->copies as $copy) {
                $rules['return_date_' . $copy->id] = ['nullable', 'date', 'afterOrEqual:' . $rental->rental_date, 'beforeOrEqual:' . date('Y-m-d H:i:s')];
            }
            $data = $request->validate($rules);

            $returnDate = $rentalDate = $data['rental_date'];
            unset($data['rental_date']);

            foreach ($data as $key => $date) {
                $date ?? $returnDate = null;
                if ($date && $returnDate) {
                    if ($date > $returnDate) {
                        $returnDate = $date;
                    }
                }
                $available = $date ? 1 : 0;
                $copyId = explode('_', $key);

                if ($available) {
                    Copy::where('id', $copyId[2])->update(['available' => $available]);
                }
                $rental->copies()->where('id', $copyId[2])->updateExistingPivot($copyId[2], [
                    'return_date' => $date,
                ]);
            }

            $rental->update([
                'rental_date' => $rentalDate,
                'return_date' => $returnDate,
            ]);
        });

        return redirect('/rentals')->with('success', 'Uspješno izmijenjena posudba');
    }


    public function destroy(Rental $rental)
    {
        try {
            DB::transaction(function() use($rental) {

                $rental = Rental::where('id', $rental->id)->with('copies')->first();

                foreach ($rental->copies as $copy) {
                    $copy->update(['available' => 1]);
                    $rental->copies()->where('id', $copy->id)->detach($copy->id);
                }
                
                $rental->delete();
            });
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Ne možete obrisati posudbu prije nego vratite posuđene kopije');
        }

        return redirect()->route('rentals.index')->with('success', 'Uspješno obrisana posudba');
    }
}
