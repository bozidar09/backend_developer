<?php

use Core\Database;
use Core\Session;

if (!isset($_POST['code']) || !isset($_POST['_method']) || $_POST['_method'] !== 'DELETE') {
    abort();
}

const QUERY = [
    'selectId'
    => "SELECT * FROM kopija WHERE id = :id",
    'selectBarcode'
    => "SELECT COUNT(*) FROM kopija WHERE barcode = :barcode GROUP BY barcode",
    'delete'
    => "DELETE FROM kopija WHERE id = :id",
    'deleteAll'
    => "DELETE FROM kopija WHERE barcode = :barcode",
];

$db = Database::get();

try {
    if (parse_url($_SERVER['HTTP_REFERER'])['path'] === '/copies/show') {
        $db->query(QUERY['selectId'], [
            'id' => $_POST['code'],
        ])->findOrFail();

        $db->query(QUERY['delete'], [
            'id' => $_POST['code'],
        ]);

    } else {
        $db->query(QUERY['selectBarcode'], [
            'barcode' => $_POST['code'],
        ])->findOrFail();

        $db->query(QUERY['deleteAll'], [
            'barcode' => $_POST['code'],
        ]);
    }

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
goBack();