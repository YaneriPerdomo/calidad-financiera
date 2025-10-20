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

  public $HTML = '';

  public $msg;

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
    try {

      $get_id_person_user_query = 'SELECT id_persona FROM personas WHERE id_usuario = :id_user';
      $get_id_person_user_stmt = $this->pdo->prepare($get_id_person_user_query);
      $get_id_person_user_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_user_stmt->execute();

      $row_id_person = $get_id_person_user_stmt->fetch(PDO::FETCH_ASSOC);
      $value = number_format(floatval($POST['value']), 3, '.', ',');
      $value = str_replace(',', '', $value);
      $id_person = $row_id_person['id_persona'];

      $total_insome_query = 'SELECT 
                              SUM(valor_bs) AS total_ingreso
                             FROM 
                              transacciones 
                             WHERE 
                              YEAR(fecha) = :_year 
                             AND 
                              MONTH(fecha) = :_month
                             AND id_ingreso IS NOT NULL 
                             AND id_persona = :id_person';
      $total_insome_stmt = $this->pdo->prepare($total_insome_query);
      $year = DATE('Y');
      $month = DATE('m');
      $total_insome_stmt->bindParam('_year', $year, PDO::PARAM_STR);
      $total_insome_stmt->bindParam('_month', $month, PDO::PARAM_STR);
      $total_insome_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
      $total_insome_stmt->execute();
      $value_total_insome = $total_insome_stmt->fetch(PDO::FETCH_ASSOC);

      $total_egreso_query = 'SELECT 
                              SUM(valor_bs) AS total_egreso
                             FROM 
                              transacciones 
                             WHERE 
                              YEAR(fecha) = :_year 
                             AND 
                              MONTH(fecha) = :_month
                             AND id_egreso IS NOT NULL 
                             AND id_persona = :id_person';
      $total_egreso_stmt = $this->pdo->prepare($total_egreso_query);
      $year = DATE('Y');
      $month = DATE('m');
      $total_egreso_stmt->bindParam('_year', $year, PDO::PARAM_STR);
      $total_egreso_stmt->bindParam('_month', $month, PDO::PARAM_STR);
      $total_egreso_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
      $total_egreso_stmt->execute();
      $total_egreso = $total_egreso_stmt->fetch(PDO::FETCH_ASSOC);
      $resta = $value_total_insome['total_ingreso'] - $total_egreso['total_egreso'];
      if ($POST['type_indicator'] == 1) {
        $saldo_final = $resta + $value;
      } else {
        $saldo_final = $resta - $value;
      }
      $this->msg = $resta;
      if ($saldo_final < 0) {
        $this->msg = 'Operación no válida: el saldo final no puede ser negativo.';
        return $this->status = false;
      }
      if ($POST['type_indicator'] == 2) {
        if ($value_total_insome['total_ingreso'] <= $value) {
          $this->msg = 'No tienes suficiente saldo disponible para registrar este egreso.';
          return $this->status = false;
        }
      }
      $add_transaction_query = $POST['type_indicator'] == 1 ?
        'INSERT INTO transacciones (id_persona, id_ingreso, fecha, valor_bs, notas) VALUE (:id_person, :id_insome, now(), :value_, :observations)'
        : 'INSERT INTO transacciones (id_persona, id_egreso, fecha, valor_bs, notas) VALUE (:id_person, :id_graduation, now(), :value_, :observations)';
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

      $is_there_a_budget_query = 'SELECT id_presupuesto_ahorro, monto_total, porcentaje_ahorro FROM `presupuestos_ahorros` WHERE YEAR(fecha) = YEAR(CURRENT_DATE()) AND month(fecha) = month(CURRENT_DATE()) AND id_persona = :id_person';
      $is_there_a_budget_stmt = $this->pdo->prepare($is_there_a_budget_query);
      $is_there_a_budget_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
      $is_there_a_budget_stmt->execute();

      if ($is_there_a_budget_stmt->rowCount()) {
        $row_is_there_a_budget = $is_there_a_budget_stmt->fetch(PDO::FETCH_ASSOC);
        $update_budget_query = 'UPDATE presupuestos_ahorros SET monto_total = :monto_total_actual 
      WHERE id_presupuesto_ahorro = :id_presupuesto_ahorro';
        $update_budget_stmt = $this->pdo->prepare($update_budget_query);
        $total_amount = $POST['type_indicator'] == 1 ? bcadd($row_is_there_a_budget['monto_total'], $POST['value'], 2)
          : bcsub($row_is_there_a_budget['monto_total'], $POST['value'], scale: 2);
        $update_budget_stmt->bindParam('monto_total_actual', $total_amount, PDO::PARAM_INT);
        $update_budget_stmt->bindParam('id_presupuesto_ahorro', $row_is_there_a_budget['id_presupuesto_ahorro'], PDO::PARAM_INT);
        $update_budget_stmt->execute();
      } else {
        if ($POST['type_indicator'] == 1) {
          //ingreso
          $insert_budget_query = 'INSERT presupuestos_ahorros (id_persona, monto_total, fecha) VALUES (:id_persona, :monto_total, NOW())';
          $insert_budget_stmt = $this->pdo->prepare($insert_budget_query);
          $insert_budget_stmt->bindParam('id_persona', $id_person, PDO::PARAM_INT);
          $insert_budget_stmt->bindParam('monto_total', $POST['value'], PDO::PARAM_INT);
          $insert_budget_stmt->execute();
        } else {
          $this->msg = 'No se puede registrar el egreso. Debes registrar un ingreso primero.';
          return $this->status = false;
        }
      }
      if ($add_transaction_stmt->rowCount() > 0) {
        $this->status = true;
        $this->msg = 'Transacción registrada con éxito.';
      }
    } catch (PDOException $th) {
      echo $th->getMessage();
    }
  }

  public function showTransaction($page_number = 1, $type_rol = 'user')
  {

    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario = :id_usuario';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_usuario', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $current_page = $page_number;
    $count_transaction_query = 'SELECT COUNT(*) as total_ingresos FROM transacciones';
    $count_transaction_stmt = $this->pdo->prepare($count_transaction_query);
    $count_transaction_stmt->execute();
    $row_total_transaction = $count_transaction_stmt->fetch(PDO::FETCH_ASSOC);
    $total_records = $row_total_transaction["total_ingresos"];
    $records_page = 5;
    $total_pages = ceil($total_records / $records_page);


    $get_transaction_query = 'SELECT 
                            *
                          FROM
                             transacciones
                             WHERE id_persona = :id_person
                             ORDER BY fecha desc
                              LIMIT 
                                 :inicio, :registros_por_pagina ';


    $start = ($current_page - 1) * $records_page;

    $get_transaction_stmt = $this->pdo->prepare($get_transaction_query);
    $get_transaction_stmt->bindParam(':inicio', $start, PDO::PARAM_INT);
    $get_transaction_stmt->bindParam(':registros_por_pagina', $records_page, PDO::PARAM_INT);
    $get_transaction_stmt->bindParam(':id_person', $id_person, PDO::PARAM_INT);
    $get_transaction_stmt->execute();

    $this->HTML = "";
    if ($get_transaction_stmt->rowCount() > 0) {
      $row_insome = $get_transaction_stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($row_insome as $row) {



        $type_indicator = $row['id_ingreso'] == null ? 'Egreso' : 'Ingreso';


        $this->HTML .= "<tr class='show'>";
        $this->HTML .= "<td >" . $type_indicator . "</td>";
        if ($type_indicator == 'Ingreso') {
          $get_income_query = 'SELECT ingreso FROM ingresos WHERE id_ingreso = :id_income; ';
          $get_income_stmt = $this->pdo->prepare($get_income_query);
          $this->HTML .= "<td></td>";
          $get_income_stmt->bindParam('id_income', $row['id_ingreso'], PDO::PARAM_INT);
          $get_income_stmt->execute();
          $row_income = $get_income_stmt->fetch(PDO::FETCH_ASSOC);
          $this->HTML .= "<td>" . $row_income['ingreso'] . "</td>";
        } else if ($type_indicator == 'Egreso') {
          $get_egress_query = 'SELECT egreso FROM egresos WHERE id_egreso = :id_egress; ';
          $get_egress_stmt = $this->pdo->prepare($get_egress_query);
          $get_egress_stmt->bindParam('id_egress', $row['id_egreso'], PDO::PARAM_INT);
          $get_egress_stmt->execute();
          $row_egress = $get_egress_stmt->fetch(PDO::FETCH_ASSOC);
          $get_graduation_category_query = 'SELECT categoria , egreso FROM egresos INNER JOIN 
                                            categorias_egreso ON egresos.id_categoria_egreso = categorias_egreso.id_categoria_egreso 
                                            WHERE egresos.id_egreso = :egreso ';
          $get_graduation_category_query = $this->pdo->prepare($get_graduation_category_query);
          $get_graduation_category_query->bindParam('egreso', $row['id_egreso'], PDO::PARAM_INT);
          $get_graduation_category_query->execute();
          $row_graduation_category = $get_graduation_category_query->fetch(PDO::FETCH_ASSOC);
          $this->HTML .= "<td>" . $row_graduation_category['categoria'] . "</td>";
          $this->HTML .= "<td>" . $row_egress['egreso'] . "</td>";
        } else {
          $this->HTML .= "<td> No disponible</td>";
        }
        $created_at = utilities::generacion_fecha($row['fecha']);

        $monto = $monto = number_format($row['valor_bs'], 2, ',', '.');
        $value_bs = $type_indicator == 'Ingreso' ? '+' . $monto : '-' . $monto;
        $this->HTML .= "<td>" . $value_bs . " Bs.</td>";
        $this->HTML .= "<td>" . $created_at ?? 'N/A' . "</td>";
        $this->HTML .= "<td>" . $row['notas'] . "</td>";
        $this->HTML .= "</tr>";
      }
    } else {
      $this->HTML .= "<p>No hay registros disponibles en este momento.</p>";
    }

    $this->HTML .= " </table> </section>";
    $this->HTML .= "<section class='d-flex justify-content-between align-items-center'>";
    if ($total_records == 0) {
    } else if ($total_records == 1) {
      $get_transaction_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML .= "<span class='show_quantity'>Mostrando " . $total_records . " de " . $records_page . " 
                    <span class='show_quantity__message'> " . $display_log_message . "</span></span>";
      if ($current_page > 1) {
        $this->HTML .= "<a href='/" . ($current_page - 1) . "'>Anterior</a> ";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .= "<a href='./$i'>" . ($i == $current_page ? '<b>' . $i . '</b>' : $i) . "</a> ";
      }
      if ($current_page < $total_pages) {
        $this->HTML .= "<a href='./" . ($current_page + 1) . "'>Siguiente</a>";
      }
      $this->HTML .= " </section>";
    } else {

      $get_transaction_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML .= "<span class='show_quantity'>Mostrando " . $get_transaction_stmt->rowCount() . " de " . $records_page . "
                                        <span class='show_quantity__message'> " . $display_log_message . "</span></span><nav
                                        class='navigation--egress navigation '><ul class='pagination'>";
      if ($current_page > 1) {
        $this->HTML .= "<li class='page__item '><a href='../data/" . ($current_page - 1) . "' class='page__link page__link--graduantion'>Anterior</a></li> ";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .= "<li class='page__item'>
                                            <a href='../data/" . $i . "' class='page__link page__link--graduantion'>" . ($i == $current_page ? '<b class="page__link--selected">' . $i . '</b>' : $i) . "</a>
                                        </li>";
      }
      if ($current_page < $total_pages) {
        $this->HTML .= "<li class='page__item'><a href='../data/" . ($current_page + 1) . "' class='page__link page__link--graduantion'>Siguiente</a>
                                            </li>
                                        </ul>
                                    </nav>";
      } else {
        $this->HTML .= "</ul></nav>";
      }
      $this->HTML .= " </section>";
    }
  }
}
