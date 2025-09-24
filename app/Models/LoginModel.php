<?php

namespace App\Models;

use Lib\Database;
use PDO;

class LoginModel extends Database
{
    public $status; //objeto que se va a retornar
    public $user = [];

    public $estado;
    function __construct()
    {
        parent::__construct();
    }

    public function login($data)
    {
        if (empty($data['user']) || empty($data['password'])) {
            return $this->status = false;
        }
        $get_user_query = 'SELECT 
                      usuario , id_usuario, id_rol, clave, estado
                  FROM 
                      usuarios_cf 
                  WHERE 
                      usuario = :user ';
        $get_user_stmt = $this->pdo->prepare($get_user_query);
        $get_user_stmt->bindParam(':user', $data['user'], PDO::PARAM_STR);
        $get_user_stmt->execute();
          $this->user = $get_user_stmt->fetch(PDO::FETCH_ASSOC);
          if ($get_user_stmt->rowCount() > 0) {
            if (password_verify($data['password'], $this->user['clave'])) {
                $update_last_access_query = 'UPDATE usuarios_cf SET ultimo_acceso = NOW() WHERE id_usuario = :id_user';
                $update_last_access_stmt = $this->pdo->prepare($update_last_access_query);
                $update_last_access_stmt->bindParam('id_user', $this->user['id_usuario'], PDO::PARAM_INT);
                $update_last_access_stmt->execute();
                if ($this->user['id_rol'] == 1) {
                    $get_person_query = 'SELECT 
                                            id_persona, id_actividad, nombre, apellido, correo_electronico 
                                            FROM 
                                                personas 
                                            WHERE 
                                                id_usuario = :id_user';
                    $get_persona_stmt = $this->pdo->prepare($get_person_query);
                    $get_persona_stmt->bindParam('id_user',   $this->user['id_usuario'], PDO::PARAM_INT);
                    $get_persona_stmt->execute();
                    $person_data = $get_persona_stmt->fetch(PDO::FETCH_ASSOC);
                    if (is_array($person_data)) {
                        $this->user = array_merge($this->user, $person_data);
                    }
                }else if($this->user['id_rol'] == 3){
                    $get_guest_query = 'SELECT 
                                    id_persona, nombre, apellido, correo_electronico 
                                    FROM 
                                        invitados 
                                    WHERE 
                                        id_usuario = :id_user';
                    $get_guest_stmt = $this->pdo->prepare($get_guest_query);
                    $get_guest_stmt->bindParam('id_user',   $this->user['id_usuario'], PDO::PARAM_INT);
                    $get_guest_stmt->execute();
                    $guest_data = $get_guest_stmt->fetch(PDO::FETCH_ASSOC);
                    if (is_array($guest_data)) {
                        $this->user = array_merge($this->user, $guest_data);
                    }
                }
                if ($this->user) {
                    $this->status = true;
                    return $this->user;
                } else {
                    return $this->status = false;
                }
            }
        }
      
    }
}
