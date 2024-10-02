<?php

namespace Controllers;

use Core\Database;
use Core\Session;

class DashboardController 
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

    public function index(): void
    {
        $pageTitle = 'Nova posudba';
        $sql = [
            'clanovi'
                => "SELECT c.id AS clan_id, c.ime, c.prezime, c.clanski_broj 
                FROM clanovi c",
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
            'posudbe'
                => "SELECT ps.id, ps.datum_posudbe, ps.datum_povrata, 
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
                WHERE datum_povrata IS NULL
                ORDER BY ps.id",
        ];
        
        try {
            $members = $this->db->query($sql['clanovi'])->all();
        
            $copies = $this->db->query($sql['kopije'])->all();
        
            $rentals = $this->db->query($sql['posudbe'])->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $message = Session::get('message');
        $errors = Session::get('errors');
       
        require basePath('views/dashboard/index.view.php');
    }
    
    public function returnMovie(): void
    {
        if (!isset($_POST['pid']) || !is_numeric($_POST['pid']) || !isset($_POST['kid']) || !is_numeric($_POST['kid'])) {
            abort(); 
        }
        
        $sql = [
            'posudba'
                => "SELECT * FROM posudba WHERE id = :id",
            'kopija'
                => "SELECT * FROM kopija WHERE id = :id",
            'select_posudba_kopija'
                => "SELECT kopija_id FROM posudba_kopija WHERE posudba_id = :posudba_id",
            'update_povrat' 
                => "UPDATE posudba SET datum_povrata = :datum_povrata WHERE id = :id",
            'update_at' 
                => "UPDATE posudba SET updated_at = :updated_at WHERE id = :id",
            'delete_posudba_kopija'
                => "DELETE FROM posudba_kopija WHERE posudba_id = :posudba_id AND kopija_id = :kopija_id",
            'update_kopija' 
                => "UPDATE kopija SET dostupan = 1 WHERE id = :id",
        ];
        
        $date = date('Y-m-d');
        $dateTime = date('Y-m-d H:i:s');
        
        try {
            $this->db->connection()->beginTransaction();
        
            $this->validateId($_POST['pid'], 'posudba');
            
            $this->validateId($_POST['kid'], 'kopija');
                
            $copies = $this->db->query(QUERY['kopije'], [
                'posudba_id' => $_POST['pid'],
            ])->all();
        
            if (count($copies) === 1) {
                $this->db->query(QUERY['update_povrat'], [
                    'datum_povrata' => $date, 
                    'id' => $_POST['pid'],
                ]);
            } else {
                $this->db->query(QUERY['update_at'], [
                    'updated_at' => $dateTime, 
                    'id' => $_POST['pid'],
                ]);
            }
            
            $this->db->query(QUERY['update_kopija'], [
                'id' => $_POST['kid'],
            ]);
                
            $this->db->query(QUERY['delete_posudba_kopija'], [
                    'posudba_id' => $_POST['pid'],
                    'kopija_id' => $_POST['kid'],
            ]);
            
            $this->db->connection()->commit();
        
        } catch (\PDOException $e) {
            $this->db->connection()->rollBack();
        
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno zaključena posudba."
        ]);      
        redirect('/dashboard');
    }
}