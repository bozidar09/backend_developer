<?php

    session_start();

    //  sesija je vezana za domenu, na cijeloj domeni localhost možemo koristiti $_SESSION podatke nakon session_star()

    $_SESSION["user"] = [
        "name" => "bozidar",
        "address" => "sisak"
    ];

    session_destroy();
    var_dump($_SESSION);

    // u obradi:
    // session_start();
    // $_SESSION["error"] = "Greška!";
    // header("Location:forma.php"); 

    // u formi:
    // session_start();
    // if (isset($_SESSION["error"])) {
    //    echo $_SESSION["error"];
    //    unset($_SESSION["error"]);
    // } 