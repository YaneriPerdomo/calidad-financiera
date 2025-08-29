<?php

namespace App\Models;

use Exception;
use InvalidArgumentException;
use Lib\Database;
use PDO;
use PDOException;
use RuntimeException;

class ActividadModel extends Database
{

    public $data = '';
    public $status = false;
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $get_actividad_query = 'SELECT * FROM actividades';
        $actividad_stmt = $this->pdo->prepare($get_actividad_query);
        $actividad_stmt->execute();

        if ($actividad_stmt->rowCount() > 0) {
            $this->status = true;
            foreach ($actividad_stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
                $this->data .= "<option value='" . $value['id_actividad'] . "'  > " . $value['actividad'] . "</option>";
            }

        }
    }
}
