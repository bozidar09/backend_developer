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
        => "SELECT * from zanrovi WHERE id = :id",
    'delete'
        => "DELETE FROM zanrovi WHERE id = :id",
];

$genre = $db->query(QUERY['select'], [
    'id' => $_POST['id'],
])->findOrFail();

try {
    $db->query(QUERY['delete'], [
        'id' => $_POST['id'],
    ]);
} catch (ResourceInUseException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati žanr {$genre['ime']} prije nego obrišete vezane filmove."
    ]);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisan žanr {$genre['ime']}."
]);
redirect('genres');