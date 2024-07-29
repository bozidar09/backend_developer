<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'PATCH') {
    abort();
}

$postData = [
    'id' => $_POST['id'] ?? null,
    'ime' => $_POST['name'] ?? null,
];

$rules = [
    'id' => ['exists:zanrovi,id'],
    'ime' => ['required', 'string', 'unique:zanrovi,' . $_POST['id'], 'max:100'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) { 
    Session::flash('errors', $form->errors());
    goBack();
}

$data = $form->getData();

$db = Database::get();

$sql = "UPDATE zanrovi SET ime = :ime WHERE id = :id";

$db->query($sql, [
    'ime' => $data['ime'], 
    'id' => $data['id'],
]);

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o žanru {$data['ime']}."
]);

redirect('genres');