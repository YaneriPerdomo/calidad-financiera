<?php

namespace App\Models;

use InvalidArgumentException;
use Lib\Database;
use PDO;
use PDOException;
use RuntimeException;

class ProfileGuestModel extends Database{

    public $data ;
    public $status = false;
    public function __construct()
    {
        parent::__construct();
    }

    public function ShowData($id){
        $get_information_guest_query = 'SELECT nombre, apellido, correo_electronico FROM invitados
        WHERE id_usuario = :id_user';
        $get_information_guest_stmt = $this->pdo->prepare($get_information_guest_query);
        $get_information_guest_stmt->bindParam('id_user', $id, PDO::PARAM_INT);
        $get_information_guest_stmt->execute();
        return $this->data = $get_information_guest_stmt->fetch(PDO::FETCH_ASSOC);
        if($get_information_guest_stmt->rowCount() > 1){
        }

    }
}
