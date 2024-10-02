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
];

$rules = [
    'naslov' => ['required', 'string', 'max:100', 'uniqueMovie:filmovi,' . $_POST['year']],
    'godina' => ['required', 'numeric', 'max:4', 'min:4'],
    'zanr_id' => ['required', 'exists:zanrovi,id', 'numeric'],
    'cjenik_id' => ['required', 'exists:cjenik,id', 'numeric'],
];

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
    $copies = array_slice($data, 4);

    $db->query(QUERY['movie'], [
        'naslov' => $data['naslov'], 
        'godina' => $data['godina'], 
        'zanr' => $data['zanr_id'], 
        'tip' => $data['cjenik_id'],
    ]);

    $movieId = $db->connection()->lastInsertId();

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

redirect('/movies');