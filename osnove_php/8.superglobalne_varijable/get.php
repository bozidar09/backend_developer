<?php

    // var_dump($_REQUEST);
    // var_dump($_POST);
    var_dump($_GET);

    // primjer URL-a sa GET parametrima  ->  http://localhost/8.superglobalne_varijable/get.php?objekt=stolica&subjekt=predavac
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h2>GET superglobal</h2>

    <form method="GET">

        <label for="name">Ime:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="surname">Prezime:</label><br>
        <input type="text" id="surname" name="surname" required><br><br>

        <input type="submit" value="Pošalji">

    </form> 
  
</body>
</html>