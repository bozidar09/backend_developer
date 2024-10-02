<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator</title>
</head>
<body>

    <h2>Kalkulator</h2>

    <br>

    <form method="POST">

        <label for="operand1">Prva vrijednost:</label><br>
        <input type="text" id="operand1" name="operand1" default=NULL><br><br>

        <label for="operation">Aritmetička operacija</label>
            <input type="radio" name="operation" id="operation" value="+"> +
            <input type="radio" name="operation" id="operation" value="-"> -
            <input type="radio" name="operation" id="operation" value="x"> x
            <input type="radio" name="operation" id="operation" value="/"> /

        <br><br>

        <label for="operand2">Druga vrijednost:</label><br>
        <input type="text" id="operand2" name="operand2" default=NULL><br><br>

        <input type="submit" value="Izračunaj">

        <br><br>

    </form> 
  
</body>
</html>

<?php

    if (!is_null($_POST["operand1"]) && !is_null($_POST["operand2"])) {
        $operand1 = $_POST["operand1"];
        $operand2 = $_POST["operand2"];
        if (!is_numeric($operand1) || !is_numeric($operand2)) {
            die("Niste upisali numeričku vrijednost!");
        }
    } else {
        die("Niste upisali vrijednosti!");
    }

    if (!empty($_POST["operation"])) {
        $operation = $_POST["operation"];
    } else {
        die("Niste odabrali aritmetičku operaciju");
    }

    if ($operand2 == "0" && $operation == "/") {
        die("Nemožete dijeliti sa nulom!");
    }

    $result = match ($operation) {
        "+" => $operand1 + $operand2,
        "-" => $operand1 - $operand2,
        "x" => $operand1 * $operand2,
        "/" => $operand1 / $operand2,
        default => die("Aritmetička operacija se nemože obaviti")
    };

    echo "<h3>$operand1 $operation $operand2 = $result</h3>";

?>