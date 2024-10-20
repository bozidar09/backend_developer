<?php

use Core\Database;
use Core\Validator;
use Core\Session;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    abort();
}

isset($_POST['movie']) ? $movie = explode('-', $_POST['movie']) : $movie = '';

$postData = [
    'film_id' => $movie[0] ?? null,
    'naslov' => $movie[1] ?? null,
];

$rules = [
    'film_id' => ['required', 'exists:filmovi,id', 'numeric'],
    'naslov' => ['required', 'exists:filmovi,naslov', 'string', 'max:100'],
];

const QUERY = [
    'media' => "SELECT * FROM mediji",
    'copy' => "INSERT INTO kopija (barcode, film_id, medij_id) VALUES ",
];

$db = Database::get();

try {
    $db->connection()->beginTransaction();

    $media = $db->query(QUERY['media'])->all();
    foreach ($media as $key => $elements) {
        $mediaByType[$elements['tip']] = $elements;
        $postData[$elements['tip']] = $_POST[strtolower($elements['tip'])] ?? null;
        $rules[$elements['tip']] = ['numeric', 'max:2'];
    }

    $form = new Validator($rules, $postData);
    if ($form->notValid()) {
        Session::flash('errors', $form->errors());
        Session::flash('old', $form->getData());
        goBack();
    }

    $data = $form->getData();
    $copies = array_slice($data, 2);
    
    foreach ($copies as $key => $amount) {
        $sql = QUERY['copy'];
        
        if (isset($copies[$key])) {       
            $barcode = mb_strtoupper($data['naslov'] . '_' . $key . '1');
            $mediaId = $mediaByType[$key]['id'];
    
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

redirect('/copies');