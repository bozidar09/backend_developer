<?php
    session_start();

    if (!isset($_SESSION["username"])) {
        header("Location: prijava.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naslovna</title>
</head>
<body>
    <h2>
        Dobrodošli,
        <?php echo $_SESSION["user"] ?>
    </h2>
    <p>Sada imate neograničeni pristup ovoj stranici.</p>
    <a href="odjava.php">Odjavi se</a>
</body>
</html>