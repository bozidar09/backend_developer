<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adresar</title>
</head>
<body>
    <h2>Pregled adresa</h2>
    <table border="1">
        <tr>
        <th>Ime</th>
        <th>Adresa</th>
        <th>Grad</th>
        <th>Spol</th>
        <th>Prijatelj</th>
        <th>Avatar</th>

        </tr>
        
        <?php
            $datoteka = fopen("adresar.txt", "r");

            if ($datoteka) {
                fgets($datoteka);
                while (!feof($datoteka)) {
                    $ime = fgets($datoteka);
                    $adresa = fgets($datoteka);
                    $grad = fgets($datoteka);
                    $spol = fgets($datoteka);
                    $prijatelj = fgets($datoteka);

                    echo "<tr>";
                    echo "<td>$ime</td>";
                    echo "<td>$adresa</td>";
                    echo "<td>$grad</td>";
                    echo "<td>$spol</td>";
                    echo "<td>$prijatelj</td>";
                    if (file_exists('pictures/$ime.jpg')) {
                        echo "<td><img src='pictures/$ime.jpg'></td>";
                    } else {
                        echo "<td></td>";
                    }
                    echo "</tr>";
                }
                fclose($datoteka);
            }
        
        ?>
        </table>
        <br/>
        <a href="unos_adrese.php">Unos nove adrese</a>
</body>
</html>