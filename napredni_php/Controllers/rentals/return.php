<?php

use Core\Database;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
    abort(); 
}

$db = Database::get();

const QUERY = [
    'posudba'
        => "SELECT * from posudba WHERE id = :id",
    'update_posudba' 
        => "UPDATE posudba SET datum_povrata = :datum_povrata WHERE id = :id",
    'kopije'
        => "SELECT kopija_id from posudba_kopija WHERE id = :id",
    'update_kopija' 
        => "UPDATE kopija SET dostupan = :dostupan WHERE id = :id",
];

$db->query(QUERY['posudba'], [
    'id' => $_GET['id'],
])->findOrFail();

$date = date('Y-m-d');

$db->query(QUERY['update_posudba'], [
    'datum_povrata' => $date, 
    'id' => $data['id'],
]);

isset($data['datum_povrata']) ? $dostupan = 1 : $dostupan = 0;


$copies = $db->query(QUERY['kopije'], [
    'id' => $_POST['copy_id'],
])->all();

foreach ($copies as $copy) {
    $db->query(QUERY['update_kopija'], [
        'dostupan' => $dostupan,
        'id' => $copy,
    ]);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o posudbi i dostupnosti kopija filmova."
]);

redirect('rentals');