<?php

    $empty_array = [];
    $names = ["aleks", "filip", "bozidar"];
    $names2 = ["tomislav", "hrvoje"];


    // provjera je li varijabla prazna
    $is_variable_empty = empty($names); 
    var_dump($is_variable_empty);
    echo "<br>";

    // provjera je li varijabla postavljena/inicijalizirana
    var_dump ( isset ($empty_array) );
    echo "<br>";

    // provjera je li nešto u nizu/polju
    var_dump ( in_array ("aleks", $names) );
    echo "<br>";

    var_dump( array_search ("filip", $names) );
    echo "<br>";

    // sortiranje -> https://www.php.net/manual/en/array.sorting.php
    arsort($names);
    
    echo "<pre>";
    print_r ( $names );
    echo "</pre>";

    ksort($names);

    echo "<pre>";
    print_r ( $names );
    echo "</pre>";


    // push & pop
    array_push($names, "tena");

    echo "<pre>";
    print_r ( $names );
    echo "</pre>";

    $last_element = array_pop($names); // uzimamo zadnju vrijednost iz arraya
    print_r ( $last_element );
    echo "<br>";

    $first_element = array_shift($names); // uzimamo prvu vrijednost iz arraya i reindeksiramo ga
    print_r ( $first_element );
    echo "<br>";

    echo "<pre>";
    print_r ( $names );
    echo "</pre>";

    // ispis vrijednosti niza/polja
    var_dump (array_keys($names));
    echo "<br>";
    var_dump (array_values($names));
    echo "<br>";
    var_dump (count($names));
    echo "<br>";

    // spajanje dva niza/polja
    $merged = array_merge ($names, $names2);
    echo "<pre>";
    var_dump ($merged);
    echo "</pre>";
