<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File upload</title>
</head>
<body>

    <h2>File upload</h2>

    <form method="POST" action="obrada_files.php" enctype="multipart/form-data">

        <label for="file">Datoteka:</label><br>
        <input type="file" id="file" name="file" required><br>

        <input type="submit" value="Pošalji">

    </form> 
  
</body>
</html>