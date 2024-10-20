<?php

use Core\Database;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'DELETE') {
    abort();
}
    
const QUERY = [
    'select'
        => "SELECT * FROM cjenik WHERE id = :id",
    'delete'
        => "DELETE FROM cjenik WHERE id = :id",
];

$db = Database::get();

try {
    $price = $db->query(QUERY['select'], [
        'id' => $_POST['id']
    ])->findOrFail();

    $success = $db->query(QUERY['delete'], ['id' => $_POST['id']]);

} catch (\PDOException $e) {
    Session::flash('message', [
        'type' => 'danger',
        'message' => "Ne možete obrisati tip filma {$price['tip_filma']} prije nego obrišete vezani film."
    ]);
    goBack();
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno obrisan tip filma {$price['tip_filma']}."
]);
goBack();