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
    'DVD' => $_POST['dvd'] ?? null,
    'Blu-ray' => $_POST['blu-ray'] ?? null,
    'VHS' => $_POST['vhs'] ?? null,
];

$rules = [
    'naslov' => ['required', 'string', 'max:100', 'uniqueMovie:filmovi,' . $_POST['year']],
    'godina' => ['required', 'numeric', 'max:4', 'min:4'],
    'zanr_id' => ['required', 'exists:zanrovi,id', 'numeric'],
    'cjenik_id' => ['required', 'exists:cjenik,id', 'numeric'],
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
$copies = array_slice($data, 4);

const QUERY = [
    'movie' 
        => "INSERT INTO filmovi (naslov, godina, zanr_id, cjenik_id) VALUES (:naslov, :godina, :zanr, :tip)",
    'media' 
        => "SELECT * FROM mediji",
    'copy' 
        => "INSERT INTO kopija (barcode, film_id, medij_id) VALUES ",
];

$db = Database::get();


try {
    $db->connection()->beginTransaction();

    $db->query(QUERY['movie'], [
        'naslov' => $data['naslov'], 
        'godina' => $data['godina'], 
        'zanr' => $data['zanr_id'], 
        'tip' => $data['cjenik_id'],
    ]);

    $movieId = $db->connection()->lastInsertId();

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
                'film' => $movieId,
                'medij' => $mediaId,
            ]);
        }
    };

    $db->connection()->commit();
    
} catch (\PDOException $e) {
    $db->connection()->rollBack();

    abort(500);
}

Session::flash('message', [
    'type' => 'success',
    'message' => "Uspješno kreiran film {$data['naslov']} {$data['godina']}."
]);

redirect('movies');