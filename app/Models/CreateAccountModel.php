<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class CreateAccountModel extends Database
{

  public $status = false;

  public $msg = '';
  function __construct()
  {
    parent::__construct();
  }

  public function create($data)
  {
    if (
      empty($data['user']) ||
      empty($data['email']) ||
      empty($data['id_actividad']) ||
      empty($data['password']) ||
      empty($data['name'] ||
      empty($data['lastname']))
    ) {
      return $this->msg = 'Por favor, rellene todos los campos';
    }

    $search_name_user_not_you_query = 'SELECT * FROM `usuarios` WHERE (usuario = :user )';
    $search_name_user_not_you_stmt = $this->pdo->prepare($search_name_user_not_you_query);
    $search_name_user_not_you_stmt->bindParam('user', $data['user'], PDO::PARAM_STR);
    $search_name_user_not_you_stmt->execute();
    if ($search_name_user_not_you_stmt->rowCount() > 0) {
      $this->msg = "Nombre de usuario ya existente";
      return $this->status = false;
    }

    $search_email_query = 'SELECT * FROM `personas` WHERE (correo_electronico = :correo_electronico )';
    $search_email_stmt = $this->pdo->prepare($search_email_query);
    $search_email_stmt->bindParam('correo_electronico', $data['email'], PDO::PARAM_STR);
    $search_email_stmt->execute();
    if ($search_email_stmt->rowCount() > 0) {
      $this->msg = "Correo electronico ya existente";
      return $this->status = false;
    }
    
    try {
      $this->pdo->beginTransaction();
      $insert_user_query = 'INSERT INTO usuarios (id_rol,  usuario,  clave, fecha_creacion) 
      VALUES (1,:usuario,:clave, NOW())';
      $hash = password_hash($data['password'], PASSWORD_DEFAULT);
      //$dateToday = Date('Y-m-d');
      $insert_user_stmt = $this->pdo->prepare($insert_user_query);
      $insert_user_stmt->bindParam('usuario', $data['user']);
      $insert_user_stmt->bindParam('clave', $hash);
      $insert_user_stmt->execute();
      $id_user = $this->pdo->lastInsertId();
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
