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

  public $name;
  public $msg;

  public function __construct()
  {
    parent::__construct();
  }

  public function store($POST)
  {


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
                             AND anulado != 1
                             AND id_persona = :id_person';
      $total_insome_stmt = $this->pdo->prepare($total_insome_query);
      $year = date('Y');
      $month = date('m');
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
                               AND anulado != 1
                             AND id_persona = :id_person';
      $total_egreso_stmt = $this->pdo->prepare($total_egreso_query);
      $year = date('Y');
      $month = date('m');
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
        if ($value_total_insome['total_ingreso'] <= $value - 1) {
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

      $is_there_a_budget_query = 'SELECT 
                                    id_presupuesto_ahorro, monto_total, porcentaje_ahorro 
                                  FROM 
                                    `presupuestos_ahorros` 
                                  WHERE 
                                    YEAR(fecha) = YEAR(CURRENT_DATE()) 
                                  AND 
                                    month(fecha) = month(CURRENT_DATE()) 
                                  AND 
                                    id_persona = :id_person';
      $is_there_a_budget_stmt = $this->pdo->prepare($is_there_a_budget_query);
      $is_there_a_budget_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
      $is_there_a_budget_stmt->execute();

      if ($is_there_a_budget_stmt->rowCount()) {
        $row_is_there_a_budget = $is_there_a_budget_stmt->fetch(PDO::FETCH_ASSOC);
        $update_budget_query = 'UPDATE 
                                  presupuestos_ahorros 
                                SET 
                                  monto_total = :monto_total_actual 
                                WHERE 
                                  id_presupuesto_ahorro = :id_presupuesto_ahorro';
        $update_budget_stmt = $this->pdo->prepare($update_budget_query);
        $total_amount = $POST['type_indicator'] == 1 ? bcadd($row_is_there_a_budget['monto_total'], $POST['value'], 2)
          : bcsub($row_is_there_a_budget['monto_total'], $POST['value'], scale: 2);
        $update_budget_stmt->bindParam('monto_total_actual', $total_amount, PDO::PARAM_INT);
        $update_budget_stmt->bindParam('id_presupuesto_ahorro', $row_is_there_a_budget['id_presupuesto_ahorro'], PDO::PARAM_INT);
        $update_budget_stmt->execute();
      } else {
        if ($POST['type_indicator'] == 1) {
          // ingreso
          $insert_budget_query = 'INSERT 
                                    presupuestos_ahorros (id_persona, monto_total, fecha) 
                                  VALUES 
                                    (:id_persona, :monto_total, NOW())';
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
      } else {
        return $this->msg = 'Hubo un Error codigo 503';
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
    $total_records = $row_total_transaction['total_ingresos'];
    $records_page = 5;
    $total_pages = ceil($total_records / $records_page);

    $get_transaction_query = 'SELECT 
                            id_transaccion , valor_bs, notas, fecha, id_ingreso, id_egreso, 
                            anulado
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

    $this->HTML = '';
    if ($get_transaction_stmt->rowCount() > 0) {
      $row_insome = $get_transaction_stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($row_insome as $row) {

        $type_indicator = $row['id_ingreso'] == null ? 'Egreso' : 'Ingreso';
        $anuladoEstilo = $row['anulado'] == 1 ? 'class="text-line-th"' : '';
        $this->HTML .= "<tr class='show'>";
        $this->HTML .= '<td ' . $anuladoEstilo . '>' . $type_indicator . '</td>';
        if ($type_indicator == 'Ingreso') {
          $get_income_query = 'SELECT ingreso FROM ingresos WHERE id_ingreso = :id_income; ';
          $get_income_stmt = $this->pdo->prepare($get_income_query);
          $this->HTML .= '<td></td>';
          $get_income_stmt->bindParam('id_income', $row['id_ingreso'], PDO::PARAM_INT);
          $get_income_stmt->execute();
          $row_income = $get_income_stmt->fetch(PDO::FETCH_ASSOC);
          $this->HTML .= '<td ' . $anuladoEstilo . '>' . $row_income['ingreso'] . '</td>';
        } elseif ($type_indicator == 'Egreso') {
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
          $this->HTML .= '<td ' . $anuladoEstilo . '>' . $row_graduation_category['categoria'] . '</td>';
          $this->HTML .= '<td ' . $anuladoEstilo . '>' . $row_egress['egreso'] . '</td>';

        } else {
          $this->HTML .= '<td> No disponible</td>';
        }
        $created_at = utilities::generacion_fecha($row['fecha']);

        $monto = $monto = number_format($row['valor_bs'], 2, ',', '.');
        $value_bs = $type_indicator == 'Ingreso' ? '+' . $monto : '-' . $monto;
        $this->HTML .= '<td ' . $anuladoEstilo . '>' . $value_bs . ' Bs.</td>';
        $this->HTML .= '<td ' . $anuladoEstilo . '>' . $created_at ?? 'N/A' . '</td>';
        $this->HTML .= '<td ' . $anuladoEstilo . '>' . $row['notas'] . '</td>';
        if ($type_rol == 'user') {
          $this->HTML .= "<td class='operations'>";

          if ($row['anulado'] == null) {
            $this->HTML .= "
                        <button class='  button--delete' 
                          data-model='js_delete_guest' 
                          data-id-transaccion='" . $row['id_transaccion'] . "' 
                          data-type='" . $type_indicator . "'
                       >
                               <i class='bi bi-window-x'></i>
                              </button>
                       
       ";


            $this->HTML .= "</td>";
          }
        }

        $this->HTML .= '</tr>';
      }
    } else {
      $this->HTML .= '<p>No hay registros disponibles en este momento.</p>';
    }

    $this->HTML .= ' </table> </section>';
    $this->HTML .= "<section class='d-flex justify-content-between align-items-center'>";
    if ($total_records == 0) {
    } elseif ($total_records == 1) {
      $get_transaction_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML .= "<span class='show_quantity'>Mostrando " . $total_records . ' de ' . $records_page . " 
                    <span class='show_quantity__message'> " . $display_log_message . '</span></span>';
      if ($current_page > 1) {
        $this->HTML .= "<a href='/" . ($current_page - 1) . "'>Anterior</a> ";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .= "<a href='./$i'  class='page__link page__link--graduantion'>" . ($i == $current_page ? '<b class="page__link--selected"> ' . $i . '</b>' : $i) . '</a> ';
      }
      if ($current_page < $total_pages) {
        $this->HTML .= "<a href='./" . ($current_page + 1) . "'>Siguiente</a>";
      }
      $this->HTML .= ' </section>';
    } else {

      $get_transaction_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML .= "<span class='show_quantity'>Mostrando " . $get_transaction_stmt->rowCount() . ' de ' . $records_page . "
                                        <span class='show_quantity__message'> " . $display_log_message . "</span></span><nav
                                        class='navigation--egress navigation '><ul class='pagination'>";
      if ($current_page > 1) {
        $this->HTML .= "<li class='page__item '><a href='../data/" . ($current_page - 1) . "' class='page__link page__link--graduantion'>Anterior</a></li> ";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .= "<li class='page__item'>
                                            <a href='../data/" . $i . "' class='page__link page__link--graduantion'>" . ($i == $current_page ? '<b class="page__link--selected">' . $i . '</b>' : $i) . '</a>
                                        </li>';
      }
      if ($current_page < $total_pages) {
        $this->HTML .= "<li class='page__item'><a href='../data/" . ($current_page + 1) . "' class='page__link page__link--graduantion'>Siguiente</a>
                                            </li>
                                        </ul>
                                    </nav>";
      } else {
        $this->HTML .= '</ul></nav>';
      }
      $this->HTML .= ' </section>';
    }
  }

  public function reportData($POST = [])
  {
    // Hoy -> SELECT * FROM `transacciones` WHERE date(fecha) = CURDATE();

    try {

      if (isset($POST['id_rol']) && $POST['id_rol'] == 3) {
        $name_query = 'SELECT nombre, apellido FROM personas WHERE id_persona = :id_person';
        $name_stmt = $this->pdo->prepare($name_query);
        $name_stmt->execute([':id_person' => $_SESSION['id_persona']]);
        $row_name = $name_stmt->fetch(PDO::FETCH_ASSOC);
        if ($row_name) {
          $this->name = $row_name['nombre'] . '_' . $row_name['apellido'];
        }
      }

      switch ($POST['periodo_seleccion']) {
        case '1': // hoy
          $get_report_query = ' SELECT    id_transaccion , valor_bs, notas, fecha, id_ingreso, id_egreso, 
                            anulado FROM `transacciones` WHERE date(fecha) = CURDATE() AND id_persona = :id_person';
          $get_report_stmt = $this->pdo->prepare($get_report_query);

          $get_report_stmt->bindParam('id_person', $_SESSION['id_persona'], PDO::PARAM_INT);
          $get_report_stmt->execute();
          $value = '';
          break;
        case '0': // Rango de Fechas
          $get_report_query = ' SELECT    id_transaccion , valor_bs, notas, fecha, id_ingreso, id_egreso, 
                            anulado FROM `transacciones` WHERE date(fecha) BETWEEN :fecha_inicio AND :fecha_final 
        AND id_persona = :id_person';
          $get_report_stmt = $this->pdo->prepare($get_report_query);
          $get_report_stmt->bindParam('id_person', $_SESSION['id_persona'], PDO::PARAM_INT);
          $get_report_stmt->bindParam('fecha_inicio', $POST['fecha_inicio']);
          $get_report_stmt->bindParam('fecha_final', $POST['fecha_fin']);
          $get_report_stmt->execute();
          $value = '';
          break;
        case '2': // Rango de Fechas
          $get_report_query = ' SELECT    id_transaccion , valor_bs, notas, fecha, id_ingreso, id_egreso, 
                            anulado FROM `transacciones` WHERE  id_persona = :id_person';
          $get_report_stmt = $this->pdo->prepare($get_report_query);
          $get_report_stmt->bindParam('id_person', $_SESSION['id_persona'], PDO::PARAM_INT);
          $get_report_stmt->execute();
          $value = '';
          break;
        default:

          break;
      }
      if ($get_report_stmt->rowCount() > 0) {
        $get_report = $get_report_stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$POST['withIndicator']) {
          return $this->data = $get_report;
        }
        foreach ($get_report as $row) {
          //With indicator
          if ($POST['withIndicator']) {
            $type_indicator = $row['id_ingreso'] == null ? 'Egreso' : 'Ingreso';
            $anuladoEstilo = $row['anulado'] == 1 ? 'class="text-line-th"' : '';
          }

          $value .= "<tr class='show'>";
          if ($POST['withIndicator']) {
            $value .= '<td ' . $anuladoEstilo . '>' . $type_indicator . '</td>';
            if ($type_indicator == 'Ingreso') {
              $get_income_query = 'SELECT ingreso FROM ingresos WHERE id_ingreso = :id_income;';
              $get_income_stmt = $this->pdo->prepare($get_income_query);
              $value .= '<td></td>';
              $get_income_stmt->bindParam('id_income', $row['id_ingreso'], PDO::PARAM_INT);
              $get_income_stmt->execute();
              $row_income = $get_income_stmt->fetch(PDO::FETCH_ASSOC);
              $value .= '<td ' . $anuladoEstilo . '>' . $row_income['ingreso'] . '</td>';
            } elseif ($type_indicator == 'Egreso') {
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
              $value .= '<td ' . $anuladoEstilo . '>' . $row_graduation_category['categoria'] . '</td>';
              $value .= '<td ' . $anuladoEstilo . '>' . $row_egress['egreso'] . '</td>';
            } else {
              $value .= '<td> No disponible</td>';
            }
          }

          $created_at = utilities::generacion_fecha($row['fecha']);
          $monto = $monto = number_format($row['valor_bs'], 2, ',', '.');
          if ($POST['withIndicator']) {
            $value_bs = $type_indicator == 'Ingreso' ? '+' . $monto : '-' . $monto;
          }
          $value .= '<td ' . $anuladoEstilo . '>' . $value_bs . ' Bs.</td>';
          $value .= '<td ' . $anuladoEstilo . '>' . $created_at ?? 'N/A' . '</td>';
          $value .= '<td ' . $anuladoEstilo . '>' . $row['notas'] . '</td>';
          $value .= '</tr>';
        }
        $value .= ' </table> </section>';
        $value .= "<section class='d-flex justify-content-between align-items-center'>";

        $this->data = $value;

      } else {
        $this->data = '';
      }
      return $this->status = true;
    } catch (PDOException $ex) {
      $this->data = $ex->getMessage();
    }
  }

  public function getInsomeOrEgresoExcel($row = [], $type_indicator)
  {
    $value = '';


    if ($type_indicator == 'Ingreso') {
      /**
       $get_income_query = 'SELECT ingreso FROM ingresos WHERE id_ingreso = :id_income;';
      $get_income_stmt = $this->pdo->prepare($get_income_query);
      $get_income_stmt->bindParam('id_income', $row['id_ingreso'], PDO::PARAM_INT);
      $get_income_stmt->execute();
      $row_income = $get_income_stmt->fetch(PDO::FETCH_ASSOC);
       */
      $value = 'Ingreso';
    } elseif ($type_indicator == 'Egreso') {
      /**
       $get_egress_query = 'SELECT egreso FROM egresos WHERE id_egreso = :id_egress; ';
      $get_egress_stmt = $this->pdo->prepare($get_egress_query);
      $get_egress_stmt->bindParam('id_egress', $row['id_egreso'], PDO::PARAM_INT);
      $get_egress_stmt->execute();
      $row_egress = $get_egress_stmt->fetch(PDO::FETCH_ASSOC);
       */
      $value = 'Egreso';
    } else if ($type_indicator == 'categoriaEgreso') {
      $get_graduation_category_query = 'SELECT categoria , egreso FROM egresos INNER JOIN 
                                            categorias_egreso ON egresos.id_categoria_egreso = categorias_egreso.id_categoria_egreso 
                                            WHERE egresos.id_egreso = :egreso ';
      $get_graduation_category_query = $this->pdo->prepare($get_graduation_category_query);
      $get_graduation_category_query->bindParam('egreso', $row['id_egreso'], PDO::PARAM_INT);
      $get_graduation_category_query->execute();
      $row_graduation_category = $get_graduation_category_query->fetch(PDO::FETCH_ASSOC);
      $value = $row_graduation_category['categoria'];
    } else {
      $value = 'No disponible';
    }

    return $value;
  }

  public function Annulment($POST = [])
  {
    try {

      $buscarMontoConsultar = 'SELECT 
                                  id_transaccion , fecha , id_persona, 
                                  id_egreso, id_ingreso, valor_bs
                                FROM 
                                  transacciones 
                                WHERE 
                                  id_transaccion = :id';
      $buscarMontoStmt = $this->pdo->prepare($buscarMontoConsultar);
      $buscarMontoStmt->bindParam('id', $POST['id'], PDO::PARAM_INT);
      $buscarMontoStmt->execute();
      $rowMonto = $buscarMontoStmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $rowMonto['id_persona'];
      if($POST['observations'] == ''){
          $actualizarMontoConsultar = 'UPDATE 
                                      transacciones 
                                    SET 
                                      anulado = 1 
                                    WHERE 
                                      id_transaccion = :id';
      $actualizarMontoStmt = $this->pdo->prepare($actualizarMontoConsultar);
      $actualizarMontoStmt->bindParam('id', $POST['id'], PDO::PARAM_INT);
      $actualizarMontoStmt->execute();
      }else{
          $actualizarMontoConsultar = 'UPDATE 
                                      transacciones 
                                    SET 
                                      anulado = 1 , notas = :observations
                                    WHERE 
                                      id_transaccion = :id';
      $actualizarMontoStmt = $this->pdo->prepare($actualizarMontoConsultar);
      $actualizarMontoStmt->bindParam('id', $POST['id'], PDO::PARAM_INT);
      $actualizarMontoStmt->bindParam('observations', $POST['observations'], PDO::PARAM_STR);
      $actualizarMontoStmt->execute();
      }
    


      if ($actualizarMontoStmt->rowCount() > 0) {
        $transaction_date = $rowMonto['fecha'];
        $is_there_a_budget_query = 'SELECT 
                                      id_presupuesto_ahorro, monto_total, porcentaje_ahorro 
                                    FROM 
                                      `presupuestos_ahorros` 
                                    WHERE 
                                      YEAR(fecha) = YEAR(:year_) 
                                    AND 
                                      month(fecha) = month(:_month) 
                                    AND 
                                      id_persona = :id_person';
        $is_there_a_budget_stmt = $this->pdo->prepare($is_there_a_budget_query);
        $is_there_a_budget_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
        $is_there_a_budget_stmt->bindParam('year_', $transaction_date, PDO::PARAM_STR);
        $is_there_a_budget_stmt->bindParam('_month', $transaction_date, PDO::PARAM_STR);
        $is_there_a_budget_stmt->execute();
         
        if ($is_there_a_budget_stmt->rowCount() > 0) {
          $row_is_there_a_budget = $is_there_a_budget_stmt->fetch(PDO::FETCH_ASSOC);
           
          if($row_is_there_a_budget['monto_total'] == 0.000){
            return $this->status = true; 
          }
          $update_budget_query = 'UPDATE 
                                  presupuestos_ahorros 
                                SET 
                                  monto_total = :monto_total_actual 
                                WHERE 
                                  id_presupuesto_ahorro = :id_presupuesto_ahorro';
          $update_budget_stmt = $this->pdo->prepare($update_budget_query);
          $total_amount = $rowMonto['id_ingreso'] != NUll
            ? bcsub($row_is_there_a_budget['monto_total'], $rowMonto['valor_bs'], 2)
            : bcadd($row_is_there_a_budget['monto_total'], $rowMonto['valor_bs'], 2);
          $update_budget_stmt->bindParam('monto_total_actual', $total_amount, PDO::PARAM_INT);
          $update_budget_stmt->bindParam('id_presupuesto_ahorro', $row_is_there_a_budget['id_presupuesto_ahorro'], PDO::PARAM_INT);
          $update_budget_stmt->execute();

          if ($update_budget_stmt->rowCount() > 0) {
            $this->status = true;
            $this->msg = 'Transacción registrada con éxito.';
          }
        } else {
          if ($rowMonto['id_ingreso'] != NUll) {
            // ingreso
            $insert_budget_query = 'INSERT 
                                    presupuestos_ahorros (id_persona, monto_total, fecha) 
                                  VALUES 
                                    (:id_persona, :monto_total, NOW())';
            $insert_budget_stmt = $this->pdo->prepare($insert_budget_query);
            $insert_budget_stmt->bindParam('id_persona', $id_person, PDO::PARAM_INT);
            $insert_budget_stmt->bindParam('monto_total', $rowMonto['valor_bs'], PDO::PARAM_INT);
            $insert_budget_stmt->execute();
            if ($insert_budget_stmt->rowCount() > 0) {
              $this->status = true;
              $this->msg = 'Transacción registrada con éxito.';
            }
          } else {
            $this->msg = 'No se puede registrar el egreso. Debes registrar un ingreso primero.';
            return $this->status = false;
          }
        }
      }



    } catch (PDOException $th) {
      echo $th->getMessage();
    }
  }
}
