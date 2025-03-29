<?php

namespace Lib;
use PDO;
use PDOException;
use Exception;
class Database{
    protected $pdo;
    private $host = 'localhost';
    private $dbNombre = 'calidad_financiera';
    private $usuario = 'root';
    private $clave = '';
    public $stmt;
    public function __construct(){
            try {
                $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbNombre", $this->usuario, $this->clave);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                //echo "Conexión exitosa a la base de datos.";
                $this->pdo;
            } catch (PDOException $e) {
                throw new Exception("Error de conexión: " . $e->getMessage());
            }
        
    }

   
    public function prepare($query, $bindParam = []){ 
        $this->stmt = $this->pdo->prepare($query);
        foreach ($bindParam as $key => $value) {
            $this->stmt->bindParam($key, $value);
        }
        $this->stmt;
    }
 
    public function PreparePasswordUpdate($old_password, $new_password){
        
    }
   
    
    public function __destruct()
    {
      $this->pdo = null;
    }

}

?>