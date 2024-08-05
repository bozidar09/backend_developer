<?php

use Core\Database;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

const QUERY = [
    'posudba'
        => "SELECT * FROM posudba WHERE id = :id",
    'update_posudba' 
        => "UPDATE posudba SET datum_povrata = :datum_povrata WHERE id = :id",
    'kopije'
        => "SELECT kopija_id FROM posudba_kopija WHERE posudba_id = :posudba_id",
    'update_kopija' 
        => "UPDATE kopija SET dostupan = 1 WHERE id = :id",
];

$db = Database::get();

try {
    $db->connection()->beginTransaction();

    $db->query(QUERY['posudba'], [
        'id' => $_GET['id'],
    ])->findOrFail();
    
    $date = date('Y-m-d');
    
    $db->query(QUERY['update_posudba'], [
        'datum_povrata' => $date, 
        'id' => $_GET['id'],
    ]);
    
    $copies = $db->query(QUERY['kopije'], [
        'posudba_id' => $_GET['id'],
    ])->all();
    
    foreach ($copies as $copy) {
        $db->query(QUERY['update_kopija'], [
            'id' => $copy['kopija_id'],
        ]);
    }
    
    $db->connection()->commit();

} catch (\PDOException $e) {
    $db->connection()->rollBack();

    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno zaključena posudba."
]);

redirect('dashboard');