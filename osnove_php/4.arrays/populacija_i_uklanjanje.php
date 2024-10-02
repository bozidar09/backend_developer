<?php

    // dodavanje elementa u niz

    $names = ["aleks", "filip", "bozidar"];
    $names[5] = "tomislav"; // možemo dodati na proizvoljnu poziciju
    $names[] = "tena"; // dodao bi nakon posljednjeg indeksiranog


    echo "<pre>";
    print_r ($names);
    echo "</pre>";

    $fruits = [
        "ime" => "banana",
        "cijena" => "12 EUR",
        "klasa" => 1
    ];

    $fruits["masa"] = 2;
    $fruits["klasa"] = 3;


    echo "<pre>";
    print_r ($fruits);
    echo "</pre>";

    
    // uklanjanje elementa iz niza

    unset ($fruits["ime"]);

    echo "<pre>";
    print_r ($fruits);
    echo "</pre>";