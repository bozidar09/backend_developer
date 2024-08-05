<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    abort();
}

$postData = [
    'film_id' => $_POST['movie'] ?? null,
    'DVD' => $_POST['dvd'] ?? null,
    'Blu-ray' => $_POST['blu-ray'] ?? null,
    'VHS' => $_POST['vhs'] ?? null,
];

$rules = [
    'film_id' => ['required', 'exists:filmovi,id', 'numeric'],
    'DVD' => ['numeric', 'max:2'],
    'Blu-ray' => ['numeric', 'max:2'],
    'VHS' => ['numeric', 'max:2'],
];

$form = new Validator($rules, $postData);
if ($form->notValid()) {
    Session::flash('errors', $form->errors());
    Session::flash('data', $form->getData());
    goBack();
}

$data = $form->getData();
$copies = array_slice($data, 1);

const QUERY = [
    'media' => "SELECT * FROM mediji",
    'copy' => "INSERT INTO kopija (barcode, film_id, medij_id) VALUES ",
];

$db = Database::get();

try {
    $db->connection()->beginTransaction();

    $media = $db->query(QUERY['media'])->all();
    foreach ($media as $key => $elements) {
        $mediaType[] = $elements['tip'];
    }
    $media = array_combine($mediaType, $media);
    
    foreach ($copies as $key => $amount) {
        $sql = QUERY['copy'];
    
        if (isset($copies[$key])) {       
            $barcode = mb_strtoupper($data['naslov'] . '_' . $key . '1');
            $mediaId = $media[$key]['id'];
    
            for ($i=1; $i < $amount; $i++) { 
                $sql .= "(:barcode, :film, :medij),";
            }
            $sql .= "(:barcode, :film, :medij)";
            
            $db->query($sql, [
                'barcode' => $barcode,
                'film' => $data['film_id'],
                'medij' => $mediaId,
            ]);
        }
    };

    $db->connection()->commit();

} catch (\PDOException $e) {
    $db->connection()->rollBack();

    abort(500);;
}


Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno kreirane kopije filma."
]);

redirect('copies');