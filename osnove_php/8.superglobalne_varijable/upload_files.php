<?php

    function prettyPrint(array $print)
    {
        echo "<pre>";
        print_r($print);
        echo "</pre>";
    }

    prettyPrint($_FILES);

    $uploadDir = __DIR__ . "/uploads";

    if (!empty($_FILES)) {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir);
        }

        // basename($uploadDir); daje ime datoteke

        $file = $_FILES["file"]["name"];
        $fileName = $uploadDir . "/" . $file;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $fileName)) {
            echo "File dodan";
            echo "<a href=uploads/$file>Prikazi</a>";
        } else {
            echo "Problem kod file uploada";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File upload</title>
</head>
<body>

    <h2>File upload</h2>

    <form method="POST" enctype="multipart/form-data">

        <label for="file">Datoteka:</label><br>
        <input type="file" id="file" name="file" required><br>

        <input type="submit" value="Pošalji">

    </form> 
  
</body>
</html>