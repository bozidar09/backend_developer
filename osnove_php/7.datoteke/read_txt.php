<?php

    const FILE_PATH = __DIR__ . "/podaci/users.txt";  // file_exists funkcija za provjeru

    try {

        if (!file_exists(FILE_PATH)){
            throw new Exception("File doesn't exist: " . FILE_PATH);
        }

        if (is_dir(FILE_PATH)){
            throw new Exception("File doesn't exist: " . FILE_PATH);
        }

        $pointer = fopen(FILE_PATH, "r");
        if ($pointer == false){
            throw new Exception("Unable to open the file: " . FILE_PATH);
        }

        if($pointer !== false){
            while(($line = fgets($pointer)) !== false){  // !feof($pointer)  ->  druga opcija za while
                echo $line . "<br>";
            }
            fclose($pointer);
        } else {
            echo "Unable to open the file";
        }    
    } catch (\Exception $exception) {
        echo $exception->getMessage();
    }

    // file_get_contents funkcija