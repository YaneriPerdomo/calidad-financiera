<?php

namespace App\Models;

use Exception;
use InvalidArgumentException;
use Lib\Database;
use PDO;
use PDOException;
use RuntimeException;

class UserModel extends Database
{

  public $data = '';
  public $status = false;

  public $msg = '';
  public $todas_actividades;
  function __construct()
  {
    parent::__construct();
  }

  public function edit($id = null)
  {
    if ($id == null || !is_numeric($id)) {
      throw new InvalidArgumentException("El ID de usuario no es válido.");
    }
    try {
      $get_user_query = 'SELECT 
                            usuarios.id_usuario, usuario, nombre, apellido, id_actividad, usuarios.estado, personas.id_persona, correo_electronico
                        FROM 
                            personas
                        INNER JOIN
                            usuarios
                        ON  
                            personas.id_usuario = usuarios.id_usuario
                        WHERE 
                            usuarios.id_usuario = :id_usuario';
      $get_user_stmt = $this->pdo->prepare($get_user_query);
      $get_user_stmt->bindParam('id_usuario', $id, PDO::PARAM_INT);
      $get_user_stmt->execute();

      $get_actividades_query = 'SELECT * FROM actividades';
      $actividad_stmt = $this->pdo->prepare($get_actividades_query);
      $actividad_stmt->execute();
      $this->todas_actividades = $actividad_stmt->fetchAll(PDO::FETCH_ASSOC);
      return $this->data = $get_user_stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      throw new RuntimeException("Error al obtener los datos del usuario: " . $ex->getMessage()); //Error que sucede aunque se cuenta en el flujo de ejercucion
    }
  }

