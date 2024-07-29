<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adresar</title>
</head>
<body>
    <h2>Spremljena adresa</h2>

    <?php
        $ime = $_POST["name"];
        $adresa = $_POST["address"];
        $grad = $_POST["town"];

        if (isset($_POST["gender"])){
            if ($_POST["gender"] == "M"){ 
                $spol = "muški";
            } else {
                $spol = "ženski";
            }
        } else {
            $spol = ""; 
        }

        if (isset($_POST["follower"])){
            $pratitelj = "da";
        } else {
            $pratitelj = "ne";
        }

        if (isset($_POST["picture"])){
            $avatar = $_POST["picture"];
        } else {
            $avatar = "";
        }
        
        echo "Ime: $ime <br/>";
        echo "Adresa: $adresa <br/>";
        echo "Grad: $grad <br/>";
        echo "Spol: $spol <br/>";
        echo "Pratitelj: $pratitelj <br/>";
        echo "Avatar: $avatar <br/>";

        $datoteka = fopen("adresar.txt", "a");
        fwrite($datoteka, "\n$ime\n$adresa\n$grad\n$spol\n$pratitelj");
        fclose($datoteka);

        if ($_FILES["picture"]["name"] && $_FILES["picture"]["size"] != 0) {
            move_uploaded_file($_FILES["picture"]["tmp_name"], "pictures/$ime");
        }
    ?>
    <br/>
    <a href="unos_adrese.php">Unos nove adrese</a>
    &nbsp;
    <a href="pregled_adresa.php">Pregled adresa</a>
</body>
</html>