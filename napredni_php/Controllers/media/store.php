<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    abort();
}
    
$postData = [
    'tip' => $_POST['type'] ?? null,
    'koeficijent' => $_POST['coefficient'] ?? null,
];

$rules = [
    'tip' => ['required', 'string', 'unique:mediji', 'max:100', 'min:2'],
    'koeficijent' => ['required', 'numeric', 'max:10'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    Session::flash('data', $form->getData());
    goBack();
}

$data = $form->getData();

$db = Database::get();

$sql = "INSERT INTO mediji (tip, koeficijent) VALUES (:tip, :koeficijent)";

$db->query($sql, [
    'tip' => $data['tip'], 
    'koeficijent' => $data['koeficijent'],
]);

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno kreiran medij {$data['tip']}."
]);

redirect('media');