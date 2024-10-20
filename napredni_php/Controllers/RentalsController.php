<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Session;

class RentalsController 
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    private function validateId(string $id, string $table): array
    {
        $sql = "SELECT * FROM :tableData WHERE id = :id";
        return $this->db->query($sql, [
            'id' => $id,
            'tableData' => $table,
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
        $pageTitle = 'Posudbe';

        $sql = "SELECT ps.id, ps.datum_posudbe, ps.datum_povrata, 
                cl.ime, cl.prezime, cl.clanski_broj,
                k.film_id,
                pk.kopija_id,
                f.naslov, f.godina, 
                z.ime AS zanr, 
                m.tip AS medij,
                ROUND(cj.cijena * m.koeficijent, 2) AS cijena,
                ROUND(cj.zakasnina_po_danu * m.koeficijent, 2) AS zakasnina
            FROM posudba_kopija pk 
                JOIN posudba ps ON pk.posudba_id = ps.id
                JOIN clanovi cl ON ps.clan_id = cl.id 
                JOIN kopija k ON pk.kopija_id = k.id 
                JOIN mediji m ON k.medij_id = m.id
                JOIN filmovi f ON k.film_id = f.id
                JOIN cjenik cj ON f.cjenik_id = cj.id
                JOIN zanrovi z ON f.zanr_id = z.id
            ORDER BY ps.id";
        
        try {
            $rentals = $this->db->query($sql)->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $message = Session::get('message');       
        require basePath('views/rentals/index.view.php');
    }
    
    public function show(): void
    {       
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['movie']) || !is_numeric($_GET['movie'])) {
            abort(); 
        }
        
        $pageTitle = 'Posudba';
        $sql = "SELECT ps.id, ps.datum_posudbe, ps.datum_povrata, 
                CASE 
                    WHEN ps.datum_povrata IS NULL THEN DATEDIFF(CURDATE(), ps.datum_posudbe)
                    ELSE DATEDIFF(ps.datum_povrata, ps.datum_posudbe)
                END AS dani_posudbe,
                cl.ime, cl.prezime, cl.clanski_broj, 
                k.film_id,
                pk.kopija_id,
                f.naslov, f.godina, 
                z.ime AS zanr, 
                m.tip AS medij,
                ROUND(cj.cijena * m.koeficijent, 2) AS cijena,
                ROUND(cj.zakasnina_po_danu * m.koeficijent, 2) AS zakasnina
            FROM posudba_kopija pk 
                JOIN posudba ps ON pk.posudba_id = ps.id
                JOIN clanovi cl ON ps.clan_id = cl.id 
                JOIN kopija k ON pk.kopija_id = k.id 
                JOIN mediji m ON k.medij_id = m.id
                JOIN filmovi f ON k.film_id = f.id
                JOIN cjenik cj ON f.cjenik_id = cj.id
                JOIN zanrovi z ON f.zanr_id = z.id
            WHERE ps.id = :id AND k.film_id = :film_id";
    
        try {
            $rental = $this->db->query($sql, [
                'id' => $_GET['id'],
                'film_id' => $_GET['movie'],
            ])->findOrFail();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        if ($rental['dani_posudbe'] <= 1) {
            $rental['dani_kasnjenja'] = 0;
            $rental['zakasnina_ukupno'] = 0;
            $rental['dugovanje'] = $rental['cijena'];
        } else {
            $rental['dani_kasnjenja'] = $rental['dani_posudbe'] - 1;
            $rental['zakasnina_ukupno'] = $rental['dani_kasnjenja'] * $rental['zakasnina'];
            $rental['dugovanje'] = $rental['cijena'] + $rental['zakasnina_ukupno'];
        }
        
        require basePath('views/rentals/show.view.php');
    }
    
    public function edit(): void
    {        
        if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['movie']) || !is_numeric($_GET['movie'])) {
            abort(); 
        }
        
        $pageTitle = 'Uredi posudbu';
        $sql = "SELECT ps.id, ps.datum_posudbe, ps.datum_povrata, 
                cl.ime, cl.prezime, cl.clanski_broj,
                pk.kopija_id,
                k.film_id,
                f.naslov, f.godina, 
                m.tip AS medij
            FROM posudba_kopija pk 
                JOIN posudba ps ON pk.posudba_id = ps.id
                JOIN clanovi cl ON ps.clan_id = cl.id 
                JOIN kopija k ON pk.kopija_id = k.id 
                JOIN mediji m ON k.medij_id = m.id
                JOIN filmovi f ON k.film_id = f.id
            WHERE ps.id = :id AND k.film_id = :film_id";

        
        try {
            $rental = $this->db->query($sql, [
                'id' => $_GET['id'],
                'film_id' => $_GET['movie'],
            ])->findOrFail();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');       
        require basePath('views/rentals/edit.view.php');
    }
    
    public function update(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $date = date('Y-m-d');
        $postData = [
            'datum_posudbe' => $_POST['rental'] ?? null,
            'datum_povrata' => $_POST['return'] ?? null,
        ];    
        $rules = [
            'datum_posudbe' => ['required', 'date:' . $date],
            'datum_povrata' => ['date:' . $date . ',' . $_POST['rental']],
        ];
        $data = $this->validateData($rules, $postData);

        $sql = [
            'posudba' 
                => "UPDATE posudba SET datum_posudbe = :datum_posudbe, datum_povrata = :datum_povrata WHERE id = :id",
            'kopije'
                => "SELECT kopija_id FROM posudba_kopija WHERE posudba_id = :posudba_id",
            'update' 
                => "UPDATE kopija SET dostupan = :dostupan WHERE id = :id",
        ];
   
        try {
            $this->db->connection()->beginTransaction();

            $this->validateId($_POST['id'], 'posudba');
        
            $this->db->query($sql['posudba'], [
                'datum_posudbe' => $data['datum_posudbe'], 
                'datum_povrata' => $data['datum_povrata'], 
                'id' => $_POST['id'],
            ]);
            
            isset($data['datum_povrata']) ? $dostupan = 1 : $dostupan = 0;
            
            $copies = $this->db->query($sql['kopije'], [
                'posudba_id' => $_POST['id'],
            ])->all();
            
            foreach ($copies as $copy) {
                $this->db->query($sql['update'], [
                    'dostupan' => $dostupan,
                    'id' => $copy['kopija_id'],
                ]);
            }
            
            $this->db->connection()->commit();
            
        } catch (\PDOException $e) {
            $this->db->connection()->rollBack();
        
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno uređeni podaci o posudbi i dostupnosti kopija filmova."
        ]);       
        redirect('/rentals');
    }
    
    public function create(): void
    {
        $pageTitle = 'Nova posudba';
        $sql = [
            'clanovi'
                => "SELECT id AS clan_id, ime, prezime, clanski_broj FROM clanovi",
            'kopije'
                => "SELECT f.id AS film_id, f.naslov, f.godina,
                    m.id AS medij_id, m.tip AS medij, 
                    COUNT(f.id) AS kolicina
                FROM kopija k
                    JOIN mediji m ON m.id = k.medij_id
                    JOIN filmovi f ON f.id = k.film_id
                WHERE k.dostupan = 1
                GROUP BY f.id, m.id
                ORDER BY f.naslov",
        ];
    
        try {
            $members = $this->db->query($sql['clanovi'])->all();
        
            $copies = $this->db->query($sql['kopije'])->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');
        $old = Session::get('old');       
        require basePath('views/rentals/create.view.php');
    }
    
    public function store(): void
    {
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
        $data = $this->validateData($rules, $postData);
        
        $sql = [
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
     
        try {
            $this->db->connection()->beginTransaction();
        
            $this->db->query($sql['posudba'], [
                'datum_posudbe' => $date, 
                'clan_id' => $data['clan_id'], 
            ]);
            
            $rentalId = $this->db->connection()->lastInsertId();
            
            $copy = $this->db->query($sql['kopija'], [
                'film_id' => $data['film_id'], 
                'medij_id' => $data['medij_id'], 
            ])->findOrFail();
            
            $this->db->query($sql['posudba_kopija'], [
                'posudba_id' => $rentalId,  
                'kopija_id' => $copy['id'], 
            ]);
            
            $this->db->query($sql['update_kopija'], [
                'id' => $copy['id'], 
            ]);
            
            $this->db->connection()->commit();
            
        } catch (\PDOException $e) {
            $this->db->connection()->rollBack();
        
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
    }
    
    public function destroy(): void
    {
        if (!isset($_POST['pid']) || !is_numeric($_POST['pid']) || !isset($_POST['kid']) || !is_numeric($_POST['kid'])) {
            abort();
        }
        
        $sql = [
            'kopija'
                => "SELECT kopija_id FROM posudba_kopija WHERE posudba_id = :posudba_id",
            'deletePosudba'
                => "DELETE FROM posudba WHERE id = :id",
            'updatePosudba' 
                => "UPDATE posudba SET updated_at = :updated_at WHERE id = :id",
            'deletePosudbaKopija'
                    => "DELETE FROM posudba_kopija WHERE pid = :pid AND kid = :kid",
            'updateKopija' 
                => "UPDATE kopija SET dostupan = 1 WHERE id = :id",
        ];
        
        $dateTime = date("Y-m-d H:i:s");

        
        try {
            $this->db->connection()->beginTransaction();
        
            $this->validateId($_POST['pid'], 'posudba');

            $this->validateId($_POST['kid'], 'kopija');
            
            $copies = $this->db->query($sql['kopija'], [
                'posudba_id' => $_POST['pid'],
            ])->all();
            
            if (count($copies) === 1) {
                $this->db->query($sql['deletePosudba'], [
                    'id' => $_POST['pid'],
                ]);
            } else {
                $this->db->query($sql['updatePosudba'], [
                    'updated_at' => $dateTime,
                ]);
            }
            
            $this->db->query($sql['deletePosudbaKopija'], [
                'pid' => $_POST['pid'],
                'kid' => $_POST['kid'],
            ]);

            $this->db->query($sql['updateKopija'], [
                'id' => $_POST['kid'],
            ]);
            
            $this->db->connection()->commit();
        
        } catch (\PDOException $e) {
            $this->db->connection()->rollBack();
            
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Ne možete obrisati posudbu jer se podaci koriste u drugim tablicama."
            ]);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno obrisana posudba."
        ]);
        goBack();
    } 
}