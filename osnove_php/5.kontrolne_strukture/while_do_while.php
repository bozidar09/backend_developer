<?php

    $i = 1;

    while ($i <= 10) {
        echo "$i ";
        $i++;
    }

    echo "<br>";

    $i = 2;

    do {
        echo "$i ";
        $i += 10;
    } while ($i <= 100);

    echo "<br>";

    echo date("N"); // funkcija koja vraća datum sa raznim opcijama