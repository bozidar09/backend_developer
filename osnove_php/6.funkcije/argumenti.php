<?php

    function addNumbers(int $a, int $b, bool $printResult = false): ?int  // ?int -> return null or int
    {
        $sum = $a + $b;
        if ($printResult){
            echo "rezultat je " . $sum;
            return null;
        }
        return $sum;
    }

    var_dump(addNumbers(3, 4));
    echo "<br>";

    addNumbers(3, 4, true);
    echo "<br>";

    echo addNumbers(3, 4, false);
    echo "<br>";

