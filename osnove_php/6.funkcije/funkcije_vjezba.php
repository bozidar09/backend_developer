<?php

    // vježba 1

    function textReturn(): string
    {
        return "neki tekst";
    }

    $text = textReturn();
    echo $text;
    echo "<br>";


    // vježba 2

    function concatenate(string $name, string $surname): string
    {
        $fullName = "$name $surname";
        return mb_strtoupper($fullName);
    }

    $namePrint = concatenate("božidar", "marković");
    echo $namePrint;
    echo "<br>";


    // vježba 3

    function sumFunc(int $number): int
    {
        static $sum = 0; // static $sum;  ->  radi isto jer pretvori null u 0
        $sum += $number;
        return $sum;
    }

    $randSum = "sumFunc";

    for ($i = 1; $i <= 5; $i++) {
        echo $randSum(rand(1,10));
        echo "<br>";
    }

    // die(); -> zaustavlja kod na željenoj lokaciji
    // var_dump("opis varijable", $varijabla) -> ipisuje varijablu, a može se dodati i opis