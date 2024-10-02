<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    abort();
}

$postData = [
    'ime' => $_POST['name'] ?? null,
    'prezime' => $_POST['surname'] ?? null,
    'adresa' => $_POST['address'] ?? null,
    'telefon' => $_POST['phone'] ?? null,
    'email' => $_POST['email'] ?? null,
    'clanski_broj' => $_POST['member_id'] ?? null,
];

$rules = [
    'ime' => ['required', 'string', 'max:50', 'min:2'],
    'prezime' => ['required', 'string','max:50', 'min:2'],
    'adresa' => ['string', 'max:100'],
    'telefon' => ['phone','max:15'],
    'email' => ['required', 'email', 'unique:clanovi', 'max:100'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    Session::flash('old', $form->getData());
    goBack();
}

$data = $form->getData();

const QUERY = [
    'clanski_broj'
        => "SELECT clanski_broj FROM clanovi 
            ORDER BY clanski_broj DESC 
            LIMIT 1",
    'insert'
        => "INSERT INTO clanovi (ime, prezime, adresa, telefon, email, clanski_broj) VALUES (:ime, :prezime, :adresa, :telefon, :email, :clanski_broj)",
];

$db = Database::get();

try {
    $clanId = $db->query(QUERY['clanski_broj'])->findOrFail();
    $clanId = 'CLAN' . (str_replace('CLAN', '', $clanId['clanski_broj']) + 1);
    
    $db->query(QUERY['insert'], [
        'ime' => $data['ime'], 
        'prezime' => $data['prezime'], 
        'adresa' => $data['adresa'],
        'telefon' => $data['telefon'],
        'email' => $data['email'], 
        'clanski_broj' => $clanId,
    ]);
    
} catch (\PDOException $e) {
    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno kreiran član {$data['ime']} {$data['prezime']}."
]);

redirect('/members');