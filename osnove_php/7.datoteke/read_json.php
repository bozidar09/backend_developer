<?php

    $books = file_get_contents(__DIR__ . "/podaci/knjige.json");  // __DIR__  ->  ako nije u istom folderu onda treba cijelu putanju
    // $webPage = file_get_contents("https://www.podravka.hr"); -> može dohvatiti bilo koju datoteku

    echo $books;
    echo "<br>";

    json_decode($books, true);

    var_dump($books);