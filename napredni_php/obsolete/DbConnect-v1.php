<?php

class DbConnect {

    protected string $host;
    protected string $dbname;
    protected string $user;
    protected string $password;
    protected string $charset;
    protected ?PDO $dbh;
    
    
    public function __construct($host, $dbname, $user, $password, $charset) 
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
        $this->charset = $charset;

        try {
            $this->dbh = new PDO("mysql:host=$this->host;dbname=$this->dbname;user=$this->user;password=$this->password;charset=$this->charset");
            // drugi način:
            // $this->dbh = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset", $this->user, $this->password);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }
    
    public function getDataArray($sql): array
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
            
        } catch (PDOException $e) {
            die('Query error: ' . $e->getMessage());
        }
    }
    
    public function closeConnection()
    {
        $this->dbh = null;
        return null;
    }

}