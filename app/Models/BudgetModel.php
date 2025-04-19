<?php

namespace App\Models;

use Exception;
use InvalidArgumentException;
use Lib\Database;
use PDO;
use PDOException;
use RuntimeException;

class BudgetModel extends Database
{

    public $data = '';
    public $status = false;
    function __construct()
    {
        parent::__construct();
    }

    //Presupuesto de cada mes del año actual
    public function budgetEachMonth($type_rol)
    {
        if ($type_rol == 'user') {
            $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
            $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
            $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
            $get_id_person_stmt->execute();
            $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
            $id_person = $row_id_person['id_persona'];
        } else {
            $id_person = $_SESSION['id_persona'];
        }

        $budget_query = 'SELECT YEAR(fecha) AS año, MONTH(fecha) AS mes, monto_total FROM presupuestos WHERE YEAR(fecha) = YEAR(CURRENT_DATE()) AND id_persona = :id_person GROUP BY YEAR(fecha), MONTH(fecha) ORDER BY año, mes; ';
        try {
            $budget_stmt = $this->pdo->prepare($budget_query);
            $budget_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
            $budget_stmt->execute();
            if ($budget_stmt->rowCount() > 0) {
                $this->data = $budget_stmt->fetchAll(PDO::FETCH_ASSOC);
                return $this->data;
            }
        } catch (PDOException $e) {
            throw new RuntimeException('Error al obtener los datos de presupuesto: ' . $e->getMessage());
        }
    }
}
