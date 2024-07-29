<?php

    // višedimenzionalni niz/polje (indeksirano - asocijativno)

    $fruits = [
        ["ime" => "banana", "cijena" => "3 EUR", "klasa" => 1],
        ["ime" => "jagoda", "cijena" => "9 EUR", "klasa" => 3],
        ["ime" => "lubenica", "cijena" => "4 EUR", "klasa" => 2] 
    ];

    echo "<pre>";
    print_r ($fruits);
    echo "</pre>";

    echo "<pre>";
    echo $fruits [0]["ime"];
    echo "</pre>";


    // višedimenzionalni niz/polje (asocijativno - asocijativno)

    $fruits2 = [
        "banana" => ["ime" => "banana", "cijena" => "3 EUR", "klasa" => 1],
        "jagoda" => ["ime" => "jagoda", "cijena" => "9 EUR", "klasa" => 3],
        "lubenica" => ["ime" => "lubenica", "cijena" => "4 EUR", "klasa" => 2] 
    ];

    echo "<pre>";
    print_r ($fruits2);
    echo "</pre>";

    echo "<pre>";
    echo $fruits2 ["lubenica"]["cijena"];
    echo "</pre>";