<?php

    session_start();

    $_SESSION["email"] = "bozidar.markovic09@mail.com";

    echo $_SESSION["email"];
    echo "<br>";


    session_destroy();

    echo $_SESSION["email"]; // podaci ostaju zapisani u varijabli i nakon zatvaranja sessiona
    echo "<br>";
        
    unset($_SESSION["email"]);
    var_dump($_SESSION["email"]); // varijablu treba unset-ati ili postaviti na NULL da bi se podatci sessiona izbrisali