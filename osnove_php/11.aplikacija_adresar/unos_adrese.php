<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adresar</title>
</head>
<body>
    <h2>Unos adrese</h2>
    <form method="post" action="spremi_adresu.php" enctype="multipart/form-data">
        Ime:<br/>
        <input type="text" name="name" />
        <br/><br/>
        Adresa:<br/>
        <textarea name="address"></textarea>
        <br/><br/>
        Grad:<br/>
        <select name="town">
            <option>Zagreb</option>
            <option>Split</option>
            <option>Rijeka</option>
            <option>Osijek</option>
        </select>
        <br/><br/>  
        Spol:<br/>
            <input type="radio" value="M" name="gender" /> muški<br/>
            <input type="radio" value="Ž" name="gender" /> ženski
        <br/><br/>
        Pratitelj:<br/>
            <input type="checkbox" checked="checked" name="follower"/>
        <br/><br/>
        Avatar:<br/>
            <input type="file" name="picture"/>
        <br/><br/>
        <input type="submit" value="Spremi" />
        <input type="reset" value="Odustani" />
    </form>
</body>
</html>