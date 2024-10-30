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
        $config = [ 
            'db_host' => env('DB_HOST', "database"),
            'db_port' => env('DB_PORT', 3306),
            'db_database' => env('DB_DATABASE', "videoteka"),
            'db_charset' => env('DB_CHARSET', "utf8mb4"),
            'db_username' => env('DB_USERNAME', "algebra"),
            'db_password' => env('DB_PASSWORD', "algebra"),
            'db_options' => env('DB_OPTIONS'),
        ];

        if ($config['db_options']) {
            if (str_contains($config['db_options'] , ',')) {
                $elements = explode(',', $config['db_options']);
            } else {
                $elements[] = $config['db_options'];
            }
            
            $config['db_options'] = [];
            foreach ($elements as $element) {
                $element = explode('=>', $element);
                $config['db_options'][$element[0]] = $element[1];
            }
        }

        $dsn = "mysql:host={$config['db_host']};port={$config['db_port']};dbname={$config['db_database']};charset={$config['db_charset']}";
        
        try {
            $this->pdo = new PDO($dsn, $config['db_username'], $config['db_password'], $config['db_options']);

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