<?php

use Core\Database;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['_method']) || $_POST['_method'] !== 'DELETE' || !isset($_POST['pid']) || !is_numeric($_POST['pid']) || !isset($_POST['kid']) || !is_numeric($_POST['kid'])) {
    abort();
}

const QUERY = [
    'posudba'
        => "SELECT * FROM posudba WHERE id = :id",
    'kopija'
        => "SELECT kopija_id FROM posudba_kopija WHERE posudba_id = :posudba_id",
    'delete'
        => "DELETE FROM posudba WHERE id = :id",
    'updatePosudba' 
        => "UPDATE posudba SET updated_at = :updated_at WHERE id = :id",
    'updateKopija' 
        => "UPDATE kopija SET dostupan = 1 WHERE id = :id",
];

$dateTime = date("Y-m-d H:i:s");

$db = Database::get();

try {
    $db->connection()->beginTransaction();

    $db->query(QUERY['posudba'], [
        'id' => $_POST['pid'],
    ])->findOrFail();
    
    $copies = $db->query(QUERY['kopija'], [
        'posudba_id' => $_POST['pid'],
    ])->all();
    
    if (count($copies) === 1) {
        $db->query(QUERY['delete'], [
            'id' => $_POST['pid'],
        ]);
    } else {
        $db->query(QUERY['updatePosudba'], [
            'updated_at' => $dateTime,
        ]);
    }
    
    $db->query(QUERY['updateKopija'], [
        'id' => $_POST['kid'],
    ]);
    
    $db->connection()->commit();

} catch (\PDOException $e) {
    $db->connection()->rollBack();
    
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati posudbu jer se podaci koriste u drugim tablicama."
    ]);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisana posudba."
]);
goBack();