<?php

    $name = "Mirko"; // globalna varijabla koja nema doseg unutar funkcije

    function variableScoper()
    {
        $surname = "Svemirko";
        echo $surname;
    }

    // var_dump($surname); lokalna varijable koja vraća grešku van funkcije

    variableScoper();
    echo "<br>";


    function staticScope()
    {
        static $a = 0;
        echo $a;
        $a++;
    }

    staticScope();
    staticScope();
    staticScope();
