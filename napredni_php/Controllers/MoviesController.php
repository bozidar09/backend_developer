<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Session;

class MoviesController 
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    private function validateId(string $id): array
    {
        $sql = "SELECT * FROM filmovi WHERE id = :id";
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
        $pageTitle = 'Filmovi';
        $sql = "SELECT f.*, 
                z.ime AS zanr, 
                GROUP_CONCAT(DISTINCT m.tip) AS medij, 
                c.tip_filma AS tip
            FROM filmovi f
                JOIN cjenik c ON f.cjenik_id = c.id
                JOIN zanrovi z ON f.zanr_id = z.id
                LEFT JOIN kopija k ON k.film_id = f.id 
                LEFT JOIN mediji m ON k.medij_id = m.id
            GROUP BY f.id
            ORDER BY f.naslov";
        
        try {
            $movies = $this->db->query($sql)->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        foreach ($movies as $key => $movie) {
            $movies[$key]['medij'] = explode(',', $movie['medij']);
        }
        
        $message = Session::get('message');  
        require basePath('views/movies/index.view.php');
    }
    
    public function show(): void
    {
        $pageTitle = 'Prikaz filma';

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $sql = [
            'movie' 
                => "SELECT f.*, 
                z.ime AS zanr, 
                GROUP_CONCAT(DISTINCT m.tip) AS medij, 
                c.tip_filma AS tip
                FROM filmovi f
                    JOIN cjenik c ON f.cjenik_id = c.id
                    JOIN zanrovi z ON f.zanr_id = z.id
                    LEFT JOIN kopija k ON k.film_id = f.id 
                    LEFT JOIN mediji m ON k.medij_id = m.id
                WHERE f.id = :id
                GROUP BY f.id",
            'copiesByMovie' 
                => "SELECT k.id, k.barcode, k.dostupan,
                f.naslov, 
                m.tip AS medij
                FROM kopija k
                    JOIN mediji m ON m.id = k.medij_id
                    JOIN filmovi f ON f.id = k.film_id
                WHERE f.id = :id
                ORDER BY k.barcode",
        ];
        
        try {
            $movie = $this->db->query($sql['movie'], [
                'id' => $_GET['id'],
            ])->findOrFail();
                  
            $copies = $this->db->query($sql['copiesByMovie'], [
                'id' => $_GET['id'],
                ])->all();
                
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $movie['medij'] = explode(',', $movie['medij']);
            
        require basePath('views/movies/show.view.php');
    }
    
    public function edit(): void
    {
        $pageTitle = 'Uredi film';

        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $sql = [
            'film'
                => "SELECT f.*, 
                    z.ime AS zanr, 
                    c.tip_filma AS tip
                FROM filmovi f
                    JOIN zanrovi z ON f.zanr_id = z.id
                    JOIN cjenik c ON f.cjenik_id = c.id
                WHERE f.id = :id",
            'zanrovi'
                => "SELECT * FROM zanrovi",
            'cjenik'
                => "SELECT * FROM cjenik",
        ];
        
        try {
            $movie = $this->db->query($sql['film'], [
                'id' => $_GET['id'],
            ])->findOrFail();
            
            $genres = $this->db->query($sql['zanrovi'])->all();
            
            $movieTypes = $this->db->query($sql['cjenik'])->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');
        
        require basePath('views/movies/edit.view.php');
    }
    
    public function update(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $postData = [
            'naslov' => $_POST['title'] ?? null,
            'godina' => $_POST['year'] ?? null,
            'zanr_id' => $_POST['genre'] ?? null,
            'cjenik_id' => $_POST['movie_type'] ?? null,
        ];   
        $rules = [
            'naslov' => ['required', 'string', 'max:100', 'uniqueMovie:filmovi,' . $_POST['year'] . ',' . $_POST['id']],
            'godina' => ['required', 'numeric', 'max:4', 'min:4'],
            'zanr_id' => ['required', 'exists:zanrovi,id', 'numeric'],
            'cjenik_id' => ['required', 'exists:cjenik,id', 'numeric'],
        ];
        $data = $this->validateData($rules, $postData);
        
        $sql = "UPDATE filmovi SET naslov = :naslov, godina = :godina, zanr_id = :zanr_id, cjenik_id = :cjenik_id WHERE id = :id";
        
        try {
            $this->validateId($_POST['id']);

            $this->db->query($sql, [
                'naslov' => $data['naslov'], 
                'godina' => $data['godina'], 
                'zanr_id' => $data['zanr_id'], 
                'cjenik_id' => $data['cjenik_id'], 
                'id' => $_POST['id'],
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno uređeni podaci o filmu {$data['naslov']} {$data['godina']}."
        ]);     
        redirect('/movies');
    }
    
    public function create(): void
    {
        $pageTitle = 'Novi film';

        $sql = [
            'zanrovi'
                => "SELECT * FROM zanrovi",
            'cjenik'
                => "SELECT * FROM cjenik",
            'mediji'
                => "SELECT * FROM mediji",
        ];
        
        try {
            $genres = $this->db->query($sql['zanrovi'])->all();
        
            $movieTypes = $this->db->query($sql['cjenik'])->all();
        
            $mediaAll = $this->db->query($sql['mediji'])->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');
        $old = Session::get('old');
        
        require basePath('views/movies/create.view.php');
    }
    
    public function store(): void
    {     
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
       
        $sql = [
            'movie' 
                => "INSERT INTO filmovi (naslov, godina, zanr_id, cjenik_id) VALUES (:naslov, :godina, :zanr, :tip)",
            'media' 
                => "SELECT * FROM mediji",
            'copy' 
                => "INSERT INTO kopija (barcode, film_id, medij_id) VALUES ",
        ];
        
        
        try {   
            $media = $this->db->query($sql['media'])->all();
            foreach ($media as $key => $elements) {
                $mediaByType[$elements['tip']] = $elements;
                $postData[$elements['tip']] = $_POST[strtolower($elements['tip'])] ?? null;
                $rules[$elements['tip']] = ['numeric:0,100', 'max:2'];
            }
        
            $data = $this->validateData($rules, $postData);
            $copies = array_slice($data, 4);
        
            $this->db->query($sql['movie'], [
                'naslov' => $data['naslov'], 
                'godina' => $data['godina'], 
                'zanr' => $data['zanr_id'], 
                'tip' => $data['cjenik_id'],
            ]);
        
            $movieId = $this->db->connection()->lastInsertId();
        
            foreach ($copies as $key => $amount) {
                $sql = QUERY['copy'];
                
                if (isset($copies[$key])) {       
                    $barcode = mb_strtoupper($data['naslov'] . '_' . $key . '1');
                    $mediaId = $mediaByType[$key]['id'];
            
                    for ($i=1; $i < $amount; $i++) { 
                        $sql .= "(:barcode, :film, :medij),";
                    }
                    $sql .= "(:barcode, :film, :medij)";
                    
                    $this->db->query($sql, [
                        'barcode' => $barcode,
                        'film' => $movieId,
                        'medij' => $mediaId,
                    ]);
                }
            };
        
            $this->db->connection()->commit();
            
        } catch (\PDOException $e) {
            $this->db->connection()->rollBack();
        
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno kreiran film {$data['naslov']} {$data['godina']}."
        ]);     
        redirect('/movies');
    }
    
    public function destroy(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $sql = "DELETE FROM filmovi WHERE id = :id";
        
        try {
            $movie = $this->validateId($_POST['id']);
        
            $this->db->query($sql, ['id' => $_POST['id']]);
        
        } catch (\PDOException $e) {
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Ne možete obrisati film {$movie['naslov']} {$movie['godina']} prije nego obrišete vezane kopije."
            ]);
            goBack();
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno obrisan film {$movie['naslov']} {$movie['godina']}."
        ]);
        goBack();
    } 
}