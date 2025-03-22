<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class CreateAccountModel extends Database
{

  public $status = false;
  function __construct()
  {
    parent::__construct();
  }

  public function create($data)
  {
    //validacion de datos vacios
    if (empty($data['user']) || empty($data['email']) || empty($data['id_actividad']) || empty($data['password'])
    || empty($data['name'] || empty($data['lastname']))
    ) {
      return $this->status = false;
    }
   
    try {
      $this->pdo->beginTransaction();
      $insert_user_query = 'INSERT INTO usuarios (id_rol,  usuario,  clave) 
      VALUES (1,:usuario,:clave)';
      $hash = password_hash($data['password'], PASSWORD_DEFAULT);
      $insert_user_stmt = $this->pdo->prepare($insert_user_query);
      $insert_user_stmt->bindParam(':usuario', $data['user']);
      $insert_user_stmt->bindParam(':clave', $hash);
      $insert_user_stmt->execute();
      $id_user  = $this->pdo->lastInsertId();
      $insert_person_query = 'INSERT INTO 
                    personas (nombre , apellido, id_actividad, id_usuario, correo_electronico)  
                VALUES 
                    (:nombre, :apellido, :id_actividad, :id_usuario, :correo_electronico)';
      $insert_persona_stmt = $this->pdo->prepare($insert_person_query);
      $insert_persona_stmt->bindParam('nombre', $data['name'], PDO::PARAM_STR);
      $insert_persona_stmt->bindParam('apellido', $data['lastname'], PDO::PARAM_STR);
      $insert_persona_stmt->bindParam('id_actividad', $data['id_actividad'], PDO::PARAM_INT);
      $insert_persona_stmt->bindParam('id_usuario', $id_user, PDO::PARAM_INT);
      $insert_persona_stmt->bindParam('correo_electronico', $data['email'], PDO::PARAM_STR);
      $insert_persona_stmt->execute();
      
        $this->pdo->commit();
        return $this->status = true;
      
    } catch (PDOException $ex) {
      $this->pdo->rollBack();
     
    }
  }
}
