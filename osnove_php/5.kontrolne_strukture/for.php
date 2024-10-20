<?php

    for ($i = 0; $i < 10; $i++) { 
        echo "$i ";
    }

    echo "<br>";

    for ($i = 20; $i >= 10; $i--) { 
        echo "$i ";
    }

    echo "<br>";

    // traženje
    for ($i = 0; $i <= 10; $i++) { 
        echo "$i ";
        if ($i == 5) {
            echo "<br> broj 5 je pronađen";
            break;
        }
    }

    echo "<br>";

    // filtriranje
    for ($i = 0; $i <= 10; $i++) { 
        if ($i == 5) {
            continue;
        }
        echo "$i ";
    }

    echo "<br>";

    // ugnježđene petlje
    for ($i = 0; $i <= 10; $i++) { 
        echo "$i - ";
        for ($j=0; $j <= 10; $j++) { 
            echo "$i ";
        }
        echo "<br>";
    }

    echo "<br>";

    $names = ["aleks", "filip", "bozidar"];

    for ($i = 0; $i < count($names); $i++) { 
        echo $names[$i] . " ";
    }
