<?php

    $users = [
        [
            "id" => 1,
            "name" => "John Doe",
            "email" => "john@example.com",
            "age" => 30
        ],
        [
            "id" => 2,
            "name" => "Jane Smith",
            "email" => "jane@example.com",
            "age" => 25
        ],
        [
            "id" => 3,
            "name" => "Mike Johnson",
            "email" => "mike@example.com",
            "age" => 35
        ],
        [
            "id" => 4,
            "name" => "Emily Davis",
            "email" => "emily@example.com",
            "age" => 28
        ],
        [
            "id" => 5,
            "name" => "Chris Brown",
            "email" => "chris@example.com",
            "age" => 40
        ]
    ];

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Korisnici</title>
    </head>
    <body>
        <table border="1">  
            <!-- <thead> <tbody> -->
            <tr>
            <?php
            $key = array_key_first($users);

            foreach ($users[$key] as $attribute => $value): ?>  
                <th align="left">
                <?= $attribute; ?>
                </th>  
            <?php endforeach; ?>
            </tr> 
            
            <?php foreach ($users as $user => $data): ?>
            <tr>
                <?php foreach ($data as $attribute => $value): ?>
                    <td>
                    <?= $value; ?>
                    </td>
                <?php endforeach; ?>
            </tr>   
            <?php endforeach; ?>

        </table>      
    </body>
</html>