<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GET vježba</title>
</head>
<body>

    <h2>GET vježba</h2>

    <form method="GET">

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

    // primjer URL-a sa GET parametrima  ->  http://localhost/9.vjezba/get_vjezba.php?objekt=stolica&subjekt=predavac

    
    $getData = $_GET;
    
    if (!empty($getData)) {
        prettyPrint($getData);
    } else {
        die("U varijabli GET nema podataka!");
    }

?>