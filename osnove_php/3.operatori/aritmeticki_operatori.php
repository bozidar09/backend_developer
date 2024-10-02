<?php

    $a = 15;
    $b = -5;

    echo $a - $b;
    echo "<br>";
    echo $a + $b;
    echo "<br>";
    echo $a * $b;
    echo "<br>";
    echo $a / $b;
    echo "<br>";

    // operator Modulo - vraća ostatak od dijeljenja
    echo $a % $b;
    echo "<br>";
    echo 11 % 4;
    echo "<br>";

    // Modulo i usporedba
    echo (9 % 4 == 0) ? "true" : "false";
    echo "<br>";

    // konkatenacija
    $a = "Algebra";
    $b = "Osnove";
    $c = "PHP";

    echo $a . $b . $c;
    echo "<br>";
    var_dump ($a . $b . $c);