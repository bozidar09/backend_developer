<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'PATCH') {
    abort();
}

$postData = [
    'id' => $_POST['id'] ?? null,
    'datum_posudbe' => $_POST['rental'] ?? null,
    'datum_povrata' => $_POST['return'] ?? null,
];

$date = date('Y-m-d');

$rules = [
    'id' => ['exists:posudba,id'],
    'datum_posudbe' => ['required', 'date:' . $date],
    'datum_povrata' => ['date:' . $date . ',' . $_POST['rental']],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    goBack();
}
    
$data = $form->getData();

const QUERY = [
    'posudba' 
        => "UPDATE posudba SET datum_posudbe = :datum_posudbe, datum_povrata = :datum_povrata WHERE id = :id",
    'kopije'
        => "SELECT kopija_id FROM posudba_kopija WHERE posudba_id = :posudba_id",
    'update' 
        => "UPDATE kopija SET dostupan = :dostupan WHERE id = :id",
];

$db = Database::get();

try {
    $db->connection()->beginTransaction();

    $db->query(QUERY['posudba'], [
        'datum_posudbe' => $data['datum_posudbe'], 
        'datum_povrata' => $data['datum_povrata'], 
        'id' => $data['id'],
    ]);
    
    isset($data['datum_povrata']) ? $dostupan = 1 : $dostupan = 0;
    
    $copies = $db->query(QUERY['kopije'], [
        'posudba_id' => $_POST['id'],
    ])->all();
    
    foreach ($copies as $copy) {
        $db->query(QUERY['update'], [
            'dostupan' => $dostupan,
            'id' => $copy['kopija_id'],
        ]);
    }
    
    $db->connection()->commit();
    
} catch (\PDOException $e) {
    $db->connection()->rollBack();

    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o posudbi i dostupnosti kopija filmova."
]);

redirect('rentals');