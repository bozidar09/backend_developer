<?php

    // 1. Pročitajte podatke iz datoteke polaznici.json, te ih ispišite u HTML tablicu.
    // 2. Dodajte novog polaznika u datoteku polaznici.json, te podatke iz nje ponovo ispišite.


    // u terminalu:
    // sudo usermod -aG bozidar www-data  ->  dodavanje apache u vlastitu grupu "bozidar"
    // sudo chmod 664 ./podaci/polaznici.json  ->  dodavanje korisnicima u vlastitoj grupi write ovlasti nad datotekom polaznici.json
    // sudo systemctl reload apache2  ->  restart apache servera


    const FILE_PATH = __DIR__ . "/podaci/polaznici.json";


    // funkcija dohvaća podatke iz datoteke i pretvara ih u array
    function getDecode(string $filePath): array
    {
        if (($tempArray = file_get_contents($filePath)) !== false) {
            if (($tempArray = json_decode($tempArray, true)) !== false) {
                return $tempArray;
            } else {
                echo "Greška dekodiranja datoteke!";
            }
        } else {
            echo "Greška čitanja datoteke!";
        }
    }
    

    // funkcija pretvara podatke u json tip i sprema ih u datoteku
    function encodePut(array $newData, string $filePath): void
    {
        if (($tempArray = json_encode($newData)) !== false) {
            if ((file_put_contents($filePath, $tempArray)) == false) {  // FILE_APPEND -> opcija za dodavanje na kraj datoteke
                echo "Greška spremanja datoteke!";
            }
        } else {
            echo "Greška kodiranja datoteke!";
        }
    }


    // funkcija za brisanje zadnjeg elementa iz json datoteke (sa ciljem kako bi se prva i druga tablica razlikovale nakon reloada stranice) 
    function getPopPut(string $filePath): void
    {
        $tempArray = getDecode($filePath);
        if (array_pop($tempArray) == NULL) {
            echo "Datoteka je prazna!";
        }
        encodePut($tempArray, $filePath);
    }

    // funkcija za ispis tablice polaznika
    function printStudentsTable(array $students) : void
    {
        echo "<table border='1'>";
            echo "<tr>";
                echo "<th> Ime </th>";
                echo "<th> Prezime </th>";
                echo "<th> Godine </th>";
                echo "<th> Email </th>";
                echo "<th> Telefon </th>";
            echo "</tr>";
        foreach ($students as $student) {
            echo "<tr>";
                echo "<td>" . $student['name'] . "</td>";
                echo "<td>" . $student['surname'] . "</td>";
                echo "<td>" . $student['age'] . "</td>";
                echo "<td>" . $student['email'] . "</td>";
                echo "<td>" . $student['phone'] . "</td>";
            echo "</tr>";     
        }
        echo "</table>";
    }

?>


<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Datoteke vježba</title>
    </head>
    <body>

        <?php

        $students = getDecode(FILE_PATH);
        printStudentsTable($students);
        echo "<br>";

        $students[] = [
            "name" => "Borna",
            "surname" => "Borić",
            "age" => 29,
            "email" => "borna.boric@gmail.com",
            "phone" => 38595666777
        ];
        $students = array_unique($students, SORT_REGULAR);  // ugrađena php funkcija koja rješava problem duplikata

        encodePut($students, FILE_PATH);
        $students = getDecode(FILE_PATH);
        printStudentsTable($students);

        getPopPut(FILE_PATH);

        ?>

    </body>
</html>

<?php  ?>
    