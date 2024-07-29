<?php

use Core\Database;
use Core\ResourceInUseException;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'DELETE') {
    abort();
}

$db = Database::get();

const QUERY = [
    'select'
        => "SELECT * from filmovi WHERE id = :id",
    'delete'
        => "DELETE FROM filmovi WHERE id = :id"
];

$movie = $db->query(QUERY['select'], [
    'id' => $_POST['id'],
])->findOrFail();

try {
    $success = $db->query(QUERY['delete'], ['id' => $_POST['id']]);
} catch (ResourceInUseException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati film {$movie['naslov']} {$movie['godina']} prije nego obrišete vezane kopije."
    ]);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisan film {$movie['naslov']} {$movie['godina']}."
]);
redirect('movies');