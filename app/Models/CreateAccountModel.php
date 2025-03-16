<?php

namespace App\Models;

use Lib\Database;

class CreateAccountModel extends Database
{

  public $status;
  function __construct()
  {
    parent::__construct();
  }

  public function create($data){
    //validacion de datos vacios
    if (empty($data['user']) || empty($data['email']) || empty($data['actividad']) || empty($data['password'])) {
      return false;
    }
    $query = 'INSERT INTO usuarios (id_rol, id_actividad, usuario, correo_electronico, clave) 
                  VALUES (1, :id_actividad, :usuario, :correo_electronico, :clave)';
    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':usuario', $data['user']);
    $stmt->bindParam(':correo_electronico', $data['email']);
    $stmt->bindParam(':clave', $data['password']);
    $stmt->bindParam(':id_actividad', $data['actividad']);
    $stmt->execute();

    if($stmt->rowCount() > 0){
      return $this->status = true;
    } else {
      return $this->status = false;
    }
  }
}
