<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Session;

class CopiesController 
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    private function validateId(string $id): array
    {
        $sql = "SELECT * FROM kopija WHERE id = :id";
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
        $pageTitle = 'Količine';     
        $sql = "SELECT f.id, f.naslov, 
                k.barcode, k.medij_id,
                m.tip AS medij, 
                COUNT(f.id) AS kolicina
            FROM kopija k
                JOIN mediji m ON m.id = k.medij_id
                JOIN filmovi f ON f.id = k.film_id
            GROUP BY f.id, k.barcode, m.tip
            ORDER BY f.naslov";
        
        try {
            $amountAll = $this->db->query($sql)->all();
        
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $message = Session::get('message');     
        require basePath('views/copies/index.view.php');
    }
    
    public function show(): void
    {
        if (!isset($_GET['barcode']) || !isset($_GET['media']) || !is_numeric($_GET['media'])) {
            abort(); 
        }
        
        $pageTitle = 'Kopije';
        $sql = "SELECT k.id, k.barcode, k.dostupan,
                f.naslov,      
                m.tip AS medij
            FROM kopija k
                JOIN mediji m ON m.id = k.medij_id
                JOIN filmovi f ON f.id = k.film_id
            WHERE k.barcode = :barcode && m.id = :medij_id
            ORDER BY k.id";
        
        try {
            $copies = $this->db->query($sql, [
                'barcode' => $_GET['barcode'], 
                'medij_id' => $_GET['media'],
            ])->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        if (empty($copies)) {
            abort();
        }
        
        $message = Session::get('message');  
        require basePath('views/copies/show.view.php');
    }
    
    public function edit(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $pageTitle = 'Uredi kopiju';
        $sql = "SELECT * FROM kopija WHERE id = :id";
        
        try {
            $copy = $this->validateId($_GET['id']);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');     
        require basePath('views/copies/edit.view.php');
    }
    
    public function update(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $postData = [
            'barcode' => $_POST['barcode'] ?? null,
            'dostupan' => $_POST['available'] ?? null,
        ];   
        $rules = [
            'barcode' => ['required', 'string', 'max:50', 'min:5'],
            'dostupan' => ['numeric:0,1'],
        ];
        $data = $this->validateData($rules, $postData);
        
        $sql = "UPDATE kopija SET barcode = :barcode, dostupan = :dostupan WHERE id = :id";
         
        try {
            $this->validateId($_POST['id']);

            $this->db->query($sql, [
                'barcode' => $data['barcode'], 
                'dostupan' => $data['dostupan'], 
                'id' => $_POST['id'],
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno uređeni podaci o kopiji filma."
        ]);       
        redirect('/copies');
    }
    
    public function create(): void
    {
        $pageTitle = 'Dodaj nove kopije';
        $sql = [
            'filmovi'
                => "SELECT * FROM filmovi",
            'mediji'
                => "SELECT * FROM mediji",
        ];
                
        try {
            $movies = $this->db->query($sql['filmovi'])->all();
            
            $mediaAll = $this->db->query($sql['mediji'])->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');
        $old = Session::get('old');        
        require basePath('views/copies/create.view.php');
    }
    
    public function store(): void
    {
        isset($_POST['movie']) ? $movie = explode('-', $_POST['movie']) : $movie = '';
        
        $postData = [
            'film_id' => $movie[0] ?? null,
            'naslov' => $movie[1] ?? null,
        ];       
        $rules = [
            'film_id' => ['required', 'exists:filmovi,id', 'numeric'],
            'naslov' => ['required', 'exists:filmovi,naslov', 'string', 'max:100'],
        ];
        
        $sql = [
            'media' => "SELECT * FROM mediji",
            'copy' => "INSERT INTO kopija (barcode, film_id, medij_id) VALUES ",
        ];
        
        
        try {
            $this->db->connection()->beginTransaction();
        
            $media = $this->db->query($sql['media'])->all();
            foreach ($media as $key => $elements) {
                $mediaByType[$elements['tip']] = $elements;
                $postData[$elements['tip']] = $_POST[strtolower($elements['tip'])] ?? null;
                $rules[$elements['tip']] = ['numeric:0,100', 'max:2'];
            }
        
            $data = $this->validateData($rules, $postData);
            $copies = array_slice($data, 2);
            
            foreach ($copies as $key => $amount) {
                $sqlPatch = $sql['copy'];
                
                if (isset($copies[$key])) {       
                    $barcode = mb_strtoupper($data['naslov'] . '_' . $key . '1');
                    $mediaId = $mediaByType[$key]['id'];
            
                    for ($i=1; $i < $amount; $i++) { 
                        $sqlPatch .= "(:barcode, :film, :medij),";
                    }
                    $sqlPatch .= "(:barcode, :film, :medij)";
                    
                    $this->db->query($sqlPatch, [
                        'barcode' => $barcode,
                        'film' => $data['film_id'],
                        'medij' => $mediaId,
                    ]);
                }
            };
        
            $this->db->connection()->commit();
        
        } catch (\PDOException $e) {
            $this->db->connection()->rollBack();
        
            abort(500);;
        }
        
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno kreirane kopije filma."
        ]);
        
        redirect('/copies');
    }
    
    public function destroy(): void
    {
        if (!isset($_POST['code'])) {
            abort();
        }
        
        $sql = [
            'barcode'
            => "SELECT COUNT(*) FROM kopija WHERE barcode = :barcode GROUP BY barcode",
            'delete'
            => "DELETE FROM kopija WHERE id = :id",
            'deleteAll'
            => "DELETE FROM kopija WHERE barcode = :barcode",
        ];
        
        
        try {
            if (parse_url($_SERVER['HTTP_REFERER'])['path'] === '/copies/show') {
                $this->validateId($_POST['code']);
        
                $this->db->query($sql['delete'], [
                    'id' => $_POST['code'],
                ]);
        
            } else {
                $this->db->query($sql['barcode'], [
                    'barcode' => $_POST['code'],
                ])->findOrFail();
        
                $this->db->query($sql['deleteAll'], [
                    'barcode' => $_POST['code'],
                ]);
            }
        
        } catch (\PDOException $e) { 
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Ne možete obrisati kopiju filma prije nego obrišete vezane posudbe."
            ]);
            goBack();
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno obrisana kopija filma."
        ]);
        goBack();
    } 
}