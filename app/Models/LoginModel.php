<?php

namespace App\Models;

use Lib\Database;
use PDO;

class LoginModel extends Database
{
    public $status; //objeto que se va a retornar
    public $user;
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
                      usuario , id_usuario, id_rol, clave
                  FROM 
                      usuarios 
                  WHERE 
                      usuario = :user ';
        $get_user_stmt = $this->pdo->prepare($get_user_query);
        $get_user_stmt->bindParam(':user', $data['user']);
        $get_user_stmt->execute();
        if ($get_user_stmt->rowCount() > 0) {
            $this->user = $get_user_stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($data['password'], $this->user['clave'])) {
                $update_last_access_query = 'UPDATE usuarios SET ultimo_acceso = NOW() WHERE usuario = :id_user';
                $update_last_access_stmt = $this->pdo->prepare($update_last_access_query);
                $update_last_access_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_STR);
                $update_last_access_stmt->execute();
                $get_person_query = 'SELECT 
                                    id_actividad, nombre, apellido, correo_electronico 
                                    FROM 
                                        personas 
                                    WHERE 
                                        id_usuario = :id_user';
                $get_persona_stmt = $this->pdo->prepare($get_person_query);
                $get_persona_stmt->bindParam('id_user',   $this->user['id_usuario'], PDO::PARAM_INT);
                $get_persona_stmt->execute();
                if ($get_persona_stmt->rowCount() > 0) {
                    $this->user = array_merge($this->user, $get_persona_stmt->fetch(PDO::FETCH_ASSOC));
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
}
