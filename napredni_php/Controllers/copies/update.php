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

dd($data);

$db = Database::get();

$sql = "UPDATE kopija SET barcode = :barcode, dostupan = :dostupan WHERE id = :id";

$db->query($sql, [
    'barcode' => $data['barcode'], 
    'dostupan' => $data['dostupan'], 
    'id' => $data['id'],
]);

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o kopiji filma."
]);

redirect('copies');