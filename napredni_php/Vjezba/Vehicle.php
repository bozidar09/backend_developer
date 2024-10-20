<?php

namespace Vjezbe;

class Vehicle 
{
    private string $tip;
    private string $kategorija;
    private int $masa;

    public function __construct(string $tip, string $kategorija, int $masa)
    {
        $this->tip = $tip;
        $this->kategorija = $kategorija;
        $this->masa = $masa;

    }

    public function getTip()
    {
        return $this->tip;
    }

    public function getKategorija(): string
    {
        return $this->kategorija;
    }

    public function getMasa(): string
    {
        return $this->masa;
    }

}

