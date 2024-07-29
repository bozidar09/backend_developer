<?php

    var_dump(time());
    echo "<br>";

    $expiresIn = time() + 60 * 60;

    setcookie("user", "bozidar", $expiresIn, "/");  // stvaranje cookiea

    var_dump($_COOKIE);

    setcookie("user", "", time() - 60 * 60, "/");  // brisanje cookiea