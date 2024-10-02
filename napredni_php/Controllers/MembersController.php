<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Session;

class MembersController 
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
    }

    private function validateId(string $id): array
    {
        $sql = "SELECT * FROM clanovi WHERE id = :id";
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
        $pageTitle = 'Članovi';
        $sql = "SELECT * FROM clanovi ORDER BY clanski_broj";
        
        try {
            $members = $this->db->query($sql)->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $message = Session::get('message');
        require basePath('views/members/index.view.php');
    }
    
    public function show(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort();
        }
        
        $pageTitle = 'Prikaz člana';
        $sql = "SELECT ps.id, ps.datum_posudbe AS datum, 
                    CONCAT(cl.ime, ' ', cl.prezime) AS clan, 
                    f.naslov, f.godina, 
                    z.ime AS zanr, 
                    m.tip AS medij,
                    ROUND(cj.cijena * m.koeficijent, 2) AS cijena,
                    ROUND(((DATEDIFF(CURDATE(), ps.datum_posudbe)-1) * cj.zakasnina_po_danu * m.koeficijent), 2) AS zakasnina
                FROM posudba_kopija pk 
                    JOIN posudba ps ON pk.posudba_id = ps.id
                    JOIN clanovi cl ON ps.clan_id = cl.id 
                    JOIN kopija k ON pk.kopija_id = k.id 
                    JOIN mediji m ON k.medij_id = m.id
                    JOIN filmovi f ON k.film_id = f.id
                    JOIN cjenik cj ON f.cjenik_id = cj.id
                    JOIN zanrovi z ON f.zanr_id = z.id
                WHERE cl.id = :id AND ps.datum_povrata IS NULL
                ORDER BY datum";
        
        try {
            $member = $this->validateId($_GET['id']);
            
            $rentals = $this->db->query($sql, [
                'id' => $_GET['id'],
            ])->all();
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        require basePath('views/members/show.view.php');
    }
    
    public function edit(): void
    {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            abort(); 
        }
        
        $pageTitle = 'Uredi člana';
        
        try {
            $member = $this->validateId($_GET['id']);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $errors = Session::get('errors');   
        require basePath('views/members/edit.view.php');
    }
    
    public function update(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $postData = [
            'ime' => $_POST['name'] ?? null,
            'prezime' => $_POST['surname'] ?? null,
            'adresa' => $_POST['address'] ?? null,
            'telefon' => $_POST['phone'] ?? null,
            'email' => $_POST['email'] ?? null,
            'clanski_broj' => $_POST['member_id'] ?? null,
        ];    
        $rules = [
            'ime' => ['required', 'string', 'max:50', 'min:2'],
            'prezime' => ['required', 'string', 'max:50', 'min:2'],
            'adresa' => ['string', 'max:100'],
            'telefon' => ['phone','max:15'],
            'email' => ['required', 'email', 'unique:clanovi,' . $_POST['id'], 'max:100'],
            'clanski_broj' => ['required', 'string', 'unique:clanovi,' . $_POST['id'], 'max:14', 'min:8', 'clanskiBroj']
        ];  
        $data = $this->validateData($rules, $postData);
        
        $sql = "UPDATE clanovi SET ime = :ime, prezime = :prezime, adresa = :adresa, telefon = :telefon, email = :email, clanski_broj = :clanski_broj WHERE id = :id";
        
        try {
            $this->validateId($_POST['id']);

            $this->db->query($sql, [
                'ime' => $data['ime'], 
                'prezime' => $data['prezime'], 
                'adresa' => $data['adresa'],
                'telefon' => $data['telefon'],
                'email' => $data['email'], 
                'clanski_broj' => $data['clanski_broj'], 
                'id' => $_POST['id'],
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno uređeni podaci o članu {$data['ime']} {$data['prezime']}."
        
        ]);
        redirect('/members');
    }
    
    public function create(): void
    {
        $pageTitle = 'Novi član';

        $errors = Session::get('errors');
        $old = Session::get('old');
        
        require basePath('views/members/create.view.php');
    }
    
    public function store(): void
    {
        $postData = [
            'ime' => $_POST['name'] ?? null,
            'prezime' => $_POST['surname'] ?? null,
            'adresa' => $_POST['address'] ?? null,
            'telefon' => $_POST['phone'] ?? null,
            'email' => $_POST['email'] ?? null,
            'clanski_broj' => $_POST['member_id'] ?? null,
        ];     
        $rules = [
            'ime' => ['required', 'string', 'max:50', 'min:2'],
            'prezime' => ['required', 'string','max:50', 'min:2'],
            'adresa' => ['string', 'max:100'],
            'telefon' => ['phone','max:15'],
            'email' => ['required', 'email', 'unique:clanovi', 'max:100'],
        ]; 
        $data = $this->validateData($rules, $postData);

        $sql = [
            'clanski_broj'
                => "SELECT clanski_broj FROM clanovi 
                    ORDER BY clanski_broj DESC 
                    LIMIT 1",
            'insert'
                => "INSERT INTO clanovi (ime, prezime, adresa, telefon, email, clanski_broj) VALUES (:ime, :prezime, :adresa, :telefon, :email, :clanski_broj)",
        ];

        try {
            $clanId = $this->db->query($sql['clanski_broj'])->find();
            $clanId = 'CLAN' . (str_replace('CLAN', '', $clanId['clanski_broj']) + 1);
            
            $this->db->query($sql['insert'], [
                'ime' => $data['ime'], 
                'prezime' => $data['prezime'], 
                'adresa' => $data['adresa'],
                'telefon' => $data['telefon'],
                'email' => $data['email'], 
                'clanski_broj' => $clanId,
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno kreiran član {$data['ime']} {$data['prezime']}."
        ]);   
        redirect('/members');
    }
    
    public function destroy(): void
    {
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            abort();
        }
        
        $sql = "DELETE FROM clanovi WHERE id = :id";
        
        try {
            $member = $this->validateId($_POST['id']);
            
            $this->db->query(QUERY['delete'], [
                'id' => $_POST['id'],
            ]);
        
        } catch (\PDOException $e) {
            Session::flash('message', [
                'type' => 'danger',
                'message' => "Ne možete obrisati člana {$member['ime']} {$member['prezime']} prije nego obrišete vezane posudbe."
            ]);
            goBack();
        }
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno obrisan član {$member['ime']} {$member['prezime']}."
        ]);
        goBack();
    } 
}