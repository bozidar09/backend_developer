<?php

namespace Core;

class Validator {

    private Database $db;
    private array $errors = [];
    private array $data = [];

    public function __construct(
        private array $rules,
        private array $form
    )
    {
        $this->db = Database::get();
        $this->validate();
    }

    public function notValid()
    {
        return !empty($this->errors);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function addError(string $key, string $error)
    {
        $this->errors[$key] = $error;
    }

    private function validate()
    {
        foreach ($this->rules as $field => $rules) {
            $userInput = null;
            if (isset($this->form[$field]) && $this->form[$field] !== '') {
                $userInput = htmlspecialchars(trim($this->form[$field])); // htmlspecialchars() -> sprječava XSS napad - cross site scripting
            }

            $this->data[$field] = $userInput;

            if (!in_array('required', $rules) && is_null($userInput)) {
                continue;
            }
            
            foreach ($rules as $rule) {
                $additional = null;
                $matchingField = null;
                $movieField = null;

                if (str_contains($rule, ':')) {
                    $pieces = explode(':', $rule);
                    $rule = $pieces[0];
                    $additional = $pieces[1];

                    if (str_contains($additional, ',')) {
                        $temp = explode(',', $additional);
                        $additional = $temp[0];
                        $matchingField = $temp[1]; 
                        
                        if(isset($temp[2])) 
                            $movieField = $temp[2];
                    }
                }

                call_user_func([$this, $rule], $userInput, $field, $additional, $matchingField, $movieField);
            }
        }
    }
    
    private function exists($userInput, $field, $table, $matchingField)
    {
        $sql = "SELECT COUNT(id) AS count FROM $table WHERE $matchingField = :val";
        $result = $this->db->query($sql, [
            'val' => $userInput
        ])->find();

        if ($result['count'] === 0)
            $this->addError($field, "Podatak za $field {$userInput} ne postoji u našoj bazi.");
    }

    private function unique($userInput, $field, $table, $id)
    {
        $sql = "SELECT COUNT(id) AS count FROM $table WHERE $field = :val";
        $params =  ['val' => $userInput];

        if ($id !== null) {
            $sql .= " AND id != :id";
            $params['id'] = $id;
        }

        $result = $this->db->query($sql, $params)->find();

        if ($result['count'] > 0)
            $this->addError($field, "Podatak za $field {$userInput} već postoji u našoj bazi.");
    }

    private function required($userInput, $field)
    {
        if(empty($userInput)){
            $this->addError($field, "Polje $field je obavezno!");
        }
    }

    private function string($userInput, $field)
    {
        if(!is_string($userInput) || !preg_match('/^[\pL0-9\s_-]+$/u', $userInput)){
            $this->addError($field, "Polje $field mora sadržavati samo slova i brojeve!");
        }
    }

    private function numeric($userInput, $field, $low, $high)
    {
        if(!is_numeric($userInput)) {
            $this->addError($field, "Polje $field mora biti brojčana vrijednost!");
        }
        if (isset($low) && isset($high) && ($low > $userInput || $userInput > $high)) {
            $this->addError($field, "Vrijednost polja $field mora biti između $low i $high!");
        }
    }

    private function email($userInput, $field)
    {
        if(!filter_var($userInput, FILTER_VALIDATE_EMAIL)){
            $this->addError($field, "Polje $field mora biti valjana e-mail adresa!");
        }
    }

    private function phone($userInput, $field)
    {
        if(!preg_match('/^(\+\d{3}\s?)(\d{2}\s?)(\d{6,7})$/', $userInput)){
            $this->addError($field, "Polje $field mora biti u formatu +xxx xx xxxxxx!");
        } else {
            $this->data[$field] = str_replace(' ', '', $userInput);
        }
    }

    private function date($userInput, $field, $current, $other)
    {
        if(!preg_match('/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/', $userInput)){
            $this->addError($field, "Polje $field mora biti valjani datum!");
        }
        if(isset($current) && $userInput > $current){
            $this->addError($field, "Polje $field ne smije biti budući datum!");
        }
        if(isset($other) && $userInput < $other){
            $this->addError($field, "Polje $field ne smije biti datum raniji od $other!");
        }
    }

    private function max($userInput, $field, $length)
    {
        if(strlen($userInput) > $length){
            $this->addError($field, "Polje $field ne smije biti duže od $length znakova.");
        }
    }

    private function min($userInput, $field, $length)
    {
        if(strlen($userInput) < $length){
            $this->addError($field, "Polje $field ne smije biti kraće od $length znakova.");
        }
    }

    private function clanskiBroj($userInput, $field)
    {
        if(!preg_match('/^(CLAN\d{5})$/', $userInput)){
            $this->addError($field, "Polje $field mora biti u formatu CLANxxxxx");
        }
    }

    private function uniqueMovie($userInput, $field, $table, $year, $id)
    {
        $sql = "SELECT COUNT(id) AS count FROM $table WHERE $field = :val";
        $params =  ['val' => $userInput];
        
        if ($year !== null) {
            $sql .= " AND godina = :godina";
            $params['godina'] = $year;

            if ($id !== null) {
                $sql .= " AND id != :id";
                $params['id'] = $id;
            }
        }

        $result = $this->db->query($sql, $params)->find();

        if ($result['count'] > 0)
            $this->addError($field, "Podatak za $field {$userInput} već postoji u našoj bazi.");
    }

    private function password($userInput, $field)
    {
        if(!preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/', $userInput)){
            $this->addError($field, "Polje $field mora sadržavati bar po jedan poseban znak, broj, te veliko i malo slovo");
        }
    }
}