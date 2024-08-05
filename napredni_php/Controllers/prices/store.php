<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {  
    abort();
}

$postData = [
    'tip_filma' => $_POST['movie_type'] ?? null,
    'cijena' => $_POST['price'] ?? null,
    'zakasnina_po_danu' => $_POST['late_fee'] ?? null,
];

$rules = [
    'tip_filma' => ['required', 'unique:cjenik', 'string', 'max:20', 'min:2'],
    'cijena' => ['required', 'numeric', 'max:10'],
    'zakasnina_po_danu' => ['required', 'numeric', 'max:10'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    Session::flash('data', $form->getData());    
    goBack();
}

$data = $form->getData();

$sql = "INSERT INTO cjenik (tip_filma, cijena, zakasnina_po_danu) VALUES (:tip_filma, :cijena, :zakasnina_po_danu)";

$db = Database::get();

try {
    $db->query($sql, [
        'tip_filma' => $data['tip_filma'], 
        'cijena' => $data['cijena'], 
        'zakasnina_po_danu' => $data['zakasnina_po_danu'], 
    ]);
    
} catch (\PDOException $e) {
    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno kreiran tip filma {$data['tip_filma']}."
]);

redirect('prices');