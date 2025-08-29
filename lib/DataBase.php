<?php

namespace Lib;
use PDO;
use PDOException;
use Exception;
class Database
{
    protected $pdo;
    private $host = 'localhost';
    private $dbName = 'calidad_financiera';
    private $user = 'root';
    private $password = '';
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->pdo;
        } catch (PDOException $ex) {
            throw new Exception("Error de conexión: " . $ex->getMessage());
        }
    }
 
    public function __destruct()
    {
        $this->pdo = null;
    }
 
}

?>