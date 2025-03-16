<?php
namespace App\Models;

use Lib\Database;

class LoginModel extends Database{
    public $status; //objeto que se va a retornar
    public $user;
    function __construct()
    {
        parent::__construct();
    }

    public function login($data){
        if (empty($data['user']) || empty($data['password'])) {
            return $this->status = false;
        }
        $query = 'SELECT * FROM usuarios WHERE usuario = :user AND clave = :clave';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user', $data['user']);
        $stmt->bindParam(':clave', $data['password']);
        $stmt->execute();
        $this->user = $stmt->fetch();
        if($this->user){
            $this->status = true;
            return $this->user;
        } else {
            return $this->status = false;
        }
    }
}

?>