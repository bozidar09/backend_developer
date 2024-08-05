<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if (!isset($_POST['id']) || !is_numeric($_POST['id']) || !isset($_POST['_method']) || $_POST['_method'] !== 'PATCH') {
    abort();
}

$postData = [
    'id' => $_POST['id'] ?? null,
    'tip_filma' => $_POST['movie_type'] ?? null,
    'cijena' => $_POST['price'] ?? null,
    'zakasnina_po_danu' => $_POST['late_fee'] ?? null,
];

$rules = [
    'id' => ['exists:cjenik,id'],
    'tip_filma' => ['required', 'unique:cjenik,' . $_POST['id'], 'string', 'max:20', 'min:2'],
    'cijena' => ['required', 'numeric', 'max:10'],
    'zakasnina_po_danu' => ['required', 'numeric', 'max:10'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    goBack();
}

$data = $form->getData();

$sql = "UPDATE cjenik SET tip_filma = :tip_filma, cijena = :cijena, zakasnina_po_danu = :zakasnina_po_danu WHERE id = :id";

$db = Database::get();

try {
    $db->query($sql, [
        'tip_filma' => $data['tip_filma'], 
        'cijena' => $data['cijena'], 
        'zakasnina_po_danu' => $data['zakasnina_po_danu'], 
        'id' => $data['id'],
    ]);
    
} catch (\PDOException $e) {
    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o tipu filma {$data['tip_filma']}."
]);

redirect('prices');