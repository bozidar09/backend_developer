<?php

use Core\Database;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'DELETE') {
    abort();
}

const QUERY = [
    'posudba'
        => "SELECT * FROM posudba WHERE id = :id",
    'kopija'
        => "SELECT kopija_id FROM posudba_kopija WHERE posudba_id = :posudba_id",
    'delete'
        => "DELETE FROM posudba WHERE id = :id",
    'update' 
        => "UPDATE kopija SET dostupan = 1 WHERE id = :id",
];

$db = Database::get();

try {
    $db->connection()->beginTransaction();

    $db->query(QUERY['posudba'], [
        'id' => $_POST['id'],
    ])->findOrFail();
    
    $copies = $db->query(QUERY['kopija'], [
        'posudba_id' => $_POST['id'],
    ])->all();

    $db->query(QUERY['delete'], [
        'id' => $_POST['id'],
    ]);

    foreach ($copies as $copy) {
        $db->query(QUERY['update'], [
            'id' => $copy['kopija_id'],
        ]);
    }
    
    $db->connection()->commit();

} catch (\PDOException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati posudbu jer se podaci koriste u drugim tablicama."
    ]);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisana posudba."
]);
redirect('rentals');