<?php

    $a = 15;
    $b = 10;

    echo $a += $b; // Ekvivalent sa $a = $a + $b
    echo $a -= $b; // Ekvivalent sa $a = $a - $b
    echo $a *= $b; // Ekvivalent sa $a = $a * $b
    echo $a /= $b; // Ekvivalent sa $a = $a / $b
    echo $a %= $b; // Ekvivalent sa $a = $a % $b
    echo $a .= $b; // Ekvivalent sa $a = $a . $b

    $ime = "bozidar";
    $razmak = " ";
    $prezime = "markovic";

    $ime .= $razmak; // -> "bozidar"
    $ime .= $prezime; // -> "bozidar markovic"

    echo "<br>";
    echo $ime;
    echo "<br>";

    $a = 15;
    $b = 10;

    echo $a .= $b . "<br>";