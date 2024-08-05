<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'PATCH') {
    abort();
}

$postData = [
    'id' => $_POST['id'] ?? null,
    'barcode' => $_POST['barcode'] ?? null,
    'dostupan' => $_POST['available'] ?? null,
];

$rules = [
    'id' => ['exists:kopija,id'],
    'barcode' => ['required', 'string', 'max:50', 'min:5'],
    'dostupan' => ['numeric:0,1'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    goBack();
}

$data = $form->getData();

$sql = "UPDATE kopija SET barcode = :barcode, dostupan = :dostupan WHERE id = :id";

$db = Database::get();

try {
    $db->query($sql, [
        'barcode' => $data['barcode'], 
        'dostupan' => $data['dostupan'], 
        'id' => $data['id'],
    ]);
    
} catch (\PDOException $e) {
    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o kopiji filma."
]);

redirect('copies');