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
        $config = envLoad();

        if ($config['DB_OPTIONS']) {
            if (str_contains($config['DB_OPTIONS'] , ',')) {
                $elements = explode(',', $config['DB_OPTIONS']);
            } else {
                $elements[] = $config['DB_OPTIONS'];
            }
            
            $config['DB_OPTIONS'] = [];
            foreach ($elements as $element) {
                $element = explode('=>', $element);
                $config['DB_OPTIONS'][$element[0]] = $element[1];
            }
        }

        $dsn = "mysql:host={$config['DB_HOST']};port={$config['DB_PORT']};dbname={$config['DB_DATABASE']};charset={$config['DB_CHARSET']}";
        
        try {
            $this->pdo = new PDO($dsn, $config['DB_USERNAME'], $config['DB_PASSWORD'], $config['DB_OPTIONS']);

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