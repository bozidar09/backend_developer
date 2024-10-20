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
    'medij_id' => ['required', 'exists:mediji,id', 'numeric'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    Session::flash('old', $form->getData());
    goBack();
}

$data = $form->getData();

const QUERY = [
    'posudba' 
    => "INSERT INTO posudba (datum_posudbe, clan_id) VALUES (:datum_posudbe, :clan_id)",
    'kopija' 
    => "SELECT k.id FROM kopija k WHERE film_id = :film_id AND medij_id = :medij_id AND dostupan = 1 LIMIT 1",
    'posudba_kopija' 
    => "INSERT INTO posudba_kopija (posudba_id, kopija_id) VALUES (:posudba_id, :kopija_id)",
    'update_kopija' 
    => "UPDATE kopija SET dostupan = 0 WHERE id = :id",
];

$date = date('Y-m-d');

$db = Database::get();

try {
    $db->connection()->beginTransaction();

    $db->query(QUERY['posudba'], [
        'datum_posudbe' => $date, 
        'clan_id' => $data['clan_id'], 
    ]);
    
    $rentalId = $db->connection()->lastInsertId();
    
    $copy = $db->query(QUERY['kopija'], [
        'film_id' => $data['film_id'], 
        'medij_id' => $data['medij_id'], 
    ])->findOrFail();
    
    $db->query(QUERY['posudba_kopija'], [
        'posudba_id' => $rentalId,  
        'kopija_id' => $copy['id'], 
    ]);
    
    $db->query(QUERY['update_kopija'], [
        'id' => $copy['id'], 
    ]);
    
    $db->connection()->commit();
    
} catch (\PDOException $e) {
    $db->connection()->rollBack();

    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno kreirana posudba filma."
]);

if (parse_url($_SERVER['HTTP_REFERER'])['path'] === '/dashboard') {
    redirect('/dashboard');
}
redirect('/rentals');
