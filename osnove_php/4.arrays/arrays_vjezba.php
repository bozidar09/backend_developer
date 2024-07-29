<?php

    // vježba 1

    // inicijalizacija, punjenje i ispis indeksiranog niza/polja
    $primeNumbers = [];
    $elements = 5;

    function primeGenerator($elements, $primeNumbers) {
        $dividend = 1;
        while (count($primeNumbers) < $elements) {
            $counter = 0;
            for ($divisor = 1; $divisor <= $dividend; $divisor++) {
                if ($dividend % $divisor == 0) {
                    $counter++;
                }
            }
            if ( ! in_array($dividend, $primeNumbers) && $counter == 2) {
                $primeNumbers[] = $dividend;
            }
            $dividend++;
        }
        return $primeNumbers;
    }

    $primeNumbers = primeGenerator($elements, $primeNumbers);

    echo "<pre>";
    print_r($primeNumbers);
    echo "</pre>";
    
    //provjera postoji li treći element u nizu (index 2) te ispis
    var_dump(array_key_exists(2, $primeNumbers));
    echo "<br>";

    $index = 2;

    // echo "Treći element u nizu " . (isset($primeNumbers[2])) ? "postoji" : "ne postoji";
    function printExist($index, $primeNumbers) {
        if (isset($primeNumbers[$index])) {  // (array_key_exists($index, $primeNumbers))
            echo "Treći element u nizu je " . $primeNumbers[$index];
        } else {
            echo "Treći element u nizu ne postoji";
        }
    }

    printExist($index, $primeNumbers);
    echo "<br>";

    // dodavanje novog elementa na kraj niza
    $elements++;
    $primeNumbers = primeGenerator($elements, $primeNumbers);
    
    // broj elemenata i ispis novog niza
    echo count($primeNumbers);
    echo "<br>";

    echo "<pre>";
    print_r($primeNumbers);
    echo "</pre>";

    // silazno sortiranje niza uz zadržavanje indeksa
    arsort($primeNumbers);
    echo "<pre>";
    print_r($primeNumbers);
    echo "</pre>";




    // vježba 2 

    // inicijalizacija i ispis višedimenzionalnog niza/polja
    $users = [
        ["ime" => "aleksandar", "prezime" => "dobrinic", "godine" => 35, "spol" => "M"],
        ["ime" => "tena", "prezime" => "fiskus", "godine" => 28, "spol" => "Ž"]
    ];

    echo "<pre>";
    print_r($users);
    echo "</pre>";

    // brisanje ključa iz niza/polja
    $key = "spol";

    function eraseKey($key, $users) {
        foreach ($users as $user => $data) {    // (array_keys($users) as $user)
            unset($users[$user][$key]);   // unset($users[$user][$key])
        }
        return $users;
    }

    $users = eraseKey($key, $users);

    echo "<pre>";
    print_r($users);
    echo "</pre>";
    
    // dodavanje novog elementa
    $newUser = ["ime" => "stjepan", "prezime" => "puaca", "godine" => 30];
    $users[] = $newUser;  // array_push($users, $newUser);

    echo "<pre>";
    print_r($users);
    echo "</pre>";
