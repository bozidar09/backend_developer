<?php

    $expiresIn = time() + 60 * 60;

    setcookie("email", "bozidar.markovic09@mail.com", $expiresIn, "/");  // stvaranje cookiea

    var_dump($_COOKIE);
    echo "<br>";

    setcookie ("email", "", $expiresIn - 1, "/");  // brisanje cookiea