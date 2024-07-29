<?php

    $a = 10;
    $b = 20;

    $a++; // ekvivalent je $a + 1;
    ++$b;

    echo $b; // 21
    echo "<br>";

    echo $b--; // prvo ispiše 21 onda oduzme $b - 1;
    echo "<br>";

    echo --$b; // prvo oduzme $b - 1; pa onda ispiše 19
    echo "<br>";


    // prioriteti logičkih operacija
    // ()
    // !
    // */
    // %
    // +-
    // <> <= >=
    // !== != == ===
    // &&
    // ||