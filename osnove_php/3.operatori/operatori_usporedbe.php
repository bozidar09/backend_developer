<?php

    $a = 10;
    $b = 5;
    $c = "10";
    $d = 10;

    var_dump ($a > $b); // true
    echo "<br>"; 
    var_dump ($a < $b); // false
    echo "<br>";
    var_dump ($a >= $b); // true
    echo "<br>";
    var_dump ($a <= $b); // false
    echo "<br>";

    var_dump ($a == $b); // false
    echo "<br>";

    // varijabla $a je jednaka $c
    // provjerava da li su vrijednosti iste/različite
    var_dump ($a == $c); // true
    echo "<br>";
    var_dump ($a != $c); // false
    echo "<br>";

    // varijabla $a nije identična $c
    // provjerava da li su vrijednosti i tip podatka isti/različiti
    var_dump ($a === $c); // false
    echo "<br>";
    var_dump ($a === $d); // true
    echo "<br>";
    var_dump ($a !== $c); // true
    echo "<br>";
    var_dump ($a !== $d); // false
    echo "<br>";
