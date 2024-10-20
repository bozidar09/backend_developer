<?php

    function echoIt($string)
    {
        echo $string;
    }

    echoIt("bozidar");
    echo "<br>";

    $func = "echoIt";
    $func("aleks"); // poziv varijable kao funkcije
    echo "<br>";
