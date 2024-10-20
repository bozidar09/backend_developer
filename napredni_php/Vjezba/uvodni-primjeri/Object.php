<?php 

function dd($var): void
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

// OOP -> object oriented programming

// klasa (nacrt)
class Korisnik 
{
    // properties/svojstva sa identifikatorima vidljivosti
    public $ime;
    public $godine;
    protected $adresa;
    public $spol;

    // methods/metode
    public function posudjujeFilm()
    {
        // pomoću ključne riječi $this pristupamo svojstvima i metodama unutar klasa
        $this->ime = "Alex";
        $this->seUclanjuje();

        // varijabla $godine lokalna je unutar metode posudjujeFilm()
        $godine = 39;
        
        echo $this->ime . "je posudio film" . $godine;
    }

    private function seUclanjuje()
    {
        echo "Korisnik je učlanjen";
    }
}

// objekt (instanca klase, tip varijable koji sadrži svojstva/varijable i metode/funkcije)
$tena = new Korisnik();
$tena->ime = "Tena";
$tena->spol = "Ž";
$tena->posudjujeFilm();

$ari = new Korisnik();
$ari->ime = "Arijan";
$ari->spol = "M";
$ari->posudjujeFilm();

$korisnik = new Korisnik();
$korisnik->ime = "Aleksandar";
$korisnik->spol = "M";
$korisnik->posudjujeFilm();

dd($korisnik);