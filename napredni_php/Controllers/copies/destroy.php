<?php

use Core\Database;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'DELETE') {
    abort();
}

const QUERY = [
    'select'
    => "SELECT * FROM kopija WHERE id = :id",
    'delete'
    => "DELETE FROM kopija WHERE id = :id",
];

$db = Database::get();

try {
    $db->query(QUERY['select'], [
        'id' => $_POST['id'],
    ])->findOrFail();

    $db->query(QUERY['delete'], [
        'id' => $_POST['id'],
    ]);

} catch (\PDOException $e) { 
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati kopiju filma prije nego obrišete vezane posudbe."
    ]);
    goBack();
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisana kopija filma."
]);
redirect('copies');