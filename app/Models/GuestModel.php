<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class GuestModel extends Database
{

  public $status = false;

  public $data;
  function __construct()
  {
    parent::__construct();
  }

  public function AddData($POST = [])
  {

    try {
      $this->pdo->beginTransaction();
      $hash =  password_hash($POST['password'], PASSWORD_DEFAULT);
      $add_data_user_query = 'INSERT INTO usuarios (id_rol, usuario, clave) VALUES (3 ,:usuario, :clave)';
      $add_data_user_stmt = $this->pdo->prepare($add_data_user_query);
      $add_data_user_stmt->bindParam('usuario', $POST['user'], PDO::PARAM_STR);
      $add_data_user_stmt->bindParam('clave', $hash, PDO::PARAM_STR);
      $add_data_user_stmt->execute();

      $id_user = $this->pdo->lastInsertId();

      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario = :id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_persona = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);

      $add_data_guest_query = 'INSERT INTO invitados (id_usuario, id_persona, nombre, apellido, correo_electronico) 
                                 VALUES 
                                 (:id_usuario, :id_persona, :nombre, :apellido, :correo_electronico)';
      $add_data_guest_stmt = $this->pdo->prepare($add_data_guest_query);
      $add_data_guest_stmt->bindParam('id_usuario', $id_user, PDO::PARAM_INT);
      $add_data_guest_stmt->bindParam('id_persona', $row_id_persona['id_persona'], PDO::PARAM_INT);
      $add_data_guest_stmt->bindParam('nombre', $POST['name'], PDO::PARAM_STR);
      $add_data_guest_stmt->bindParam('apellido', $POST['lastname'], PDO::PARAM_STR);
      $add_data_guest_stmt->bindParam('correo_electronico', $POST['email'], PDO::PARAM_STR);
      $add_data_guest_stmt->execute();

      $this->pdo->commit();

      $this->status = true;
    } catch (PDOException $ex) {
      $this->pdo->rollBack();
      echo  $ex->getMessage();
    }
  }


  function UpdateData($POST = [])
  {
    try {
      $update_data_guest_query = 'UPDATE invitados SET nombre = :nombre, apellido = :apellido, correo_electronico = :correo_electronico WHERE id_usuario = :id_usuario';
      $update_data_guest_stmt = $this->pdo->prepare($update_data_guest_query);
      $update_data_guest_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
      $update_data_guest_stmt->bindParam('nombre', $POST['name'], PDO::PARAM_STR);
      $update_data_guest_stmt->bindParam('apellido', $POST['lastname'], PDO::PARAM_STR);
      $update_data_guest_stmt->bindParam('correo_electronico', $POST['email'], PDO::PARAM_STR);

      $update_data_guest_stmt->execute();
      $row_data_guest = $update_data_guest_stmt->fetch(PDO::FETCH_ASSOC);

      $update_data_user_query = 'UPDATE usuarios SET usuario = :usuario WHERE id_usuario = :id_usuario';
      $update_data_user_stmt = $this->pdo->prepare($update_data_user_query);
      $update_data_user_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
      $update_data_user_stmt->bindParam('usuario', $POST['user'], PDO::PARAM_STR);
      $update_data_user_stmt->execute();
      $row_data_user = $update_data_user_stmt->fetch(PDO::FETCH_ASSOC);

      if ($POST['password'] != '') {
        $update_password_query = 'UPDATE usuarios SET clave =:clave WHERE id_usuario = :id_usuario';
        $update_password_stmt = $this->pdo->prepare($update_password_query);
        $hash = password_hash($POST['password'], PASSWORD_DEFAULT);
        $update_password_stmt->bindParam('clave', $hash, PDO::PARAM_STR);
        $update_password_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
        $update_password_stmt->execute();
      }


      return $this->data =  1;
    } catch (PDOException $exh) {
      echo $exh->getMessage();
    }
  }
  public function showData($id_user)
  {
    $get_data_guest_query = 'SELECT id_usuario , id_persona, nombre, apellido, correo_electronico FROM invitados WHERE id_usuario = :id_usuario';
    $get_data_guest_stmt = $this->pdo->prepare($get_data_guest_query);
    $get_data_guest_stmt->bindParam('id_usuario', $id_user, PDO::PARAM_INT);
    $get_data_guest_stmt->execute();
    $row_data_guest = $get_data_guest_stmt->fetch(PDO::FETCH_ASSOC);

    $get_data_user_query = 'SELECT usuario FROM usuarios WHERE id_usuario = :id_user';
    $get_data_user_stmt = $this->pdo->prepare($get_data_user_query);
    $get_data_user_stmt->bindParam('id_user', $id_user, PDO::PARAM_INT);
    $get_data_user_stmt->execute();
    $row_data_user = $get_data_user_stmt->fetch(PDO::FETCH_ASSOC);

    return $this->data =  $row_data_guest + $row_data_user;
  }
}
