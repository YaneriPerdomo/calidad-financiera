<?php

namespace App\Models;

use Exception;
use InvalidArgumentException;
use Lib\Database;
use PDO;
use PDOException;
use RuntimeException;

class ChangesPasswordModel extends Database
{

  public $data = [];

  public $passwordDB;

  public $msg;
  public $status = false;
  function __construct()
  {
    parent::__construct();
  }

  protected function updatePassword($POST = [])
  {
    if ($_POST['old-password'] == $_POST['new-password']) {
      return '<script>alert("La clave nueva que ingresaste no debe ser la misma que tenia anteriormente"); location.href = "./changes-password"</script>';
    }

    $id_user = $POST['id_usuario'];
    $search_password_query = 'SELECT 
                                clave
                              FROM  
                                usuarios
                              WHERE 
                                id_usuario = :id_user';
    $search_password_stmt = $this->pdo->prepare($search_password_query);
    $search_password_stmt->bindParam('id_user', $id_user, PDO::PARAM_STR);
    $search_password_stmt->execute();
    $search_password_stmt->fetch(PDO::FETCH_ASSOC);
    $password = $search_password_stmt;
    return $id_user;
    if ($POST['new-password'] === $POST['confirm-password']) {
      $update_password_query = 'UPDATE 
                usuarios 
            SET 
                clave = :clave 
            WHERE 
                id_usuario = :id_usuario';
      $update_password_stmt = $this->pdo->prepare($update_password_query);
      $hash = password_hash($POST['new-password'], PASSWORD_DEFAULT);
      $update_password_stmt->bindParam('clave', $hash, PDO::PARAM_STR);
      $update_password_stmt->bindParam('id_usuario', $POST['id_usuario'], PDO::PARAM_INT);

      if ($update_password_stmt->execute()) {
        return true;
      }
    }
  }
  public function updateOldPassword($POST = [])
  {
    if ($POST['old-password'] == "" && $POST['new-password'] == "" && $POST['confirm-password'] == "") {
      return $this->msg = 'Por favor, rellene todos los campos.';

    }
    if ($_POST['old-password'] == $_POST['new-password']) {
      return $this->msg = 'La clave nueva que ingresaste no debe ser la misma que tenia anteriormente';
    }
    $id_user = $_SESSION['id_usuario'];

    $get_password_query = 'SELECT 
                                    clave 
                                FROM 
                                    usuarios 
                                WHERE 
                                    id_usuario = :id_usuario';
    try {
      $get_password_stmt = $this->pdo->prepare($get_password_query);
      $get_password_stmt->bindParam('id_usuario', $id_user, PDO::PARAM_INT);
      $get_password_stmt->execute();
      $password = $get_password_stmt->fetch(PDO::FETCH_ASSOC);
      /*if (password_verify($POST['new-password'], $password['clave'])) {
        $this->msg = 'No podemos actualizar la contraseña debido a que usted esta usando la misma contraseña actual, por favor ingrese una nueva contraseña';
        return $this->status = false;
      }*/
      if (password_verify($POST['old-password'], $password['clave'])) {
        if ($POST['new-password'] === $POST['confirm-password']) {
          $update_password_query = 'UPDATE 
                                                usuarios 
                                            SET 
                                                clave = :clave 
                                            WHERE 
                                                id_usuario = :id_usuario';
          $update_password_stmt = $this->pdo->prepare($update_password_query);
          $hash = password_hash($POST['new-password'], PASSWORD_DEFAULT);
          $update_password_stmt->bindParam('clave', $hash, PDO::PARAM_STR);
          $update_password_stmt->bindParam('id_usuario', $POST['id_usuario'], PDO::PARAM_INT);
          if ($update_password_stmt->execute()) {
            return $this->status = true;
          }
        }
      }
    } catch (PDOException $ex) {
      $this->msg = 'Sucedio un error';
      throw new RuntimeException("Error al actualizar la contraseña del usuario: " . $ex->getMessage());
    }
  }
}
