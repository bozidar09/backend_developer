<?php

    $podaci = $_POST;
    var_dump($podaci);

    if (!empty($podaci)) {
        echo "<br>";

        echo "Kliknuto na pošalji";

        $ime = $podaci["name"];
        $prezime = $podaci["surname"];

        if (empty($ime)) {
            echo "$ime je obavezno";
        }
        if ($prezime = "") {
            echo "$prezime je obavezno";
        }


        echo "<br>";
        echo "Vaše ime je $ime, a prezime $prezime.";
        echo "<br>";

    } else {
        echo "Nije kliknuto na pošalji";
    }

?>