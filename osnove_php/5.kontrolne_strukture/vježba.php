<?php

    // 1. Koristeći petlju while, ispišite prvih deset brojeva.

    $a = 1;

    while ($a <= 10) {
        if ($a == 10) {
            echo "$a";
        } else {
            echo "$a ";
        }
        $a++;
    }
    echo "<br>";


    // 2. Koristeći petlju for, ispišite visekratnike broja 3 do 100.

    for ($i = 100; $i >= 1 ; $i--) { 
        if ($i % 3 == 0) {
            if ($i / 3 == 1) {
                echo "$i";
            } else {
                echo "$i ";
            }
        }
    }
    echo "<br>";

    // 3. Tablica množenja: Napiši PHP program koji koristi petlje za generiranje tablice množenja od 1 do 10.
    //     Primjer:
    //         1 x 1 = 1
    //         2 x 2 = 2
    //         ...
    //         10 x 10 = 100

    for ($i = 1; $i <= 10 ; $i++) { 
        for ($j=1; $j <= 10 ; $j++) {
            if ($i == $j){
                echo "$i x $j = " . $i * $j . "<br>";
            }
        }
    }

    // 4. Definirajte varijablu $names i dodijelite joj niz koji sadrži pet imena.
    //     Koristeći petlju foreach, iz niza ispišite ključeve i pripadajuće im vrijednosti. 

    $names = ["Ivan", "Marko", "Matej", "Luka", "Petar"];

    foreach ($names as $key => $name) {
        $key++;
        echo "$key - $name<br>";
    }

    // 5. Ispisati imena iz niza $names spojene sa zarezom i razmakom tako da iza zadnjeg imena ne budu zarez i razmak
    //     Primjer:
    //         Harry, Ron, Hermione, Snake

    $counter = 0;

    foreach ($names as $key => $name) {  // implode (", ", $names);
        $counter++;
        if (count($names) == $counter) {  // echo ($names == end($names)) ? $name : $name . ", ";
            echo $name;  
        } else {
            echo "$name, ";
        }
    }
    echo "<br>";



    // 6. Definirajte varijable a, b i c, te im istim redoslijedom dodijelite vrijednosti 5,10 i 15.
    //     Koristeći uvjetovani tip kontrolne strukture provjerite je li vrijednost b između a i c.
    //     Ako je uvjet istinit, ispišite da je b između a i c, a ako je uvjet lažan ispišite da nije.
    //     Kod mora raditi i ako zamijenimo vrijednosti u varijablama a i c. 

    $a = 5;
    $b = 10;
    $c = 15;

    if (($a < $b && $b < $c) || ($a > $b && $b > $c)) {
        echo "$b je između $a i $c";
    } else {
        echo "$b nije između $a i $c";
    }
    echo "<br>";


    // 7. Koristeći uvjetovani tip kontrolne strukture switch ili match ispišite koji je trenutno dan u tjednu.
    //     Za ispravno izvršenu vježbu koristite PHP funkciju date(). Nazivi dana moraju biti na hrvatskom jeziku.

    $day = date("w"); // date("N");

    switch ($day) {
        case "1":
            echo "Ponedjeljak";
            break;
        case "2":
            echo "Utorak";
            break;
        case "3":
            echo "Srijeda";
            break;            
        case "4":
            echo "Četvrtak";
            break;
        case "5":
            echo "Petak";
            break;
        case "6":
            echo "Subota";
            break;
        case "7":
            echo "Nedjelja";
            break;            
        default:
            echo "Neznam koji je dan";
            break;
    }
    echo "<br>";

    $dan = match ($day) {
        "1" => "Ponedjeljak",
        "2" => "Utorak",
        "3" => "Srijeda",
        "4" => "Četvrtak",
        "5" => "Petak",
        "6" => "Subota",
        "7" => "Nedjelja",
        default => "Neznam koji je dan"
    };
    echo $dan;
