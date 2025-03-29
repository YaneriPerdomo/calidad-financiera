<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class UserModel extends Database
{
 
    public $data = '';
  public $status = false;
  function __construct()
  {
    parent::__construct();
  }

  public function edit($id = null){
    if($id == null){
        return 'No me ha pasado ningun argumento en el parametro "ID"';
    }

    $get_user_query = 'SELECT 
                            usuarios.id_usuario, usuario, nombre, apellido, id_actividad, personas.id_persona, correo_electronico
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

    return $this->data =$get_user_stmt->fetch(PDO::FETCH_ASSOC);



  }
}
