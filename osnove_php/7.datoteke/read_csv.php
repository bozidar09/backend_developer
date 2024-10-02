<?php

    const USERS_CSV = __DIR__ . "/podaci/users.csv";

    // https://www.php.net/manual/en/function.fopen.php -> čita datoteku
    // https://www.php.net/manual/en/function.fgetcsv.php -> čita red datoteke

    if(($handle = fopen(USERS_CSV, "r")) !== false){  // u if-u možemo i spremiti u varijablu, i usporediti -> štedi resurse procesora

        $headers = fgetcsv($handle);  // čitamo prvi redak sa zaglavljem
        $data = [];

        while(($row = fgetcsv($handle)) !== false){   // u while također spremamo u varijablu te potom uspoređujemo
            $data[] = array_combine($headers, $row);  // array_combine()  ->  za napraviti asocijativni array
        };

        fclose($handle);  // zatvaranje streama prema datoteci
        var_dump($data);
        
    } else {
        echo "unable to open the file";
    };  
    
    //https://www.php.net/manual/en/function.fread.php -> čita bilo koju datoteku, ne samo csv