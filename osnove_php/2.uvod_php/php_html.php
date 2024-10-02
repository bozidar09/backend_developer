<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP & HTML</title>
</head>
<body>
    <!--ovo je HTML komentar-->
    <h1>PHP & HTML</h1>
    
    <?php 
        // ini_set ("error_reporting", E_ALL);
        // ini_set ("display_errors", 1);

        // include "include_require.php555";
        require_once "include_require.php";

        $ispis = "Ovo je ispisano pomoću PHP jezika"
    ?>

    <section>
        <p>
            <?php 
                echo $ispis 
            ?>
        </p>
    </section>

    <section>
        <p>
            <?= $ispis2 ?>
        </p>
        <p>
            <?= "Skraćeni PHP tag za ispis" ?>
        </p>
    </section>

</body>
</html>