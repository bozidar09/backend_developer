<?php

    /*
    * višelinijski komentar
    */

    /*
    * Ova funkcija ispisuje Brake line HTML tag
    */
    function printBrakeRow() 
    { // kod funkcija { zagrada ide u novi red
        echo "<br>";
    }

    function randomText() 
    {
        return "neki tekst";
    }

    function printRepeat(int $repetition = 1)  // "= 1" -> defaultni parametar ako ništa nije definirano, "int" -> uvjetovanje da argument mora biti cijeli broj
    { 
        echo str_repeat("bozidar", $repetition);
    }

    // pozivanje
    echo randomText();
    printBrakeRow();
    printRepeat(5);
    echo "<br>";



    // funkcija bez parametara
    function bozidar()
    {
        echo "hello bozidar";
    }

    bozidar();
    echo "<br>";


    // funkcija sa jednim parametrom
    function writeName(string $name): void // void -> tip povratne vrijednosti
    {
        echo "hello $name";
    }

    writeName("aleks");
    echo "<br>";
