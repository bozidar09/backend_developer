<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    abort();
}

$postData = [
    'naslov' => $_POST['title'] ?? null,
    'godina' => $_POST['year'] ?? null,
    'zanr_id' => $_POST['genre'] ?? null,
    'cjenik_id' => $_POST['movie_type'] ?? null,
];

$rules = [
    'naslov' => ['required', 'string', 'max:100', 'uniqueMovie:filmovi,' . $_POST['year']],
    'godina' => ['required', 'numeric', 'max:4', 'min:4'],
    'zanr_id' => ['required', 'exists:zanrovi,id', 'numeric'],
    'cjenik_id' => ['required', 'exists:cjenik,id', 'numeric'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    Session::flash('data', $form->getData());
    goBack();
}

$data = $form->getData();

$db = Database::get();

$sql = "INSERT INTO filmovi (naslov, godina, zanr_id, cjenik_id) VALUES (:naslov, :godina, :zanr, :tip)";

$db->query($sql, [
    'naslov' => $data['naslov'], 
    'godina' => $data['godina'], 
    'zanr' => $data['zanr_id'], 
    'tip' => $data['cjenik_id'],
]);

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno kreiran film {$data['naslov']} {$data['godina']}."
]);

redirect('movies');