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

  public $data = '';
  public $status = false;
  function __construct()
  {
    parent::__construct();
  }

  protected function updatePassword($POST = [])
  {
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
    
    $get_password_query = 'SELECT 
                                    clave 
                                FROM 
                                    usuarios 
                                WHERE 
                                    id_usuario = :id_usuario';
    try {
      $get_password_stmt = $this->pdo->prepare($get_password_query);
      $get_password_stmt->bindParam('id_usuario', $POST['id_usuario'], PDO::PARAM_INT);
      $get_password_stmt->execute();
      $password = $get_password_stmt->fetch(PDO::FETCH_ASSOC);
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
      throw new RuntimeException("Error al actualizar la contraseña del usuario: " . $ex->getMessage());
    }
  }
}
