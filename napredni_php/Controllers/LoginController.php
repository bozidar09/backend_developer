<?php

namespace Controllers;

use Core\Database;
use Core\Validator;
use Core\Session;

class LoginController 
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
        $pageTitle = 'Login';
        $message = Session::get('message');  
        $errors = Session::get('errors');
        $old = Session::get('old');
        require_once basePath('views/login/create.view.php');
    }

    public function store()
    {
        $postData = [
            'email' => $_POST['email'] ?? null,
            'password' => $_POST['password'] ?? null,
        ];   
        $rules = [
            'email' => ['required', 'email'],
            'password' => ['required', 'password', 'min:3', 'max:255']
        ];
        $data = $this->validateData($rules, $postData);
        
        $user = $this->db->query("SELECT * FROM clanovi WHERE email = ?", [$data['email']])->find();

        if (!empty($user) && password_verify($data['password'], $user['password'])) {
            $this->login($user);
            
            Session::flash('message', [
                'type' => 'success',
                'message' => "Uspješno ste se logirali."
            ]);
            redirect('/dashboard');
        }

        Session::flash('message', [
            'type' => 'danger',
            'message' => "Vaši podaci za prijavu nisu točni."
        ]);
        redirect('/login');
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

    public function logout()
    {
        Session::destroy();
        redirect('/');
    }
}