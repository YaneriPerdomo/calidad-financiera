<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class AhorroModel extends Database
{

    public $status = false;
    function __construct()
    {
        parent::__construct();
    }

    public function update($porcentaje, $id)
    {
        $update_ahorro_query = 'UPDATE presupuestos_ahorros SET porcentaje_ahorro = :porcentaje WHERE id_presupuesto_ahorro = :id';
        $update_ahorro_stmt = $this->pdo->prepare($update_ahorro_query);
        $update_ahorro_stmt->bindParam('id', $id, PDO::PARAM_INT);
        $update_ahorro_stmt->bindParam('porcentaje', $porcentaje, PDO::PARAM_INT);
        $update_ahorro_stmt->execute();
        if ($update_ahorro_stmt->rowCount() > 0) {
            return $this->status = true;
        }
    }

}
