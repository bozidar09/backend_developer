<?php

namespace Core;
use PDO;

class Database {

    private ?PDO $dbh;
    
    
    public function __construct() 
    {
        $config = require_once basePath('config/db_config.php'); 
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        
        try {
            $this->dbh = new PDO($dsn, $config['user'], $config['password'], $config['options']);

        } catch (\PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }
    
    public function executeQuery(string $sql, array $params = []): object | bool
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            $success = $stmt->execute($params);

            if (str_starts_with($sql, 'SELECT')) {
                return $stmt;
            } else {
                return $success;
            }   
        } catch (\PDOException $e) {
            die('Query error: ' . $e->getMessage());
        }
    }
    
    public function fetchArray(string $sql, array $params = []): array
    {
        $stmt = $this->executeQuery($sql, $params);
        $data = $stmt->fetchAll(); 
        return $data;
    }

    public function fetchRow(string $sql, array $params = []): array
    {
        $stmt = $this->executeQuery($sql, $params);
        $data = $stmt->fetch(); 
        return $data;
    }

    public function closeConnection(): null
    {
        $this->dbh = null;
        return null;
    }

}