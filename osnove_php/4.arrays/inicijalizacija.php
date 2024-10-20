<?php

    // inicijalizacija praznog niza
    $empty1 = [];
    $empty2 = array();

    // inicijalizacija niza (liste / indeksirano polje) s podacima -> Indexed array
    $names1 = ["aleks", "filip", "bozidar"];
    $names2 = array("aleks", "filip", "bozidar");

    // ispis cijelog arraya i pojedinog elementa
    echo "<pre>"; // html tag za ljepši ispis arraya
    print_r ( $names1 );
    echo "</pre>"; // end html taga
    echo $names1[0];
    echo "<br>";

    // inicijalizacija niza (mapa / asocijativno polje) s podacima -> Associative array
    $status = [
        "name" => "aleksandar dobrinic",
        "uloga" => "predavac"
    ];

    $fruits = array(
        "name" => "banana",
        "cijena" => "12 EUR",
        "klasa" => "Prva",
        // "name" => "jagoda" -> ovo bi samo prepisalo novu vrijednost u ključ "name"
    );

    echo "<pre>";
    print_r ( $fruits );
    echo "</pre>";
    echo $status["name"];
    echo "<br>";

    echo "<pre>";
    var_dump ($fruits);
    echo "</pre>";
