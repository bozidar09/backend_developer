<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Session;

class GenresController 
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    private function validateId(string $id): array
    {
        $sql = "SELECT * FROM zanrovi WHERE id = :id";
        return $this->db->query($sql, [
            'id' => $id,
        ])->findOrFail();
    }

    private function validateData(array $rules, array $postData): array
    {
        $form = new Validator($rules, $postData);
        if ($form->notValid()) {
            Session::flash('errors', $form->errors());
            Session::flash('old', $form->getData());
            goBack();
        }

        return $form->getData();
    }

    public function index(): void
    {
        $pageTitle = 'Žanrovi';
        $sql = "SELECT * FROM zanrovi z ORDER BY z.ime";
        
        try {
            $genres = $this->db->query($sql)->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $message = Session::get('message');       
        require basePath('views/genres/index.view.php');
    }
    
    public function show(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $pageTitle = 'Prikaz žanra';
        $sql = "SELECT f.*, 
                z.ime AS zanr, 
                GROUP_CONCAT(DISTINCT m.tip) AS medij, 
                c.tip_filma AS tip
                FROM filmovi f
                    JOIN cjenik c ON f.cjenik_id = c.id
                    JOIN zanrovi z ON f.zanr_id = z.id
                    LEFT JOIN kopija k ON k.film_id = f.id 
                    LEFT JOIN mediji m ON k.medij_id = m.id
                WHERE z.id = :id
                GROUP BY f.id
                ORDER BY f.naslov";
        
        try {
            $genre = $this->validateId($_GET['id']);

            $movies = $this->db->query($sql, [
                'id' => $_GET['id'],
            ])->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        foreach ($movies as $key => $movie) {
            $movies[$key]['medij'] = explode(',', $movie['medij']);
        }
        
        require basePath('views/genres/show.view.php');
    }
    
    public function edit(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $pageTitle = 'Uredi žanr';
            
        try {
            $genre = $this->validateId($_GET['id']);

        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');   
        require basePath('views/genres/edit.view.php');
    }
    
    public function update(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $postData = [
            'ime' => $_POST['name'] ?? null,
        ];     
        $rules = [
            'ime' => ['required', 'string', 'unique:zanrovi,' . $_POST['id'], 'max:100'],
        ]; 
        $data = $this->validateData($rules, $postData);

        $sql = "UPDATE zanrovi SET ime = :ime WHERE id = :id";
        
        try {
            $this->validateId($_POST['id']);

            $this->db->query($sql, [
                'ime' => $data['ime'], 
                'id' => $_POST['id'],
            ]);           
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno uređeni podaci o žanru {$data['ime']}."
        ]);        
        redirect('/genres');
    }
    
    public function create(): void
    {
        $pageTitle = 'Novi žanr';

        $errors = Session::get('errors');
        $old = Session::get('old');
        
        require basePath('views/genres/create.view.php');
    }
    
    public function store(): void
    {
        $postData = [
            'ime' => $_POST['name'] ?? null,
        ];      
        $rules = [
            'ime' => ['required', 'string', 'unique:zanrovi', 'max:100']
        ];
        $data = $this->validateData($rules, $postData);
        
        $sql = "INSERT INTO zanrovi (ime) VALUES (:ime)";
        
        try {
            $this->db->query($sql, [
                'ime' => $data['ime'],
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno kreiran žanr {$data['ime']}."
        ]);
        
        redirect('/genres');
    }
    
    public function destroy(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $sql = "DELETE FROM zanrovi WHERE id = :id";
        
        try {
            $genre = $this->validateId($_POST['id']);
        
            $this->db->query($sql, [
                'id' => $_POST['id'],
            ]);
        
        } catch (\PDOException $e) {
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Ne možete obrisati žanr {$genre['ime']} prije nego obrišete vezane filmove."
            ]);
            goBack();
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno obrisan žanr {$genre['ime']}."
        ]);
        goBack();
    } 
}