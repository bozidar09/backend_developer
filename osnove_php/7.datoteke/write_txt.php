<?php

    const FILE_PATH = __DIR__ . "/podaci/users.txt";

    $pointer = fopen(FILE_PATH, "a"); // "a" -> dodavanje na kraj datoteke
    $tekst = "Nikolina Pelivan\n";

    if($pointer !== false){
        if (fwrite($pointer, $tekst)){
            echo "Uspjeh!";
        } else{
            echo "Unable to append to a file";
        }
        fclose($pointer);
    } else {
        echo "Unable to open the file";
    }

    // file_put_contents funkcija