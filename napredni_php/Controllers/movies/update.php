<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'PATCH') {
    abort();
}

$postData = [
    'id' => $_POST['id'] ?? null,
    'naslov' => $_POST['title'] ?? null,
    'godina' => $_POST['year'] ?? null,
    'zanr_id' => $_POST['genre'] ?? null,
    'cjenik_id' => $_POST['movie_type'] ?? null,
];

$rules = [
    'id' => ['exists:filmovi,id'],
    'naslov' => ['required', 'string', 'max:100', 'uniqueMovie:filmovi,' . $_POST['year'] . ',' . $_POST['id']],
    'godina' => ['required', 'numeric', 'max:4', 'min:4'],
    'zanr_id' => ['required', 'exists:zanrovi,id', 'numeric'],
    'cjenik_id' => ['required', 'exists:cjenik,id', 'numeric'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    goBack();
}

$data = $form->getData();

$sql = "UPDATE filmovi SET naslov = :naslov, godina = :godina, zanr_id = :zanr_id, cjenik_id = :cjenik_id WHERE id = :id";

$db = Database::get();

try {
    $db->query($sql, [
        'naslov' => $data['naslov'], 
        'godina' => $data['godina'], 
        'zanr_id' => $data['zanr_id'], 
        'cjenik_id' => $data['cjenik_id'], 
        'id' => $data['id'],
    ]);
    
} catch (\PDOException $e) {
    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o filmu {$data['naslov']} {$data['godina']}."
]);

redirect('movies');