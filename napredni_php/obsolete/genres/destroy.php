<?php

use Core\Database;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'DELETE') {
    abort();
}

$db = Database::get();

const QUERY = [
    'select'
        => "SELECT * FROM zanrovi WHERE id = :id",
    'delete'
        => "DELETE FROM zanrovi WHERE id = :id",
];

try {
    $genre = $db->query(QUERY['select'], [
        'id' => $_POST['id'],
    ])->findOrFail();

    $db->query(QUERY['delete'], [
        'id' => $_POST['id'],
    ]);

} catch (\PDOException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati žanr {$genre['ime']} prije nego obrišete vezane filmove."
    ]);
    goBack();
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisan žanr {$genre['ime']}."
]);
goBack();