<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    abort();
}

$postData = [
    'ime' => $_POST['name'] ?? null,
];

$rules = [
    'ime' => ['required', 'string', 'unique:zanrovi', 'max:100']
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    Session::flash('old', $form->getData());
    goBack();
}

$data = $form->getData();
$sql = "INSERT INTO zanrovi (ime) VALUES (:ime)";

$db = Database::get();

try {
    $db->query($sql, [
        'ime' => $data['ime'],
    ]);
    
} catch (\PDOException $e) {
    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno kreiran žanr {$data['ime']}."
]);

redirect('/genres');