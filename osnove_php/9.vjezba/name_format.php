<?php

    // napraviti funkciju koja prima ime, prezime (pErO,ćOrIć) i kao rezultat vraca P. Ćorić

    function formatName(string $name): string
    {
        $nameArray = explode(",", $name);

        //  implode("|", $name);

        $name = $nameArray[0];
        $surname = $nameArray[1];

        $firstLetter = substr($name, 0, 1);  // $name[0] -> lakši način
        $firstLetter = mb_strtoupper($firstLetter);  // ucfirst()/ucwords() -> drugi način, ne radi sa čćđšž

        $urname = mb_strtolower(substr($surname, 2));
        $s = mb_strtoupper(substr($surname, 0, 2));
        
        return "$firstLetter. $s$urname";

        prettyPrint($nameArray);
    }

    $formattedName = formatName("pErO,ćOrIć");

    echo $formattedName;

    preg_match_all("/[aeiou]/i", "bozidar", $vowels);
    prettyPrint($vowels[0]);



    function prettyPrint(array $print)
    {
        echo "<pre>";
        print_r($print);
        echo "</pre>";
    }