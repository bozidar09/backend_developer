<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['copy_id']) || !is_numeric($_POST['copy_id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'PATCH') {
    abort();
}

$postData = [
    'id' => $_POST['id'] ?? null,
    'kopija_id' => $_POST['copy_id'] ?? null,
    'datum_posudbe' => $_POST['rental'] ?? null,
    'datum_povrata' => $_POST['return'] ?? null,
];

$date = date('Y-m-d');

$rules = [
    'id' => ['exists:posudba,id'],
    'kopija_id' => ['exists:kopija,id'],
    'datum_posudbe' => ['required', 'date:' . $date],
    'datum_povrata' => ['date:' . $date . ',' . $_POST['rental']],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    goBack();
}
    
$data = $form->getData();

$db = Database::get();

const QUERY = [
    'posudba' 
        => "UPDATE posudba SET datum_posudbe = :datum_posudbe, datum_povrata = :datum_povrata WHERE id = :id",
    'kopija' 
        => "UPDATE kopija SET dostupan = :dostupan WHERE id = :id",
];

$db->query(QUERY['posudba'], [
    'datum_posudbe' => $data['datum_posudbe'], 
    'datum_povrata' => $data['datum_povrata'], 
    'id' => $data['id'],
]);

if (isset($data['datum_povrata'])) {
    $db->query(QUERY['kopija'], [
        'dostupan' => 1, 
        'id' => $data['kopija_id'],
    ]);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o posudbi i dostupnosti kopije filma."
]);

redirect('rentals');