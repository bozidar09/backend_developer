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
        => "SELECT * from cjenik WHERE id = :id",
    'delete'
        => "DELETE FROM cjenik WHERE id = :id",
];

$price = $db->query(QUERY['select'], [
    'id' => $_POST['id']
])->findOrFail();

try {
    $success = $db->query(QUERY['delete'], ['id' => $_POST['id']]);
} catch (ResourceInUseException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati tip filma {$price['tip_filma']} prije nego obrišete vezani film."
    ]);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisan tip filma {$price['tip_filma']}."
]);
redirect('prices');