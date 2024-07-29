<?php

    const FILE_PATH = __DIR__ . "/podaci/knjige.json"; // stvaramo konstantu za file path / putanju do datoteke

    $books = file_get_contents(__DIR__ . "/podaci/knjige.json");

    $books = json_decode($books, true);

    var_dump(is_array($books));
    echo "<br>";

    $books[] = [
        "title" => "Lord of the rings",
        "author" => "J.R.R. Tolkien",
        "available" => false,
        "pages" => 1200,
        "isbn" => 2456415364
    ];

    var_dump($books);
    echo "<br>";

    $books = json_encode($books); // pretvaranje u json
    var_dump($books);
    echo "<br>";

    file_put_contents(FILE_PATH, $books); // spremanje podataka u datoteku knjige.json

    // www-data -> ime apache servera na linuxu, treba ga stavit da je vlasnik foldera/direktorija podatci kako bi mogli koristiti file_put_contents

    