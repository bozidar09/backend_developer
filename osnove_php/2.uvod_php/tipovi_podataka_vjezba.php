<?php

    // brojevi
    $cijeli_broj = 4;
    $realni_broj = 2.99;
    $tekstualan_podatak = "neki tekst";
    $logicka_vrijednost = false;

    echo $cijeli_broj;
    echo "<br>";
    echo $realni_broj;
    echo "<br>";
    echo $tekstualan_podatak;
    echo "<br>";
    echo $logicka_vrijednost ? "true" : "false";
    echo "<br>";

    var_dump ($logicka_vrijednost);
    echo "<br>";

    // konstante
    define("ABSOLUTE_ZERO", "−273.15");
    const IBAN = "HR5902589275020952";

    echo ABSOLUTE_ZERO;
    echo "<br>";
    echo IBAN;
    echo "<br>";
    print IBAN;
    print "<br>";

    // reference
    $a = 5;
    $b = &$a;

    echo "Prije promjene vrijednosti a " . $b;
    echo "<br>";
    
    $a = 6;
    echo "Nakon promjene vrijednosti a " . $b; // vrijednost b je 6

