<?php

    $a = 10;
    $b = 0;

    // promjena tipa podatka i logička provjera
    var_dump ((bool) $a);
    echo "<br>";

    var_dump (!$a); // false
    echo "<br>";

    // operator && zahtjeva da su svi izrazi istiniti kako bi vratio true
    var_dump ($a && $b); // false
    echo "<br>";
    var_dump ($a and $b); // false
    echo "<br>";

    // operator || zahtjeva da je bar jedan izraz istinit kako bi vratio true
    var_dump ($a || $b); // true
    echo "<br>";
    var_dump ($a or $b); // true
    echo "<br>";

    var_dump ( ! ($a > $b) && ($b == $a) ); // false
    echo "<br>";

    // vrijednosti koje vraćaju FALSE
    $var = false;
    $var = 0;
    $var = 0.0;
    $var = "";
    $var = "0";
    $var = [];
    $var = NULL;

    if ( ! $var ) {
        echo "Izraz je istinit.";
    }