  public function update($POST = [])
  {
    $search_name_user_not_you_query = 'SELECT * FROM `usuarios` WHERE (usuario = :user and id_usuario != :id_user)';
    $search_name_user_not_you_stmt = $this->pdo->prepare($search_name_user_not_you_query);
    $search_name_user_not_you_stmt->bindParam('user', $POST['usuario'], PDO::PARAM_STR);
    $search_name_user_not_you_stmt->bindParam('id_user', $POST['id_usuario'], PDO::PARAM_INT);
    $search_name_user_not_you_stmt->execute();
    if ($search_name_user_not_you_stmt->rowCount() > 0) {
      return $this->msg = "Nombre de usuario ya existente";
    }

    $search_email_query = 'SELECT * FROM `personas` WHERE (correo_electronico = :correo_electronico and id_usuario != :id_user)';
    $search_email_stmt = $this->pdo->prepare($search_email_query);
    $search_email_stmt->bindParam('correo_electronico', $POST['correo_electronico'], PDO::PARAM_STR);
    $search_email_stmt->bindParam('id_user', $POST['id_usuario'], PDO::PARAM_INT);
    $search_email_stmt->execute();
    if ($search_email_stmt->rowCount() > 0) {
      return $this->msg = "Correo electronico ya existente";
    }
    try {
      $this->pdo->beginTransaction(); // Inicia la transacción

      // Validación de datos
      if (!isset($POST['usuario'], $POST['id_usuario'], $POST['nombre'], $POST['apellido'], $POST['correo_electronico'], $POST['id_actividad'])) {
        throw new Exception("Datos de entrada incompletos.");
      }


      // Actualizar tabla usuarios
      $update_user_query = 'UPDATE usuarios SET usuario = :usuario , estado = :estado WHERE id_usuario = :id_usuario';
      $update_user_stmt = $this->pdo->prepare($update_user_query);
      $update_user_stmt->bindParam('estado', $POST['status'], PDO::PARAM_INT);
      $update_user_stmt->bindParam('usuario', $POST['usuario'], PDO::PARAM_STR);
      $update_user_stmt->bindParam('id_usuario', $POST['id_usuario'], PDO::PARAM_INT);
      $update_user_stmt->execute();

      // Actualizar tabla personas
      $update_person_query = 'UPDATE personas SET nombre =:nombre, apellido =:apellido, correo_electronico =:correo_electronico, id_actividad =:id_actividad WHERE  id_usuario =:id_usuario';
      $update_person_stmt = $this->pdo->prepare($update_person_query);
      $update_person_stmt->bindParam('nombre', $POST['nombre'], PDO::PARAM_STR);
      $update_person_stmt->bindParam('apellido', $POST['apellido'], PDO::PARAM_STR);
      $update_person_stmt->bindParam('correo_electronico', $POST['correo_electronico'], PDO::PARAM_STR);
      $update_person_stmt->bindParam('id_actividad', $POST['id_actividad'], PDO::PARAM_INT);
      $update_person_stmt->bindParam('id_usuario', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $update_person_stmt->execute();
      $update_password_result = false;
      if (!isset($POST['old-password'])) {
        $update_password_result = $this->updatePassword([
          'new-password' => $POST['new-password'],
          'confirm-password' => $POST['confirm-password']
        ]);
      } else {
        $update_password_result = $this->updateOldPassword([
          'new-password' => $POST['new-password'],
          'confirm-password' => $POST['confirm-password'],
          'old-password' => $POST['old-password']
        ]);
      }

      if ($update_person_stmt->rowCount() > 0 || $update_user_stmt->rowCount() > 0 || $update_password_result == true) {
        $this->pdo->commit();
        return $this->status = true;
      }
    } catch (PDOException $ex) {
      $this->pdo->rollBack();
      throw new RuntimeException("Error de PDO: " . $ex->getMessage());
    } catch (Exception $exception) {
      $this->pdo->rollBack();
      error_log("Error general: " . $exception->getMessage());
    }
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
            return true;
          }
        }
      }
    } catch (PDOException $ex) {
      throw new RuntimeException("Error al actualizar la contraseña del usuario: " . $ex->getMessage());
    }
  }

  public function deleteAccount()
  {
    $id_user = $_SESSION['id_usuario'];
    $update_user_query = 'UPDATE usuarios SET estado = 0 WHERE id_usuario = :id_usuario';
    $update_user_stmt = $this->pdo->prepare($update_user_query);
    $update_user_stmt->bindParam('id_usuario', $id_user, PDO::PARAM_INT);
    $update_user_stmt->execute();
    if ($update_user_stmt->execute()) {
      return $this->status = true;
    }
  }

  public function destroy($id_person, $id_user)
  {
    $delete_data_presupuestos_ahorros_query = 'DELETE FROM   
                                                      presupuestos_ahorros 
                                                WHERE 
                                                      id_persona = :id_persona';
    $delete_data_presupuestos_ahorros_stmt = $this->pdo->prepare($delete_data_presupuestos_ahorros_query);
    $delete_data_presupuestos_ahorros_stmt->bindParam('id_persona', $id_person, PDO::PARAM_INT);
    $delete_data_presupuestos_ahorros_stmt->execute();

    $delete_data_transacciones_query = 'DELETE FROM transacciones WHERE id_persona = :id_person';
    $delete_data_transacciones_stmt = $this->pdo->prepare($delete_data_transacciones_query);
    $delete_data_transacciones_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $delete_data_transacciones_stmt->execute();

    $delete_data_invitados_query = 'DELETE FROM invitados WHERE id_persona = :id_person';
    $delete_data_invitados_stmt = $this->pdo->prepare($delete_data_invitados_query);
    $delete_data_invitados_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $delete_data_invitados_stmt->execute();
    
    $delete_data_person_query = 'DELETE FROM personas WHERE id_persona = :id_person';
    $delete_data_person_stmt = $this->pdo->prepare($delete_data_person_query);
    $delete_data_person_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $delete_data_person_stmt->execute();

    $delete_data_user_query = 'DELETE FROM usuarios WHERE id_usuario = :id_user';
    $delete_data_user_stmt = $this->pdo->prepare($delete_data_user_query);
    $delete_data_user_stmt->bindParam('id_user', $id_user, PDO::PARAM_INT);
    $delete_data_user_stmt->execute();

    if ($delete_data_person_stmt->rowCount() > 0 && $delete_data_user_stmt->rowCount() > 0) {
      return $this->status = true;
    } else {
      $this->msg = 'Hubo un error al intentar eliminar el usuario';
      return $this->status = false;
    }
  }

}
