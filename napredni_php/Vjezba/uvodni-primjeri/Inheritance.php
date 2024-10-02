<?php

include 'Car.php';

class PersonalCar extends Car
{

    public int $mielage;
    public string $color;
    public string $registration;

    public function __construct($m, $c, $r)
    {
        $this->mielage = $m;
        $this->color = $c;
        $this->registration = $r;

        parent::__construct();
    }

}

$pc = new PersonalCar(20000, 'blue', '112345');

dd($pc);