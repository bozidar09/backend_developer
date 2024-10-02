<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linijski kalkulator</title>
</head>
<body>

    <h2>Linijski kalkulator</h2>

    <br>

    <form method="POST">

        <label for="input">Upišite izraz:</label><br>
        <input type="text" id="input" name="input"><br><br>

        <input type="submit" value="Izračunaj">

        <br><br>

    </form> 
  
</body>
</html>

<?php

    function aritmeticOperation($operand1, $operand2, $operator) : void
    {
        $result = match ($operator) {
            "+" => $operand1 + $operand2,
            "-" => $operand1 - $operand2,
            "x" => $operand1 * $operand2,
            "/" => $operand1 / $operand2,
            default => die("Aritmetička operacija se nemože obaviti")
        };

        echo "<h3>$operand1 $operator $operand2 = $result</h3>";
    }

    if (isset($_POST['input'])) {
        $input = $_POST['input'];
    } else {
        die("Morate upisati izraz!");
    }

    $operators = ["+", "-", "x", "/"];

    if (preg_match_all("/[-+x\/]/", $input, $operatorCounter) == false) {
        die("Niste upisali aritmetičku operaciju!");
    }

    if (count($operatorCounter[0]) > 1) {
        die("Upisali ste više od jedne aritmetičke operacije!");
    }

    foreach ($operators as $operator) {
        if (str_contains($input, $operator)) {
            $inputArray = explode($operator, $input);
            if (is_numeric($inputArray[0]) && is_numeric($inputArray[1])) {
                if (($operator === "/") && ($inputArray[1] === "0")) {
                    die("Nemožete dijeliti sa nulom!");
                } else {
                    aritmeticOperation($inputArray[0], $inputArray[1], $operator);
                }
            } else {
                die("Upisali ste pogrešan izraz!");
            }
        }
    }