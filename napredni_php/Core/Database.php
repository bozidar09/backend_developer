<?php

namespace Core;
use PDO;
use PDOException;
use PDOStatement;

class Database 
{
    private ?PDO $pdo;
    private PDOStatement $statement;
    private static ?Database $instance = null;
    
    public function __construct() 
    {
        $config = require_once basePath('config/db_config.php'); 
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        
        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['password'], $config['options']);

        } catch (\PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }
    
    //Singleton design pattern
    public static function get(): Database
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query(string $sql, array $params = []): object | bool
    {
        try {
            $this->statement = $this->pdo->prepare($sql);
            $this->statement->execute($params);
            return $this; 

        } catch (\Exception $e) {
            if ($e instanceof PDOException) {
                throw $e;
            }
            abort(500);
        }
    }
    
    public function find(): array
    {
        return $this->statement->fetch();
    }

    public function all(): array
    {
        return $this->statement->fetchAll(); 
    }

    public function findOrFail(): array
    {
        $data = $this->find();
        
        if (empty($data)) {
            abort();
        }
        return $data;
    }

    public function connection(): PDO
    {
        return $this->pdo;
    }

    public function closeConnection(): null
    {
        $this->pdo = null;
        return null;
    }
}