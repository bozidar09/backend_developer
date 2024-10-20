<?php

    // definiranje varijabli 
    $a = 16;
    $b = 7;
    $c = 11.75;
    $d = 5.33;

    // aritmetičke operacije
    echo $a - $b;
    echo "<br>";
    echo $a + $b;
    echo "<br>";
    echo $a * $b;
    echo "<br>";
    echo $a / $b;
    echo "<br>";
    echo $a % $b;
    echo "<br>";

    // konkatenacija
    $f = $c . $d;
    echo $f;
    echo "<br>";

    // kombinirani operator dodjele
    echo $a *= $b;
    echo "<br>";

    // operator usporedbe
    var_dump ($a < $b);
    echo "<br>";


    // logički operator
    var_dump ( !($a < $b) && $c > $d );
    echo "<br>";

    // operator inkrementa
    echo ++$a;
    echo "<br>";

    // operator dekrementa sa printom
    print --$b;
    echo "<br>";
