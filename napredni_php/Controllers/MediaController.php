<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Session;

class MediaController 
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    private function validateId(string $id): array
    {
        $sql = "SELECT * FROM mediji WHERE id = :id";
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
        $pageTitle = 'Mediji';
        $sql = "SELECT * FROM mediji ORDER BY tip";
        
        try {
            $mediaAll = $this->db->query($sql)->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $message = Session::get('message');  
        require basePath('views/media/index.view.php');
    }
    
    public function show(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort();
        }
        
        $pageTitle = 'Prikaz medija';
        $sql = "SELECT f.*, 
                z.ime AS zanr, 
                c.tip_filma AS tip, 
                COUNT(f.id) AS kolicina
                FROM filmovi f
                    JOIN cjenik c ON f.cjenik_id = c.id
                    JOIN zanrovi z ON f.zanr_id = z.id
                    JOIN kopija k ON k.film_id = f.id 
                    JOIN mediji m ON k.medij_id = m.id
                WHERE m.id = :id
                GROUP BY f.id
                ORDER BY f.naslov";

        try {
            $media = $this->validateId($_GET['id']);
            
            $movies = $this->db->query($sql, [
                'id' => $_GET['id'],
            ])->all();

        } catch (\PDOException $e) {
            abort(500);
        }
          
        require basePath('views/media/show.view.php');
    }
    
    public function edit(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $pageTitle = 'Uredi medij';
        
        try {
            $media = $this->validateId($_GET['id']);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');   
        require basePath('views/media/edit.view.php');
    }
    
    public function update(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $postData = [
            'tip' => $_POST['type'] ?? null,
            'koeficijent' => $_POST['coefficient'] ?? null,
        ]; 
        $rules = [
            'tip' => ['required', 'string', 'unique:mediji,' . $_POST['id'], 'max:100', 'min:2'],
            'koeficijent' => ['required', 'numeric:0,100', 'max:10'],
        ];
        $data = $this->validateData($rules, $postData);
      
        $sql = "UPDATE mediji SET tip = :tip, koeficijent = :koeficijent WHERE id = :id";
        
        try {
            $this->validateId($_POST['id']);

            $this->db->query($sql, [
                'tip' => $data['tip'], 
                'koeficijent' => $data['koeficijent'], 
                'id' => $_POST['id'],
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno uređeni podaci o mediju {$data['tip']}."
        ]);  
        redirect('/media');
    }
    
    public function create(): void
    {
        $pageTitle = 'Novi medij';

        $errors = Session::get('errors');
        $old = Session::get('old');
        
        require basePath('views/media/create.view.php');
    }
    
    public function store(): void
    {    
        $postData = [
            'tip' => $_POST['type'] ?? null,
            'koeficijent' => $_POST['coefficient'] ?? null,
        ];
        $rules = [
            'tip' => ['required', 'string', 'unique:mediji', 'max:100', 'min:2'],
            'koeficijent' => ['required', 'numeric:100', 'max:10'],
        ];    
        $data = $this->validateData($rules, $postData);
        
        $sql = "INSERT INTO mediji (tip, koeficijent) VALUES (:tip, :koeficijent)";
        
        try {
            $this->db->query($sql, [
                'tip' => $data['tip'], 
                'koeficijent' => $data['koeficijent'],
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno kreiran medij {$data['tip']}."
        ]); 
        redirect('/media');
    }
    
    public function destroy(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $sql = "DELETE FROM mediji WHERE id = :id";
        
        try {
            $media = $this->validateId($_POST['id']);
        
            $this->db->query(QUERY['delete'], [
                'id' => $_POST['id'],
            ]);
        
        } catch (\PDOException $e) {
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Ne možete obrisati medij {$media['tip']} prije nego obrišete vezane kopije filmova."
            ]);
            goBack();
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno obrisan medij {$media['tip']}."
        ]);
        goBack();
    } 
}