<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Session;

class RegisterController 
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::get();
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

    public function create()
    {
        $pageTitle = 'Register';
        $message = Session::get('message');  
        $errors = Session::get('errors');
        $old = Session::get('old');
        require basePath('views/register/create.view.php');
    }

    public function store()
    {
        $postData = [
            'ime' => $_POST['name'] ?? null,
            'prezime' => $_POST['surname'] ?? null,
            'adresa' => $_POST['address'] ?? null,
            'telefon' => $_POST['phone'] ?? null,
            'email' => $_POST['email'] ?? null,
            'clanski_broj' => $_POST['member_id'] ?? null,
            'password' => $_POST['password'] ?? null,
        ];     
        $rules = [
            'ime' => ['required', 'string', 'max:50', 'min:2'],
            'prezime' => ['required', 'string','max:50', 'min:2'],
            'adresa' => ['string', 'max:100'],
            'telefon' => ['phone','max:15'],
            'email' => ['required', 'email', 'unique:clanovi', 'max:100'],
            'password' => ['required', 'password', 'min:3', 'max:255']
        ]; 
        $data = $this->validateData($rules, $postData);

        $sql = [
            'clanski_broj'
                => "SELECT clanski_broj FROM clanovi 
                    ORDER BY clanski_broj DESC 
                    LIMIT 1",
            'insert'
                => "INSERT INTO clanovi (ime, prezime, adresa, telefon, email, clanski_broj, password) VALUES (:ime, :prezime, :adresa, :telefon, :email, :clanski_broj, :password)",
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
                'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            ]);
            
        } catch (\PDOException $e) {
            abort(500);
        }
        
        $this->login($data);
        
        Session::flash('message', [
            'type' => 'success',
            'message' => "Uspješno kreiran član {$data['ime']} {$data['prezime']}."
        ]);
        redirect('/dashboard');
    }

    public function login($data)
    {
        Session::put('user', [
            'ime' => $data['ime'],
            'prezime' => $data['prezime'],
            'email' => $data['email'],
        ]);

        session_regenerate_id();
    }
}