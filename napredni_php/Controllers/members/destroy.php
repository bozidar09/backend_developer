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
        => "SELECT * from clanovi WHERE id = :id",
    'delete'
        => "DELETE FROM clanovi WHERE id = :id",
];

$member = $db->query(QUERY['select'], [
    'id' => $_POST['id'],
])->findOrFail();

try {
    $success = $db->query(QUERY['delete'], [
        'id' => $_POST['id'],
    ]);
} catch (ResourceInUseException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati člana {$member['ime']} {$member['prezime']} prije nego obrišete vezane posudbe."
    ]);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisan član {$member['ime']} {$member['prezime']}."
]);
redirect('members');