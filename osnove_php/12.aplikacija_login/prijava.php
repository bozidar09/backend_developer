<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava na sustav</title>
</head>
<body>
    <h2>Prijava na sustav</h2>
    <form method="POST" action="prijava.php">

        <table>
            <tr>
                <td>Korisničko ime</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>Lozinka</td>
                <td><input type="password" name="password"/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Login"/></td>
            </tr>
        </table>

        <?php
            session_start();
            $poruka = "";

            if (isset($_POST["username"]) && isset($_POST["password"])) {
                $korisnickoIme = $_POST["username"];
                $lozinka = $_POST["password"];
                if ($korisnickoIme == "admin" && $lozinka == "123") {
                    $_SESSION["user"] = $korisnickoIme;
                    header("Location: index.php");
                } else {
                    $poruka = "Neuspješna prijava!";
                }
            }
            
            echo "<br>";
            echo $poruka;
        ?>

    </form>
</body>
</html>