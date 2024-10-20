<?php

    // imena varijabla osjetljiva su na velika i mala slova
    $ime = "bozidar";
    $Ime = "Bozidar";

    echo $ime;
    echo "<br>";
    echo $Ime;

    // primjeri neispravne definicije imena varijable
    // $123ime;
    // $-ime;
    // $ ime;

    // nakon znaka $ ime varijable može započeti sa slovom ili _ (donja crta)
    // primjeri ispravne definicije imena varijable
    $_ime;
    $ime123;
    $ime_prezime_i_adresa; // -> snake case
    $imePrezimeIAdresa; // -> camel case

    // KONSTANTE
    // imena konstanti trebalo bi pisati velikim slovima
    define("PI", "3,14");
    const OIB = 49568309505;

    echo PI;
    echo "<br>";
    echo "Vaš OIB je " . OIB . ", a ime je " . $Ime . ".";
