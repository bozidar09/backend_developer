<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Session;

class PricesController 
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    private function validateId(string $id): array
    {
        $sql = "SELECT * FROM cjenik WHERE id = :id";
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
        $pageTitle = 'Cjenik';
        $sql = "SELECT id, tip_filma AS tip, cijena, zakasnina_po_danu AS zakasnina FROM cjenik ORDER BY tip";
        
        try {
            $prices = $this->db->query($sql)->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $message = Session::get('message');  
        require basePath('views/prices/index.view.php');
    }
    
    public function show(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $pageTitle = 'Prikaz tipa filma';
        $sql = "SELECT f.*, 
                    z.ime AS zanr, 
                    GROUP_CONCAT(DISTINCT m.tip) AS medij, 
                    c.tip_filma AS tip
                FROM filmovi f
                    JOIN cjenik c ON f.cjenik_id = c.id
                    JOIN zanrovi z ON f.zanr_id = z.id
                    LEFT JOIN kopija k ON k.film_id = f.id 
                    LEFT JOIN mediji m ON k.medij_id = m.id
                WHERE c.id = :id
                GROUP BY f.id
                ORDER BY f.naslov";
        
        try {
            $price = $this->validateId($_GET['id']);
            
            $movies = $this->db->query($sql, [
                'id' => $_GET['id'],
            ])->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        foreach ($movies as $key => $movie) {
            $movies[$key]['medij'] = explode(',', $movie['medij']);
        }
        
        require basePath('views/prices/show.view.php');
    }
    
    public function edit(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $pageTitle = 'Uredi tip filma';
        
        try {
            $price = $this->validateId($_GET['id']);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');   
        require basePath('views/prices/edit.view.php');
    }
    
    public function update(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $postData = [
            'tip_filma' => $_POST['movie_type'] ?? null,
            'cijena' => $_POST['price'] ?? null,
            'zakasnina_po_danu' => $_POST['late_fee'] ?? null,
        ];
        $rules = [
            'tip_filma' => ['required', 'unique:cjenik,' . $_POST['id'], 'string', 'max:20', 'min:2'],
            'cijena' => ['required', 'numeric:0,10000', 'max:10'],
            'zakasnina_po_danu' => ['required', 'numeric;0,1000', 'max:10'],
        ];
        $data = $this->validateData($rules, $postData);
        
        $sql = "UPDATE cjenik SET tip_filma = :tip_filma, cijena = :cijena, zakasnina_po_danu = :zakasnina_po_danu WHERE id = :id";
        
        try {
            $this->validateId($_POST['id']);

            $this->db->query($sql, [
                'tip_filma' => $data['tip_filma'], 
                'cijena' => $data['cijena'], 
                'zakasnina_po_danu' => $data['zakasnina_po_danu'], 
                'id' => $_POST['id'],
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno uređeni podaci o tipu filma {$data['tip_filma']}."
        ]); 
        redirect('/prices');
    }
    
    public function create(): void
    {
        $pageTitle = 'Novi tip filma';

        $errors = Session::get('errors');
        $old = Session::get('old');
        
        require basePath('views/prices/create.view.php');
    }
    
    public function store(): void
    {
        $postData = [
            'tip_filma' => $_POST['movie_type'] ?? null,
            'cijena' => $_POST['price'] ?? null,
            'zakasnina_po_danu' => $_POST['late_fee'] ?? null,
        ];    
        $rules = [
            'tip_filma' => ['required', 'unique:cjenik', 'string', 'max:20', 'min:2'],
            'cijena' => ['required', 'numeric:0,10000', 'max:10'],
            'zakasnina_po_danu' => ['required', 'numeric:0,1000', 'max:10'],
        ];
        $data = $this->validateData($rules, $postData);
        
        $sql = "INSERT INTO cjenik (tip_filma, cijena, zakasnina_po_danu) VALUES (:tip_filma, :cijena, :zakasnina_po_danu)";
        
        try {
            $this->db->query($sql, [
                'tip_filma' => $data['tip_filma'], 
                'cijena' => $data['cijena'], 
                'zakasnina_po_danu' => $data['zakasnina_po_danu'], 
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno kreiran tip filma {$data['tip_filma']}."
        ]);    
        redirect('/prices');
    }
    
    public function destroy(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
            
        $sql = "DELETE FROM cjenik WHERE id = :id";
        
        try {
            $price = $this->validateId($_POST['id']);
        
            $this->db->query($sql, ['id' => $_POST['id']]);
        
        } catch (\PDOException $e) {
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Ne možete obrisati tip filma {$price['tip_filma']} prije nego obrišete vezani film."
            ]);
            goBack();
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno obrisan tip filma {$price['tip_filma']}."
        ]);
        goBack();
    } 
}