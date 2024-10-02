<?php

    function addTwoNumbers (int $a, int $b): int // int -> definiranje tipa povratne vrijednosti
    {
        return $a + $b;
    }

    $a = 5;
    $b = 6;

    echo addTwoNumbers($a, $b);
    echo "<br>";

    $zbroj = addTwoNumbers(6, 75);
    echo "<br>";

    var_dump($zbroj);
    echo "<br>";

