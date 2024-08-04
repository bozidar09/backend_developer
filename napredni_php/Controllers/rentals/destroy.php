<?php

use Core\Database;
use Core\ResourceInUseException;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'DELETE') {
    abort();
}

$db = Database::get();

$db->connection()->beginTransaction();

const QUERY = [
    'posudba'
        => "SELECT * from posudba WHERE id = :id",
    'kopija'
        => "SELECT kopija_id from posudba_kopija WHERE posudba_id = :posudba_id",
    'delete'
        => "DELETE FROM posudba WHERE id = :id",
    'update' 
        => "UPDATE kopija SET dostupan = 1 WHERE id = :id",
];

$db->query(QUERY['posudba'], [
    'id' => $_POST['id'],
])->findOrFail();

$copies = $db->query(QUERY['kopija'], [
    'posudba_id' => $_POST['id'],
])->all();

try {
    $db->query(QUERY['delete'], [
        'id' => $_POST['id'],
    ]);
} catch (ResourceInUseException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati posudbu jer se podaci koriste u drugim tablicama."
    ]);
}

foreach ($copies as $copy) {
    $db->query(QUERY['update'], [
        'id' => $copy['kopija_id'],
    ]);
}

$db->connection()->commit();

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisana posudba."
]);
redirect('rentals');