<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'PATCH') {
    abort();
}

$postData = [
    'id' => $_POST['id'] ?? null,
    'tip' => $_POST['type'] ?? null,
    'koeficijent' => $_POST['coefficient'] ?? null,
];

$rules = [
    'id' => ['exists:mediji,id'],
    'tip' => ['required', 'string', 'unique:mediji,' . $_POST['id'], 'max:100', 'min:2'],
    'koeficijent' => ['required', 'numeric', 'max:10'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    goBack();
}

$data = $form->getData();

$sql = "UPDATE mediji SET tip = :tip, koeficijent = :koeficijent WHERE id = :id";

$db = Database::get();

try {
    $db->query($sql, [
        'tip' => $data['tip'], 
        'koeficijent' => $data['koeficijent'], 
        'id' => $data['id'],
    ]);
    
} catch (\PDOException $e) {
    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o mediju {$data['tip']}."
]);

redirect('media');