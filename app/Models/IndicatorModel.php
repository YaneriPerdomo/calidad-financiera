<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class indicatorModel extends Database
{


  public $status = false;

  public $data;

  public $HTML_graduantion;

  public $HTML_insome;
  public $data_insome;
  function __construct()
  {
    parent::__construct();
  }


  public function show($page_e, $page_i)
  {
    //ingresos

    $current_page_i =  $page_i;
    $count_insome_query = 'SELECT COUNT(*) as total_ingresos FROM ingresos';
    $count_insome_stmt = $this->pdo->prepare($count_insome_query);
    $count_insome_stmt->execute();
    $row_total_insome = $count_insome_stmt->fetch(PDO::FETCH_ASSOC);
    $total_records_i = $row_total_insome["total_ingresos"];
    $records_page_i = 5;
    $total_pages_i = ceil($total_records_i / $records_page_i);
    // Verificamos si se encontraron resultados

    $get_insome_query = 'SELECT 
                            ingreso, id_ingreso
                         FROM
                            ingresos
                             LIMIT 
                                :inicio, :registros_por_pagina';
    $start_i = ($current_page_i - 1) * $records_page_i;

    $get_insome_stmt = $this->pdo->prepare($get_insome_query);
    $get_insome_stmt->bindParam(':inicio', $start_i, PDO::PARAM_INT);
    $get_insome_stmt->bindParam(':registros_por_pagina', $records_page_i, PDO::PARAM_INT);
    $get_insome_stmt->execute();

    $this->HTML_insome = "";
    if ($get_insome_stmt->rowCount() > 0) {
      $row_insome = $get_insome_stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($row_insome as $row) {

        $this->HTML_insome .= "<tr class='show'>";
        $this->HTML_insome .= "<td >" . $row['ingreso'] . "</td>";
        $this->HTML_insome .=  "<td class='operations'>";
        $this->HTML_insome .= "<button class='  button--delete'>
                           <i class='bi bi-trash js-open-modal-delete' ></i>  
                        </button>";
        $this->HTML_insome .= "<a href='../../indicator/" . $row['id_ingreso'] . "-ingreso/modify'>
                            <button class='button--modify'>
                              <i class='bi bi-person-lines-fill'></i>
                            </button>
                        </a>";
        $this->HTML_insome .=  "</td>";
        $this->HTML_insome .=  "</tr>";
      }
    } else {
      $this->HTML_insome .=  "<p>No hay registros disponibles en este momento.</p>";
    }

    $this->HTML_insome .=  " </table> </section>";
    $this->HTML_insome .=  "<section class='d-flex justify-content-between align-items-center'>";
    if ($total_records_i == 0) {
    } else if ($total_records_i == 1) {
      $get_insome_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML_insome .=  "<span class='show_quantity'>Mostrando " . $total_records_i . " de " . $records_page_i . " 
                   <span class='show_quantity__message'> " . $display_log_message . "</span></span>";
      if ($current_page_i > 1) {
        $this->HTML_insome .=  "<a href='?page=" . ($current_page_i - 1) . "'>Anterior</a> ";
      }
      for ($i = 1; $i <= $total_pages_i; $i++) {
        $this->HTML_insome .=  "<a href='?page=$i'>" . ($i == $current_page_i ? '<b>' . $i . '</b>' : $i) . "</a> ";
      }
      if ($current_page_i < $total_pages_i) {
        $this->HTML_insome .=  "<a href='?page=" . ($current_page_i + 1) . "'>Siguiente</a>";
      }
      $this->HTML_insome .=  " </section>";
    } else {

      $get_insome_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML_insome .= "<span class='show_quantity'>Mostrando " . $get_insome_stmt->rowCount() . " de " . $records_page_i . "
                                          <span class='show_quantity__message'> " . $display_log_message . "</span></span><nav
                                          class='navigation--egress navigation '><ul class='pagination'>";

      if ($current_page_i > 1) {
        $this->HTML_insome .= "<li class='page__item'><a href='./" . ($current_page_i - 1) . "' class='page__link'>Anterior</a></li>";
      }

      for ($i = 1; $i <= $total_pages_i; $i++) {
        $this->HTML_insome .= "<li class='page__item'>
                                              <a href='./" . $i . "' class='page__link'>" . ($i == $current_page_i ? '<b class="page__link--selected">' . $i . '</b>' : $i) . "</a>
                                          </li>";
      }

      if ($current_page_i < $total_pages_i) {
        $this->HTML_insome .= "<li class='page__item'>
                                              <a href='./" . ($current_page_i + 1) . "' class='page__link'>Siguiente</a>
                                          </li>
                                      </ul>
                                  </nav>";
      } else {
        $this->HTML_insome .= "</ul></nav>";
      }

      $this->HTML_insome .= "</section>";
    }

    //egresos
    $current_page_e =  $page_e;
    $count_graduation_query = 'SELECT COUNT(*) as total_egresos FROM egresos';
    $count_graduation_stmt = $this->pdo->prepare($count_graduation_query);
    $count_graduation_stmt->execute();
    $row_total_graduation = $count_graduation_stmt->fetch(PDO::FETCH_ASSOC);
    $total_records_e = $row_total_graduation["total_egresos"];
    $records_page_e = 5;
    $total_pages_e = ceil($total_records_e / $records_page_e);
    // Verificamos si se encontraron resultados

    $get_graduation_query = 'SELECT 
                                categoria, egreso , egresos.id_egreso
                             FROM 
                                egresos 
                             INNER JOIN 
                                categorias_egreso 
                             ON 
                                egresos.id_categoria_egreso = categorias_egreso.id_categoria_egreso
                             LIMIT 
                                :inicio, :registros_por_pagina';
    $start_e = ($current_page_e - 1) * $records_page_e;

    $get_graduation_stmt = $this->pdo->prepare($get_graduation_query);
    $get_graduation_stmt->bindParam(':inicio', $start_e, PDO::PARAM_INT);
    $get_graduation_stmt->bindParam(':registros_por_pagina', $records_page_e, PDO::PARAM_INT);
    $get_graduation_stmt->execute();

    $this->HTML_graduantion = "";
    if ($get_graduation_stmt->rowCount() > 0) {
      $row_graduation = $get_graduation_stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($row_graduation as $row) {

        $this->HTML_graduantion .= "<tr class='show'>";
        $this->HTML_graduantion .= "<td >" . $row['egreso'] . "</td>";
        $this->HTML_graduantion .=  "<td>" . $row['categoria'] . "</td>";
        $this->HTML_graduantion .=  "<td class='operations'>";
        $this->HTML_graduantion .= "<button class='  button--delete'>
                           <i class='bi bi-trash js-open-modal-delete' ></i>  
                        </button>";
        $this->HTML_graduantion .= "<a href='../../indicator/" . $row['id_egreso'] . "-egreso/modify'>
                            <button class='button--modify'>
                              <i class='bi bi-person-lines-fill'></i>
                            </button>
                        </a>";
        $this->HTML_graduantion .=  "</td>";
        $this->HTML_graduantion .=  "</tr>";
      }
    } else {
      $this->HTML_graduantion .=  "<p>No hay registros disponibles en este momento.</p>";
    }

    $this->HTML_graduantion .=  " </table> </section>";
    $this->HTML_graduantion .=  "<section class='d-flex justify-content-between align-items-center'>";
    if ($total_records_e == 0) {
    } else if ($total_records_e == 1) {
      $get_graduation_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML_graduantion .= "<span class='show_quantity'>Mostrando " . $total_records_e . " de " . $records_page_e . "
                                    <span class='show_quantity__message'> " . $display_log_message . "</span></span>";
      if ($current_page_e > 1) {
        $this->HTML_graduantion .= "<a href='?page=" . ($current_page_e - 1) . "'>Anterior</a> ";
      }
      for ($i = 1; $i <= $total_pages_e; $i++) {
        $this->HTML_graduantion .= "<a href='?page=$i'>" . ($i == $current_page_e ? '<b>' . $i . '</b>' : $i) . "</a> ";
      }
      if ($current_page_e < $total_pages_e) {
        $this->HTML_graduantion .= "<a href='?page=" . ($current_page_e + 1) . "'>Siguiente</a>";
      }
      $this->HTML_graduantion .= " </section>";
    } else {

      $get_graduation_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML_graduantion .= "<span class='show_quantity'>Mostrando " . $get_graduation_stmt->rowCount() . " de " . $records_page_e . "
                                        <span class='show_quantity__message'> " . $display_log_message . "</span></span><nav
                                        class='navigation--egress navigation '><ul class='pagination'>";
      if ($current_page_e > 1) {
        $this->HTML_graduantion .= "<li class='page__item '><a href='../" . ($current_page_e - 1) . "' class='page__link page__link--graduantion'>Anterior</a></li> ";
      }
      for ($i = 1; $i <= $total_pages_e; $i++) {
        $this->HTML_graduantion .= "<li class='page__item'>
                                            <a href='../" . $i . "' class='page__link page__link--graduantion'>" . ($i == $current_page_e ? '<b class="page__link--selected">' . $i . '</b>' : $i) . "</a>
                                        </li>";
      }
      if ($current_page_e < $total_pages_e) {
        $this->HTML_graduantion .= "<li class='page__item'><a href='../" . ($current_page_e + 1) . "' class='page__link page__link--graduantion'>Siguiente</a>
                                            </li>
                                        </ul>
                                    </nav>";
      } else {
        $this->HTML_graduantion .= "</ul></nav>";
      }
      $this->HTML_graduantion .= " </section>";
    }

    unset($get_graduation_stmt);
  }

  public function ShowIndicator($id, $type)
  {
    switch ($type) {
      case 'ingreso':
        $this->data = $this->FindOneDate('ingresos', $id, 'id_ingreso', ['ingreso']);
        break;
      case 'egreso':
        $this->data = $this->FindOneDate('egresos', $id, 'id_egreso', ['id_categoria_egreso', 'egreso']);
        break;
      default:
        echo 'No se encontro el tipo de indicador';
        break;
    }
  }

  public function FindOneDate($table, $id, $id_field,  array $fields = ['*'])
  {
    $fieldsString = implode(',', $fields);
    $find_query = "SELECT {$fieldsString} FROM {$table} WHERE {$id_field} = :id";
    $find_stmt = $this->pdo->prepare($find_query);
    $find_stmt->bindParam('id', $id, PDO::PARAM_INT);
    $find_stmt->execute();
    $result = $find_stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  public function ShowGraduationCategories()
  {

    try {
      $get_graduation_categories_query = 'SELECT * FROM `categorias_egreso` ORDER BY IF(id_categoria_egreso = 4, 1, 0), id_categoria_egreso; ';
      $get_graduation_categories_stmt = $this->pdo->prepare($get_graduation_categories_query);
      $get_graduation_categories_stmt->execute();
      $this->data = $get_graduation_categories_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      echo  $ex->getMessage();
    }
  }

  public function UpdateIndicator($POST = [])
  {


    if (is_array($POST)) {
      switch ($POST['type-indicator']) {
        case '1':
          $update_income_query = 'UPDATE ingresos SET ingreso = :ingreso WHERE id_ingreso = :id_ingreso';
          $update_income_stmt = $this->pdo->prepare($update_income_query);
          $update_income_stmt->bindParam('ingreso', $POST['income'], PDO::PARAM_STR);
          $update_income_stmt->bindParam('id_ingreso', $POST['id'], PDO::PARAM_INT);
          $update_income_stmt->execute();

          if ($update_income_stmt->rowCount() > 0) {
            return $this->status = true;
          }
          break;
        case '2':
          $update_graduation_query = 'UPDATE egresos SET egreso = :egreso WHERE id_egreso = :id_egreso';
          $update_graduation_stmt = $this->pdo->prepare($update_graduation_query);
          $update_graduation_stmt->bindParam('egreso', $POST['graduation'], PDO::PARAM_STR);
          $update_graduation_stmt->bindParam('id_egreso', $POST['id'], PDO::PARAM_INT);
          $update_graduation_stmt->execute();
          if ($update_graduation_stmt->rowCount() > 0) {
            return $this->status = true;
          }
          break;
      }
    }
  }

  public function AddIndicator($POST = [])
  {
    if (!isset($POST['type-indicator']) || !isset($POST['id_graduation-categorys'])  || !isset($POST['graduation'])) {
      return false;
    }
    if (is_array($POST)) {
      $add_indicator = match ($POST['type-indicator']) {
        '1'  => $this->AddIncome($POST['income']),
        '2' => $this->AddGraduation($POST['id_graduation-categorys'], $POST['graduation']),
        default => false,
      };
      return $this->status = $add_indicator;
    }
  }

  protected function AddIncome($income)
  {
    $add_income_query = 'INSERT INTO ingresos (ingreso) VALUES (:ingreso)';
    $add_income_stmt = $this->pdo->prepare($add_income_query);
    $add_income_stmt->bindParam('ingreso', $income, PDO::PARAM_STR);
    $add_income_stmt->execute();
    return $add_income_stmt->rowCount() > 0 ? true : false;
  }

  protected function AddGraduation($id, $graduation)
  {
    $add_graduation_query = 'INSERT INTO egresos (id_categoria_egreso, egreso) VALUES (:id_categoria_egreso, :egreso)';
    $add_graduation_stmt = $this->pdo->prepare($add_graduation_query);
    $add_graduation_stmt->bindParam('id_categoria_egreso', $id, PDO::PARAM_INT);
    $add_graduation_stmt->bindParam('egreso', $graduation, PDO::PARAM_STR);
    $add_graduation_stmt->execute();
    return $add_graduation_stmt->rowCount() > 0 ? true : false;
  }
 
}
