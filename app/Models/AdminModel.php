<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class AdminModel extends Database
{
 
    public  $HTML = '';

  public $status = false;
  function __construct()
  {
    parent::__construct();
  }

  public function ShowUsers($page = 1){
      
    $current_page =  $page;
    $count_users_query = 'SELECT COUNT(*) as total_usuarios FROM usuarios WHERE id_rol = 1';
    $count_users_stmt = $this->pdo->prepare($count_users_query);
    $count_users_stmt->execute();
    $row_total_users = $count_users_stmt->fetch(PDO::FETCH_ASSOC);
    $total_records = $row_total_users["total_usuarios"];
    $records_page = 5;
    $total_pages = ceil($total_records / $records_page);

    $get_users_query = 'SELECT * FROM 
                            personas 
                        INNER JOIN 
                            usuarios 
                        ON 
                            personas.id_usuario = usuarios.id_usuario
                        INNER JOIN 
                            actividades
                        ON
                            personas.id_actividad = actividades.id_actividad
                        LIMIT 
                            :inicio, :registros_por_pagina';
    $start = ($current_page - 1) * $records_page;

    $get_users_stmt = $this->pdo->prepare($get_users_query);
    $get_users_stmt->bindParam(':inicio', $start, PDO::PARAM_INT);
    $get_users_stmt->bindParam(':registros_por_pagina', $records_page, PDO::PARAM_INT);
    $get_users_stmt->execute();

    $this->HTML = "";
    if ($get_users_stmt->rowCount() > 0) {
      $row_users = $get_users_stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($row_users as $row) {

        $this->HTML .= "<tr class='show'>";
        $this->HTML .= "<td >" . $row['usuario'] . "</td>";
        $this->HTML .=  "<td>" . $row['nombre'] . "</td>";
        $this->HTML .=  "<td>" . $row['apellido'] . "</td>";
        $this->HTML .=  "<td>" . $row['correo_electronico'] . "</td>";
        $this->HTML .=  "<td>" . $row['actividad'] . "</td>";
        $this->HTML .=  "<td class='operations'>";
        $this->HTML .= "<button class='  button--delete'>
                           <i class='bi bi-trash js-open-modal-delete'   data-id_user='" . $row['id_usuario'] . "'></i>  
                        </button>";
        $this->HTML .= "<a href='../../user/" . $row['id_usuario'] . "/modify'>
                            <button class='button--modify'>
                              <i class='bi bi-person-lines-fill'></i>
                            </button>
                        </a>
                        <a href='../../user/" . $row['id_usuario'] . "/progress'>
                            <button class='button--progress'>
                              <i class='bi bi-bar-chart-line'></i>
                            </button>
                        </a>";
        $this->HTML .=  "</td>";
        $this->HTML .=  "</tr>";
      }
    } else {
       $this->HTML .=  "<p>No hay registros disponibles en este momento.</p>";
    }

     $this->HTML .=  " </table> </section>";
     $this->HTML .=  "<section class='d-flex justify-content-between align-items-center'>";
     if ($total_records == 0) {
    } else if ($total_records == 1) {
      $get_users_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML .= "<span class='show_quantity'>Mostrando " . $total_records . " de " . $records_page . "
                                    <span class='show_quantity__message'> " . $display_log_message . "</span></span>";
      if ($current_page > 1) {
        $this->HTML .= "<a href='?page=" . ($current_page - 1) . "'>Anterior</a> ";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .= "<a href='?page=$i'>" . ($i == $current_page ? '<b>' . $i . '</b>' : $i) . "</a> ";
      }
      if ($current_page < $total_pages) {
        $this->HTML .= "<a href='?page=" . ($current_page + 1) . "'>Siguiente</a>";
      }
      $this->HTML .= " </section>";
    } else {

      $get_users_stmt->rowCount() == 1 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      $this->HTML .= "<span class='show_quantity'>Mostrando " . $get_users_stmt->rowCount() . " de " . $records_page . "
                                        <span class='show_quantity__message'> " . $display_log_message . "</span></span><nav
                                        class='navigation--egress navigation '><ul class='pagination'>";
      if ($current_page > 1) {
        $this->HTML .= "<li class='page__item '><a href='./" . ($current_page - 1) . "' class='page__link page__link--graduantion'>Anterior</a></li> ";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .= "<li class='page__item'>
                                            <a href='./" . $i . "' class='page__link page__link--graduantion'>" . ($i == $current_page ? '<b class="page__link--selected">' . $i . '</b>' : $i) . "</a>
                                        </li>";
      }
      if ($current_page < $total_pages) {
        $this->HTML .= "<li class='page__item'><a href='./" . ($current_page + 1) . "' class='page__link page__link--graduantion'>Siguiente</a>
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
