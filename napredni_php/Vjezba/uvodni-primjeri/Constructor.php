<?php 

include "car.php";

function dd($var): void
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

class Vlasnik 
{
    private string $ime;
    private string $prezime;
    private int $godine;
    private string $spol;
    // ? -> nullable string (ovaj property može biti ili string ili NULL)
    private ?string $adresa;
    // dodavanje jednog objekta unutar druge klase -> dependency injection
    private Car $car;

    public function __construct(Car $car, string $ime, string $prezime, int $godine, string $spol, ?string $adresa)
    {
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->godine = $godine;
        $this->spol = $spol;
        $this->adresa = $adresa;
        $this->car = $car;
    }

    public function posjeduje()
    {
        return $this->car;
    }
}

$car = new Car();
$car
        ->setMake("Tesla")
        ->setModel("Model S")
        ->setFuel("Electric")
        ->setWeight(2300);

$bozidar = new Vlasnik($car, "bozidar", "markovic", 99, "M", NULL);
dd($bozidar->posjeduje());