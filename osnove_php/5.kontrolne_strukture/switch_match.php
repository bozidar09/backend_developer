<?php

    $variable = 5;

    switch ($variable) {
        case 1:
            echo "Ponedjeljak";
            break;
        case 2:
            echo "Utorak";
            break;
        case 3:
            echo "Srijeda";
            break;            
        case 4:
            echo "Četvrtak";
            break;
        default:
            echo "Neznam koji je dan";
            break;
    }
    echo "<br>";

    
    $variable = "uto";

    switch ($variable) {
        case "pon":
            echo "Ponedjeljak";
            break;
        case "uto":
            echo "Utorak";
            break;
        case "sri":
            echo "Srijeda";
            break;            
        case "ćet":
            echo "Četvrtak";
            break;
        default:
            echo "Neznam koji je dan";
            break;
    }
    echo "<br>";


    // falling through
    $variable = "sub";

    switch ($variable) {
        case "pon":
        case "uto":
        case "sri":           
        case "čet":
        case "pet":
            echo "Rad";
            break;    
        case "sub":
        case "ned":
            echo "Odmor";
            break;
        default:
            echo "Neznam koji je dan";
            break;
    }
    echo "<br>";


    $dan = match ($variable) {
        "pon" => "Ponedjeljak",
        "uto" => "Utorak",
        "sri" => "Srijeda",
        default => "Neznam koji je dan"
    };
    echo $dan;
    echo "<br>";
