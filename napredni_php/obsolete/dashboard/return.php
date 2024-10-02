<?php

use Core\Database;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['_method']) || $_POST['_method'] !== 'PATCH' || !isset($_POST['pid']) || !is_numeric($_POST['pid']) || !isset($_POST['kid']) || !is_numeric($_POST['kid'])) {
    abort(); 
}

const QUERY = [
    'posudba'
        => "SELECT * FROM posudba WHERE id = :id",
    'kopija'
        => "SELECT * FROM kopija WHERE id = :id",
    'kopije'
        => "SELECT kopija_id FROM posudba_kopija WHERE posudba_id = :posudba_id",
    'update_povrat' 
        => "UPDATE posudba SET datum_povrata = :datum_povrata WHERE id = :id",
    'update_at' 
        => "UPDATE posudba SET updated_at = :updated_at WHERE id = :id",
    'update_kopija' 
        => "UPDATE kopija SET dostupan = 1 WHERE id = :id",
];

$date = date('Y-m-d');
$dateTime = date('Y-m-d H:i:s');

$db = Database::get();

try {
    $db->connection()->beginTransaction();

    $db->query(QUERY['posudba'], [
        'id' => $_POST['pid'],
    ])->findOrFail();

    $db->query(QUERY['kopija'], [
        'id' => $_POST['kid'],
    ])->findOrFail();
        
    $copies = $db->query(QUERY['kopije'], [
        'posudba_id' => $_POST['pid'],
    ])->all();

    if (count($copies) === 1) {
        $db->query(QUERY['update_povrat'], [
            'datum_povrata' => $date, 
            'id' => $_POST['pid'],
        ]);
    } else {
        $db->query(QUERY['update_at'], [
            'updated_at' => $dateTime, 
            'id' => $_POST['pid'],
        ]);
    }

    $db->query(QUERY['update_kopija'], [
        'id' => $_POST['kid'],
    ]);
    
    $db->connection()->commit();

} catch (\PDOException $e) {
    $db->connection()->rollBack();

    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno zaključena posudba."
]);

redirect('/dashboard');