<?php

namespace App\Models;

use Exception;
use Lib\Database;
use PDO;
use PDOException;

class dataModel extends Database
{

  public $status = false;

  public $data;

  function __construct()
  {
    parent::__construct();
  }

  public function store($POST)
  {

    $requiredFields = ['type_indicator', 'value'];
    foreach ($requiredFields as $field) {
      if (empty($POST[$field])) {
        throw new Exception("El campo $field es requerido");
      }
    }

    $get_id_person_user_query = 'SELECT id_persona FROM personas WHERE id_usuario = :id_user';
    $get_id_person_user_stmt = $this->pdo->prepare($get_id_person_user_query);
    $get_id_person_user_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
    $get_id_person_user_stmt->execute();

    $row_id_person = $get_id_person_user_stmt->fetch(PDO::FETCH_ASSOC);
    $id_person = $row_id_person['id_persona'];



    $add_transaction_query = $POST['type_indicator'] == 1 ?
      'INSERT INTO transacciones (id_persona, id_ingreso, fecha, valor_bs, notas) VALUE (:id_person, :id_insome, now(), :value_, :observations)'
      : 'INSERT INTO transacciones (id_persona, id_egreso, fecha, valor_bs, notas) VALUE  (:id_person, :id_graduation, now(), :value_, :observations)';
    $add_transaction_stmt = $this->pdo->prepare($add_transaction_query);
    $add_transaction_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    if ($POST['type_indicator'] == 1) {
      $add_transaction_stmt->bindParam(':id_insome', $POST['id_insome'], PDO::PARAM_INT);
    } else {
      $add_transaction_stmt->bindParam(':id_graduation', $POST['id_graduation'], PDO::PARAM_INT);
    }

    $add_transaction_stmt->bindParam('value_', $POST['value'], PDO::PARAM_STR);
    $add_transaction_stmt->bindParam('observations', $POST['observations'], PDO::PARAM_STR);
    $add_transaction_stmt->execute();

    $is_there_a_budget_query = 'SELECT id_presupuesto, monto_total FROM `presupuestos` WHERE YEAR(fecha) = YEAR(CURRENT_DATE()) AND month(fecha) = month(CURRENT_DATE()) AND id_persona = :id_person';
    $is_there_a_budget_stmt = $this->pdo->prepare($is_there_a_budget_query);
    $is_there_a_budget_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $is_there_a_budget_stmt->execute();

    if ($is_there_a_budget_stmt->rowCount()) {
      $row_is_there_a_budget = $is_there_a_budget_stmt->fetch(PDO::FETCH_ASSOC);
      $update_budget_query = 'UPDATE presupuestos SET monto_total = :monto_total_actual WHERE id_presupuesto  = :id_presupuesto';
      $update_budget_stmt = $this->pdo->prepare($update_budget_query);
      $total_amount = $POST['type_indicator']  == 1 ? bcadd($row_is_there_a_budget['monto_total'], $POST['value'], 2)
        :  bcsub($row_is_there_a_budget['monto_total'], $POST['value'], 2);
      $update_budget_stmt->bindParam('monto_total_actual', $total_amount, PDO::PARAM_INT);
      $update_budget_stmt->bindParam('id_presupuesto', $row_is_there_a_budget['id_presupuesto'], PDO::PARAM_INT);
      $update_budget_stmt->execute();
    } else {
      
    }


    if ($add_transaction_stmt->rowCount() > 0) {
      $this->status = true;
    }
  }
}
