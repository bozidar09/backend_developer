<?php

    $primeNumbers = array(2,3,5,7,11);
    
    var_dump(isset($primeNumbers[2]));
    echo "<br>";

    // if iskaz 
    if (isset($primeNumbers[2])) {  
        echo "Treći element u nizu postoji"; 
    }
    echo "<br>";

    // if-else iskaz
    if (isset($primeNumbers[5])) {  
        echo "Treći element u nizu postoji"; 
    } else {
        echo "Treći element u nizu ne postoji";
    }
    echo "<br>";


    $a = 5;
    $b = 10;
    $c = 15;

    if ($b > $a && $b < $c || $a > $c) {
        echo "Ispisuje se kod unutar IF";
    } else {
        echo "Ispisuje se kod unutar ELSE";
    }
    echo "<br>";



    // if-elseif iskaz
    $postotakIspita = 85;

    if ($postotakIspita >= 90) {
        echo "Ocjena je 5";
    } elseif ($postotakIspita >= 80) {
        echo "Ocjena je 4";
    } elseif ($postotakIspita >= 70) {
        echo "Ocjena je 3";
    } elseif ($postotakIspita >= 60) {
        echo "Ocjena je 2";
    } else {
        echo "Pali ste na ispitu";
    }
    echo "<br>";


    if (count($primeNumbers) > 5) {
        echo "Array primeNumbers ima više od 5 zapisa";
    } elseif (count($primeNumbers) == 5) {
        echo "Array primeNumbers ima točno 5 zapisa";
    } else {
        echo "Array primeNumbers ima manje od 5 zapisa";
    }
    echo "<br>";

