<?php

    $names = ["aleks", "filip", "bozidar"];

    foreach ($names as $name) {
        echo "$name ";
    }

    echo "<br>";

    foreach ($names as $key => $name) {
        echo ++$key . " - $name<br>";
    }

    echo "<br>";

    $fruits = [
        ["ime" => "banana", "cijena" => "3 EUR", "klasa" => 1],
        ["ime" => "jagoda", "cijena" => "9 EUR", "klasa" => 3],
        ["ime" => "lubenica", "cijena" => "4 EUR", "klasa" => 2] 
    ];

    foreach ($fruits as $key1 => $fruit) {
        echo ++$key1 . " ";
        foreach ($fruit as $key2 => $value) {
            echo "$key2 - $value ";
        }
        echo "<br>";
    }

    // brisanje ključa iz višedimenzionalnog niza/polja

    $key = "klasa";

    foreach ($fruits as $fruit => $data) {
        foreach ($data as $attribute => $value) {
            unset($fruits[$fruit][$key]);
        }
    }

    echo "<pre>";
    print_r ($fruits);
    echo "</pre>";

    // dodavanje ključa u višedimenzionalni niz/polje

    $key = "pakiranje";

    foreach ($fruits as $fruit => $data) {
        $fruits[$fruit][$key] = "";
    }

    echo "<pre>";
    print_r ($fruits);
    echo "</pre>";
