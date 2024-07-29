<?php

    $postData = $_POST;
    $errors = [];

    if (!empty($postData["name"]) || !empty($postData["surname"])) {

        $name = $postData["name"];
        $surname = $postData["surname"];

        if (!empty($name)) {
            if (!preg_match('/^[\p{Latin}\s]+$/u', $name)) {  
                $errors["name"] = "Niste upisali ispravno ime<br>"; 
            } else {
                echo "Vaše ime je $name<br>";
            }
        } else {
            $errors["name"] = "Ime nije upisano<br>";
        }

        if (!empty($surname)) {
            if (!preg_match("/^[-a-z_\x{100}-\x{17f}]{2,20}+$/ui", $surname)) {
                $errors["surname"] = "Niste upisali ispravno prezime<br>";
            } else {
                echo "Vaše prezime je $surname<br>";
            }
        } else {
            $errors["surname"] = "Prezime nije upisano<br>";
        }

    } else {
        echo "Nema podataka za obradu<br>";
    }

    echo "<a href='obrazac_vjezba.php'>Obrazac</a>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obrazac</title>
</head>
<body>

    <h2>Obrazac</h2>

    <form method="POST">

        <label for="name">Ime:</label><br>
        <input type="text" id="name" name="name" required><br>

        <?php isset($errors["name"]) ? print '<p style="color:red">' . $errors["name"] . '</p>' : print ""; ?>

        <label for="surname">Prezime:</label><br>
        <input type="text" id="surname" name="surname" required><br><br>

        <p style="color:red"> <?= $errors["surname"] ?? "" ?> </p>  <!--  ?? Null coalescing operator / operator nultog spajanja  -->

        <input type="submit" value="Pošalji">

    </form> 
  
</body>
</html>


<?php

    if (isset($errors) && !empty($errors)) {
        foreach ($errors as $key => $error) {
            echo "$key - $error";
        }
    }
?>