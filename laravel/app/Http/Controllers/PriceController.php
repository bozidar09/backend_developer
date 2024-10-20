<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use App\Models\Price;
use Illuminate\Validation\Rule;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::paginate(20);
    
        return view('admin.prices.index', compact('prices'));
    }


    public function create()
    {
        return view('admin.prices.create');
    }


    public function store(PriceRequest $request)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'unique:prices'],
            'price' => ['required', 'numeric', 'gt:0'],
            'late_fee' => ['required', 'numeric', 'gt:0'],
        ]);

        // Price::create([
        //     // 3 načina pozivanja sa requestom
        //     'tip_filma' => $request->get('tip_filma'),
        //     'cijena' => $request->cijena,
        //     'zakasnina_po_danu' => request()->zakasnina_po_danu,
        // ]);

        Price::create($data);

        // Price::create([
        //     'type' => $request->type,
        //     'price' => $request->price,
        //     'late_fee' => $request->late_fee,
        // ]);

        return redirect()->route('prices.index')->with('success', 'Uspješno spremljena cijena ' . $data['type']);
    }


    public function show(Price $price)
    {
        $price = Price::where('id', $price->id)->with('movies.genre', 'movies.copies.format')->first();

        return view('admin.prices.show', compact('price'));
    }


    public function edit(Price $price)
    {
        // ne treba zbog route-model bindinga
        // $price = Price::findOrFail($price);
        
        return view('admin.prices.edit', compact('price'));
    }


    public function update(PriceRequest $request, Price $price)
    {
        $data = $request->validate([
            'type' => ['required', 'string', Rule::unique('prices')->ignore($price)],
            'price' => ['required', 'numeric', 'gt:0'],
            'late_fee' => ['required', 'numeric', 'gt:0'],
        ]);

        $price->update($data);

        return redirect()->route('prices.index')->with('success', 'Uspješno promijenjena cijena ' . $data['type']);
    }


    public function destroy(Price $price)
    {
        $type = $price->type;
        try {
            $price->delete();
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Ne možete obrisati cijenu prije nego obrišete vezane filmove');
        }

        return redirect()->route('prices.index')->with('success', 'Uspješno obrisana cijena ' . $type);
    }
}
