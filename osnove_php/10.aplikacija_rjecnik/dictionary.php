<?php

    $dataDir = __DIR__ . "/data";
    const FILE_PATH = __DIR__ . "/data/words.json";
    
    // ako direktorij i datoteka na putanji "/data/words.json" ne postoje stvaramo ih
    if (!is_dir($dataDir)) {
        if(!mkdir($dataDir, 0774, true)) {
            die("<br>Nemate ovlasti stvoriti direktorij!");
        }
    }

    if (!file_exists(FILE_PATH)) {
        if (file_put_contents(FILE_PATH, '') != false){  // koristimo operator "!=" kako se stvorena prazna datoteka ne bi okarakterizirala kao "false"
            die("<br>Nemate ovlasti stvoriti datoteku!");
        }
    }

    // funkcija dohvaća podatke iz datoteke i pretvara ih u array
    function getDecode(string $filePath): array
    {
        if (($tempArray = file_get_contents($filePath)) === false) {
            die("<br>Greška čitanja datoteke!");
        } else {
            if (($tempArray = json_decode($tempArray, true)) === false) {
                die("<br>Greška dekodiranja datoteke!");
            } elseif (!empty($tempArray)) {
                return $tempArray;
            } else {
                $tempArray = [];
                return $tempArray;
            }
        }
    }

    // funkcija pretvara podatke u json tip i sprema ih u datoteku
    function encodePut(array $newData, string $filePath): void
    {
        if (($tempArray = json_encode($newData)) === false) {
            die("<br>Greška kodiranja datoteke!");
        } else {
            if (file_put_contents($filePath, $tempArray) === false) {  // dodajemo nove podatke na kraj datoteke
                die("<br>Greška spremanja datoteke!");
            }
        }
    }
    
    // funkcija za brojanje suglasnika
    function countConsonants(string $word): int
    {  
        if ((preg_match_all("/[b-df-hj-np-tv-z\x{100}-\x{17f}]/ui", $word, $consonants)) !== false) {  // ovdje u funkciji preg_match_all koristimo regularni izraz za pronalazak svih suglasnika u riječi
            return count($consonants[0]);  // brojimo elemente prvog retka dvodimenzionalnog indeksiranog arraya gdje se nalaze svi pogođeni suglasnici
        } else {
            return 0;
        }
    }
    // function countConsonants(string $word) : int
    // {  
    //     if (($consonants = preg_replace("/[aeiou]/i", "", $word)) !== false) {  // ovdje u funkciji preg_replace koristimo regularni izraz za pronalazak i brisanje samoglasnika iz riječi
    //         return mb_strlen($consonants);  // ugrađena funkcija koja ispravno broji slova u stringu (uključujući naše čćđšž)
    //     } else {
    //         return 0;
    //     }
    // }

    // funkcija za brojanje samoglasnika
    function countVowels(string $word): int
    {  
        if ((preg_match_all("/[aeiou]/i", $word, $vowels)) !== false) {  // ovdje u funkciji preg_match_all koristimo regularni izraz za pronalazak svih samoglasnika u riječi
            return count($vowels[0]);  // brojimo elemente prvog retka dvodimenzionalnog indeksiranog arraya gdje se nalaze svi pogođeni samoglasnici
        } else {
            return 0;
        }
    }

    // function countVowels(string $word): int
    // {
    //     $counter = 0;
    //     $word = str_split($word);
    //     $vowels = "aeiou";
    //     foreach ($word as $letters) {
    //         if (str_contains($vowels, mb_strtolower($letters))) {  // str_contains() vraća true ako niz sadrži određeno slovo
    //             $counter++;
    //         }
    //     }
    //     return $counter;
    // }

    // function countVowels(string $word): int
    // {
    //     $counter = 0;
    //     $counter += substr_count($text, 'a');  //  substr_count() vraća broj pojavljivanja određenog stringa (u ovom slučaju jednog slova)
    //     $counter += substr_count($text, 'e');
    //     $counter += substr_count($text, 'i');
    //     $counter += substr_count($text, 'o');
    //     $counter += substr_count($text, 'u');
    //     return $counter;
    // }

    // funkcija za ispis tablice riječi
    function printWordRows(array $words): void
    {
        foreach ($words as $word) {
            echo "<tr>";
                echo "<td>" . $word['word'] . "</td>";
                echo "<td>" . $word['letters'] . "</td>";
                echo "<td>" . $word['consonants'] . "</td>";
                echo "<td>" . $word['vowels'] . "</td>";
            echo "</tr>";     
        }
    }
    
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rječnik</title>
    </head>
    <body>

        <br>
        <h2 align="center">Upišite željenu riječ!</h2>
        <br><br>

        <div id="parent" style="display: flex;">

            <div id="left" style="flex-basis: 50%;">

                <form method="POST" action="dictionary.php">

                    <label for="word">Upišite riječ:</label><br>
                    <input type="text" id="word" name="word"><br><br>

                    <input type="submit" value="Pošalji">

                    <?php

                        if (empty($_POST["word"])) {

                            die("<br><br>Morate upisati riječ!");

                        } else {

                            $word = $_POST["word"];

                            if (!preg_match("/^[a-z\x{100}-\x{17f}]{2,20}+$/ui", $word)) {  // funkcija preg_match koristi regularni izraz koji provjerava sastoji li se upisana riječ samo od slova        
                                
                                die("<br><br>Riječ mora biti sastavljena samo od slova, bez razmaka i specijalnih znakova!");  

                            } else {

                                $letters = mb_strlen($word); 
                                $consonants = countConsonants($word);
                                $vowels = countVowels($word);

                                $words = getDecode(FILE_PATH); 

                                $words[] = [
                                    "word" => $word,
                                    "letters" => $letters,
                                    "consonants" => $consonants,
                                    "vowels" => $vowels
                                ];
                                $words = array_unique($words, SORT_REGULAR);  // ugrađena php funkcija koja rješava problem duplikata 

                                encodePut($words, FILE_PATH);
                                
                            }
                        }

                    ?>

                </form>

            </div>

            <div id="right" style="flex-basis: 50%;">

                <br>
                
                <table border="1">
                    <tr align="left">
                        <th>Riječ</th>
                        <th>Broj slova</th>
                        <th>Broj suglasnika</th>
                        <th>Broj samoglasnika</th>
                    </tr>
                    
                    <?php 

                        printWordRows($words);  

                    ?> 

                </table>

            </div>
                
        </div> 

    </body>
</html>