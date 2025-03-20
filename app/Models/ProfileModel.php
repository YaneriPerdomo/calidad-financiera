<?php

namespace App\Models;

use InvalidArgumentException;
use Lib\Database;
use PDO;
use PDOException;
use RuntimeException;

class ProfileModel extends Database{

    public $data = [];
    public $status = false;
    public function __construct()
    {
        parent::__construct();
    }

    public function showData($id_user = null){
        if($id_user == null || !is_numeric($id_user)){
            throw new InvalidArgumentException("El ID de usuario no es válido."); //Indicar que un argumento pasado a una función o método no es válido.
        }
        $get_data_query = 'SELECT 
                                usuario , correo_electronico, id_actividad, nombre, apellido
                            FROM 
                                usuarios 
                            INNER JOIN 
                                personas 
                            ON 
                                usuarios.id_usuario = personas.id_usuario 
                            WHERE 
                                usuarios.id_usuario = :id_user';
        try {
            $get_data_stmt = $this->pdo->prepare($get_data_query);
            $get_data_stmt->bindParam('id_user', $id_user, PDO::PARAM_INT);
            $get_data_stmt->execute();
            return $this->data = $get_data_stmt->fetch(PDO::FETCH_ASSOC) ?? [];
        } catch (PDOException $ex) {
            throw new RuntimeException("Error al obtener los datos del usuario: " . $ex->getMessage()); //Error que sucede aunque se cuenta en el flujo de ejercucion
        }
    }

    public function updateData($POST = []){
      
        $update_user_query = 'UPDATE 
                                usuarios 
                            SET 
                                usuario = :usuario
                            WHERE 
                                id_usuario = :id_usuario';
        try {
            $update_user_stmt = $this->pdo->prepare($update_user_query);
            $update_user_stmt->bindParam('usuario', $POST['usuario'], PDO::PARAM_STR);
            $update_user_stmt->bindParam('id_usuario', $POST['id_usuario'], PDO::PARAM_INT);
            $update_person_query = 'UPDATE personas SET nombre =:nombre, apellido =:apellido, correo_electronico =:correo_electronico, id_actividad =:id_actividad WHERE id_usuario =:id_usuario';
            $update_person_stmt = $this->pdo->prepare($update_person_query);
            $update_person_stmt->bindParam('nombre', $POST['nombre'], PDO::PARAM_STR);
            $update_person_stmt->bindParam('apellido', $POST['apellido'], PDO::PARAM_STR);
            $update_person_stmt->bindParam('correo_electronico', $POST['correo_electronico'], PDO::PARAM_STR);
            $update_person_stmt->bindParam('id_actividad', $POST['id_actividad'], PDO::PARAM_INT);
            $update_person_stmt->bindParam('id_usuario', $POST['id_usuario'], PDO::PARAM_INT);
            
            if($update_user_stmt->execute() && $update_person_stmt->execute()){
                return $this->status = true;
            }
        } catch (PDOException $ex) {
            throw new RuntimeException("Error al actualizar los datos del usuario: " . $ex->getMessage());
        }
    }

    public function updatePassword($POST=[]){
        $get_password_query = 'SELECT 
                                    clave 
                                FROM 
                                    usuarios 
                                WHERE 
                                    id_usuario = :id_usuario';
        try {
            $get_password_stmt = $this->pdo->prepare($get_password_query);
            $get_password_stmt->bindParam('id_usuario', $_SESSION['id_usuario'], PDO::PARAM_INT);
            $get_password_stmt->execute();
            $password = $get_password_stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($POST['old-password'], $password['clave'])){
                if($POST['new-password'] === $POST['confirm-password']){
                    $update_password_query = 'UPDATE 
                                                usuarios 
                                            SET 
                                                clave = :clave 
                                            WHERE 
                                                id_usuario = :id_usuario';
                    $update_password_stmt = $this->pdo->prepare($update_password_query);
                    $hash = password_hash($POST['new-password'], PASSWORD_DEFAULT);
                    $update_password_stmt->bindParam('clave', $hash, PDO::PARAM_STR);
                    $update_password_stmt->bindParam('id_usuario', $_SESSION['id_usuario'], PDO::PARAM_INT);
                    if($update_password_stmt->execute()){
                        return $this->status = true;
                    }
                }
            }

          
        } catch (PDOException $ex) {
            throw new RuntimeException("Error al actualizar la contraseña del usuario: " . $ex->getMessage());
        }
    }
}
