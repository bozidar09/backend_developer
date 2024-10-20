<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konvertor valuta</title>
</head>
<body>

    <h2>Konvertor valuta</h2>

    <br>

    <form method="POST">

        <label for="amount">EUR:</label><br>
        <input type="text" id="amount" name="amount" default=NULL><br><br>

        <input type="submit" value="Konvertiraj">

        <br><br>

    </form> 
  
</body>
</html>

<?php

    function prettyPrint(array $print)
    {
        echo "<pre>";
        print_r($print);
        echo "</pre>";
    }

    const URL = "https://www.hnb.hr/tecajn-eur/htecajn.htm";
    
    $lista = file(URL);

    array_shift($lista);
    
    foreach ($lista as $valutniRedak) {
        if (str_contains($valutniRedak, "USD")) {
            break;
        }
    }
    
    $usdValues = explode("       ", $valutniRedak);
    
    $usdSrednjiTecaj = $usdValues[2];


    // konvertiranje EUR -> USD
    $usdProdajniTecaj = $usdValues[3];

    $usdProdajniTecaj = str_replace(",", ".", $usdProdajniTecaj);   
    
    if ($_POST["amount"] !== "") {
        $amount = $_POST["amount"];
        if (!is_numeric($amount)) {
            die("Niste upisali numeričku vrijednost!");
        }
    } else {
        die("Niste upisali vrijednost");
    }

    $convertedValue = $amount * $usdProdajniTecaj;
    $convertedValue = round($convertedValue, 2);

    echo "<h3>$convertedValue USD</h3><br><br>";

    // ispis arrayeva tečajne liste i USD vrijednosti 
    prettyPrint($lista);

    prettyPrint($usdValues);

?>