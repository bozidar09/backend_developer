<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    abort();
}

isset($_POST['movie_media']) ? $movieMedia = explode('-', $_POST['movie_media']) : $movieMedia = '';

$postData = [
    'clan_id' => $_POST['member'] ?? null,
    'film_id' => $movieMedia[0] ?? null,
    'medij_id' => $movieMedia[1] ?? null,
];

$rules = [
    'clan_id' => ['required', 'exists:clanovi,id', 'numeric'],
    'film_id' => ['required', 'exists:filmovi,id', 'numeric'],
    'medij_id' => ['required', 'exists:media,id', 'numeric'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    Session::flash('data', $form->getData());
    goBack();
}

$data = $form->getData();

$db = Database::get();

$db->connection()->beginTransaction();

const QUERY = [
    'posudba' 
        => "INSERT INTO posudba (datum_posudbe, clan_id) VALUES (:datum_posudbe, :clan_id)",
    'posudba_kopija' 
        => "INSERT INTO posudba_kopija (posudba_id, kopija_id) VALUES (:posudba_id, :kopija_id)",
    'kopija' 
        => "SELECT k.id FROM kopija k WHERE film_id = :film_id AND medij_id = :medij_id AND dostupan = 1 LIMIT 1",
    'update_kopija' 
        => "UPDATE kopija SET dostupan = :dostupan WHERE id = :id",
];

$date = date('Y-m-d');

$db->query(QUERY['posudba'], [
    'datum_posudbe' => $date, 
    'clan_id' => $data['clan_id'], 
]);

$rentalId = $db->connection()->lastInsertId();

$copyId = $db->query(QUERY['kopija'], [
    'film_id' => $data['film_id'], 
    'medij_id' => $data['medij_id'], 
])->findOrFail();

$db->query(QUERY['posudba_kopija'], [
    'film_id' => $data['film_id'],  
    'medij_id' => $data['medij_id'], 
]);

$db->query(QUERY['update_kopija'], [
    'id' => $copyId, 
]);

$db->connection()->commit();

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno kreiran film {$data['naslov']} {$data['godina']}."
]);

if ($_SERVER['HTTP_REFERER'] === 'dashboard') {
    redirect('dashboard');
}
redirect('rentals');
