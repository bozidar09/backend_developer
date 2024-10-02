<?php

use Core\Database;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'DELETE') {
    abort();
}

const QUERY = [
    'select'
        => "SELECT * FROM filmovi WHERE id = :id",
    'delete'
        => "DELETE FROM filmovi WHERE id = :id"
];

$db = Database::get();

try {
    $movie = $db->query(QUERY['select'], [
        'id' => $_POST['id'],
    ])->findOrFail();

    $db->query(QUERY['delete'], ['id' => $_POST['id']]);

} catch (\PDOException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati film {$movie['naslov']} {$movie['godina']} prije nego obrišete vezane kopije."
    ]);
    goBack();
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisan film {$movie['naslov']} {$movie['godina']}."
]);
goBack();