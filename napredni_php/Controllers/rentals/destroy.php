<?php

use Core\Database;
use Core\ResourceInUseException;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'PATCH') {
    abort();
}

$db = Database::get();

const QUERY = [
    'posudba'
        => "SELECT * from posudba WHERE id = :id",
    'kopije'
        => "SELECT kopija_id from posudba_kopija WHERE id = :id",
    'delete'
        => "DELETE FROM posudba WHERE id = :id",
    'update' 
        => "UPDATE kopija SET dostupan = 1 WHERE id = :id",
];

$db->query(QUERY['posudba'], [
    'id' => $_POST['id'],
])->findOrFail();

$copies = $db->query(QUERY['kopija'], [
    'id' => $_POST['copy_id'],
])->all();

try {
    $db->query(QUERY['delete'], [
        'id' => $_POST['id'],
    ]);
} catch (ResourceInUseException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati posudbu."
    ]);
}

foreach ($copies as $copy) {
    $db->query(QUERY['update'], [
        'id' => $copy,
    ]);
}


Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisana posudba."
]);
redirect('rentals');