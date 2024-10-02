<?php

namespace Vjezbe;

class Bicikl extends Vehicle implements Driveable
{
    private int $masinica;
    private string $lulaVolana;
    private string $vilica;

    public function drives() 
    {
        return 'It drives!';
    }
}
