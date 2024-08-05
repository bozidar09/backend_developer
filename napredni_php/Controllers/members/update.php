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
    'prezime' => $_POST['surname'] ?? null,
    'adresa' => $_POST['address'] ?? null,
    'telefon' => $_POST['phone'] ?? null,
    'email' => $_POST['email'] ?? null,
    'clanski_broj' => $_POST['member_id'] ?? null,
];

$rules = [
    'id' => ['exists:clanovi,id'],
    'ime' => ['required', 'string', 'max:50', 'min:2'],
    'prezime' => ['required', 'string', 'max:50', 'min:2'],
    'adresa' => ['string', 'max:100'],
    'telefon' => ['phone','max:15'],
    'email' => ['required', 'email', 'unique:clanovi,' . $_POST['id'], 'max:100'],
    'clanski_broj' => ['required', 'string', 'unique:clanovi,' . $_POST['id'], 'max:14', 'min:8', 'clanskiBroj']
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    goBack();
}

$data = $form->getData();

$sql = "UPDATE clanovi SET ime = :ime, prezime = :prezime, adresa = :adresa, telefon = :telefon, email = :email, clanski_broj = :clanski_broj WHERE id = :id";

$db = Database::get();

try {
    $db->query($sql, [
        'ime' => $data['ime'], 
        'prezime' => $data['prezime'], 
        'adresa' => $data['adresa'],
        'telefon' => $data['telefon'],
        'email' => $data['email'], 
        'clanski_broj' => $data['clanski_broj'], 
        'id' => $data['id'],
    ]);
    
} catch (\PDOException $e) {
    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno uređeni podaci o članu {$data['ime']} {$data['prezime']}."

]);

redirect('members');