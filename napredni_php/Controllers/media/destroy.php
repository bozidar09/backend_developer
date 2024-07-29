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
        => "SELECT * from mediji WHERE id = :id",
    'delete'
        => "DELETE FROM mediji WHERE id = :id",
];

$media = $db->query(QUERY['select'], [
    'id' => $_POST['id'],
])->findOrFail();

try {
    $success = $db->query(QUERY['delete'], [
        'id' => $_POST['id'],
    ]);
} catch (ResourceInUseException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati medij {$media['tip']} prije nego obrišete vezane kopije filmova."
    ]);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisan medij {$media['tip']}."
]);
redirect('media');