<?php

// možemo deklarirati striktne tipove podataka (a ne uobičajeno za php - varijabilne)
// declare(strict_types=1);

class Car 
{
    private string $make;
    private string $model;
    private string $fuel;
    private int $weight;

    private function belongsTo()
    {
        
    }

    public function getFullName()
    {
        return "$this->make $this->model";
    }

    // getter metoda - vraća vrijednost privatnog svojstva izvan klase
    public function getMake(): string
    {
        return $this->make;
    }

    // setter metoda - služi za postavljanje vrijednosti privatnog svojstva izvan klase
    public function setMake(string $make)
    {
        $this->make = $make;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model)
    {
        $this->model = $model;
        return $this;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }
    
    public function setWeight(int $weight)
    {
        $this->weight = $weight;
        return $this;
    }
    
    public function getFuel(): string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel)
    {
        $this->fuel = $fuel;
        return $this;
    }

    public function toArray()
    {
        return [
            "make" => $this->make,
            "model" => $this->model,
            "fuel" => $this->fuel,
            "weight" => $this->weight,
        ];
    }
}

$tesla = new Car();

// mogućnost uzastopnog pozivanja 'set' funkcija nakon dodavanja 'return this' u njih
$tesla
    ->setMake("Tesla")
    ->setModel("Model S")
    ->setWeight(2300)
    ->setFuel("Electric");

echo $tesla->getFullName();