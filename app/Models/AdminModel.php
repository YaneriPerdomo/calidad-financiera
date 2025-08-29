<?php

namespace App\Models;
use Lib\Database;
use PDO;
use PDOException;
class AdminModel extends Database
{

  public $HTML = '';

  public $data = [
    1 => 0,
    2 => 0,
    3 => 0
  ];

  public $users;
  public $status = false;
  function __construct()
  {
    parent::__construct();
  }

  public function reportUsers()
  {
    $get_persons_query = 'SELECT 
                              usuario, nombre, apellido, correo_electronico, actividades.actividad, estado 
                          FROM 
                              actividades 
                          INNER JOIN 
                              personas 
                          ON 
                              actividades.id_actividad = personas.id_actividad 
                          INNER JOIN 
                              usuarios 
                          ON 
                              personas.id_usuario = usuarios.id_usuario 
                          WHERE 
                              id_rol = 1';
    $get_persons_stmt = $this->pdo->prepare($get_persons_query);
    $get_persons_stmt->execute();
    if ($get_persons_stmt->rowCount() > 0) {
      $this->users = $get_persons_stmt->fetchAll(PDO::FETCH_ASSOC);
      return $this->status = true;
    }
  }

  public function ShowSearchUsers($searchUsers, $page = 1)
  {
    $searchUsers = "%" . $searchUsers . "%";
    $current_page = $page;
    $count_users_query = 'SELECT COUNT(*) as total_usuarios , usuario FROM usuarios WHERE id_rol = 1 AND
                          usuario LIKE :search';
    $count_users_stmt = $this->pdo->prepare($count_users_query);
    $count_users_stmt->bindParam(':search', $searchUsers, PDO::PARAM_STR);
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
                        WHERE 
                            usuarios.usuario 
                        LIKE :search
                        ORDER BY usuarios.id_usuario DESC
                        LIMIT 
                            :inicio, :registros_por_pagina';
    $start = ($current_page - 1) * $records_page;

    $get_users_stmt = $this->pdo->prepare($get_users_query);
    $get_users_stmt->bindParam(':inicio', $start, PDO::PARAM_INT);
    $get_users_stmt->bindParam(':search', $searchUsers, PDO::PARAM_STR);
    $get_users_stmt->bindParam(':registros_por_pagina', $records_page, PDO::PARAM_INT);
    $get_users_stmt->execute();
    $this->HTML = "";
    if ($get_users_stmt->rowCount() > 0) {
      $row_users = $get_users_stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($row_users as $row) {
        $created_at = utilities::generacion_fecha($row['fecha_creacion']);

        $created_at_last_session = utilities::generacion_fecha($row['ultimo_acceso']);

        $status = $row['estado'] == 1 ? 'Activo/a' : 'Desactivado/a';
        $this->HTML .= "<tr class='show'>";
        $this->HTML .= "<td >" . $row['usuario'] . "</td>";
        $this->HTML .= "<td>" . $row['nombre'] . "</td>";
        $this->HTML .= "<td>" . $row['apellido'] . "</td>";
        $this->HTML .= "<td>" . $row['correo_electronico'] . "</td>";
        $this->HTML .= "<td>" . $row['actividad'] . "</td>";
        $this->HTML .= "<td>" . $status . "</td>";
        $this->HTML .= "<td>" . $created_at ?? 'N/A' . "</td>";
        $this->HTML .= "<td>" . $created_at_last_session ?? 'N/A' . "</td>";
        $this->HTML .= "<td class='operations'>";
        $this->HTML .= "  <form action='../user/delete' method ='post' class='form-user__delete'>
                           <input type='hidden' value=" . $row['id_persona'] . " name='id_persona'>
                           <input type='hidden' value=" . $row['id_usuario'] . " name='id_usuario'>
                              <button class='  button--delete'>
                                <i class='bi bi-trash js-open-modal-delete' ></i> 
                              </button> 
                           </form> ";
        $this->HTML .= "<a href='../../../admin/" . $row['id_usuario'] . "-user/modify'>
                            <button class='button--modify'>
                              <i class='bi bi-person-lines-fill'></i>
                            </button>
                        </a>
                        <a href='../../../user/" . $row['id_usuario'] . "/progress'>
                            <button class='button--progress'>
                              <i class='bi bi-bar-chart-line'></i>
                            </button>
                        </a>";
        $this->HTML .= "</td>";
        $this->HTML .= "</tr>";
      }
    } else {
      $this->HTML .= " <br>
                                    <p>No hay usuarios registrados que coincidan con tu búsqueda.</p>
                                    <ul>
                                        <li>Revisa la ortografía de la palabra.</li>
                                        <li>Utiliza palabras más genéricas o menos palabras.</li>
                                    </ul>
                                
                                    
                                    ";
    }

    $this->HTML .= " </table> </section>";
    $this->HTML .= "<section class='d-flex justify-content-between align-items-center'>";
    if ($total_records == 0) {
    } else if ($total_records == 1) {
      $get_users_stmt->rowCount() == 0 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      if ($get_users_stmt->rowCount() == 1) {
      } else {
        $this->HTML .= "<span class='show_quantity'>Mostrando " . $total_records . " de " . $total_records . "
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
      }
      $this->HTML .= " </section>";
    } else {
      $get_users_stmt->rowCount() == 0 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      if ($get_users_stmt->rowCount() == 0) {
      } else {
        $this->HTML .= "<span class='show_quantity'> Mostrando " . $get_users_stmt->rowCount() . " de " . $total_records . "
                        <span class='show_quantity__message'> " . $display_log_message . "
                        </span>
                      </span>
                        <nav class='navigation--egress navigation'>
                          <ul class='pagination'>";
        if ($current_page > 1) {
          $this->HTML .= "<li class='page__item '><a href='./" . ($current_page - 1) . "' class='page__link '>Anterior</a></li> ";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
          $this->HTML .= "<li class='page__item'>
                                            <a href='./" . $i . "' class='page__link '>" . ($i == $current_page ? '<b class="page__link--selected">' . $i . '</b>' : $i) . "</a>
                                        </li>";
        }
        if ($current_page < $total_pages) {
          $this->HTML .= "<li class='page__item'><a href='./" . ($current_page + 1) . "' class='page__link '>Siguiente</a>
                                            </li>
                                        </ul>
                                    </nav>";
        } else {
          $this->HTML .= "</ul></nav>";
        }
      }
      $this->HTML .= " </section>";
    }
  }
  public function ShowUsers($page = 1)
  {

    $current_page = $page;
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
                        ORDER BY usuarios.id_usuario DESC
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
        $created_at = utilities::generacion_fecha($row['fecha_creacion']);

        $created_at_last_session = utilities::generacion_fecha($row['ultimo_acceso']);
        $status = $row['estado'] == 1 ? 'Activo/a' : 'Desactivado/a';
        $this->HTML .= "<tr class='show'>";
        $this->HTML .= "<td >" . $row['usuario'] . "</td>";
        $this->HTML .= "<td>" . $row['nombre'] . "</td>";
        $this->HTML .= "<td>" . $row['apellido'] . "</td>";
        $this->HTML .= "<td>" . $row['correo_electronico'] . "</td>";
        $this->HTML .= "<td>" . $row['actividad'] . "</td>";
        $this->HTML .= "<td>" . $status . "</td>";
        $this->HTML .= "<td>" . $created_at ?? 'N/A' . "</td>";
        $this->HTML .= "<td>" . $created_at_last_session ?? 'N/A' . "</td>";
        $this->HTML .= "<td class='operations'>";
        $this->HTML .= "
           <form action='../user/delete' method ='post' class='form-user__delete'>
                           <input type='hidden' value=" . $row['id_persona'] . " name='id_persona'>
                           <input type='hidden' value=" . $row['id_usuario'] . " name='id_usuario'>
                              <button class='  button--delete'>
                                <i class='bi bi-trash js-open-modal-delete' ></i> 
                              </button> 
                           </form>  ";

        $this->HTML .= "<a href='../../admin/" . $row['id_usuario'] . "-user/modify'>
                            <button class='button--modify'>
                              <i class='bi bi-person-lines-fill'></i>
                            </button>
                        </a>
                        <a href='../../user/" . $row['id_usuario'] . "/progress'>
                            <button class='button--progress'>
                              <i class='bi bi-bar-chart-line'></i>
                            </button>
                        </a>";
        $this->HTML .= "</td>";
        $this->HTML .= "</tr>";
      }
    } else {
      $this->HTML .= "<p>No hay registros disponibles en este momento.</p>";
    }

    $this->HTML .= " </table> </section>";
    $this->HTML .= "<section class='d-flex justify-content-between align-items-center'>";
    if ($total_records == 0) {
    } else if ($total_records == 1) {
      $get_users_stmt->rowCount() == 0 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      if ($get_users_stmt->rowCount() == 1) {
      } else {
        $this->HTML .= "<span class='show_quantity'>Mostrando " . $total_records . " de " . $total_records . "
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
      }
      $this->HTML .= " </section>";
    } else {
      $get_users_stmt->rowCount() == 0 ? $display_log_message = 'registro disponible' : $display_log_message = 'registros disponibles';
      if ($get_users_stmt->rowCount() == 0) {
      } else {
        $this->HTML .= "<span class='show_quantity'> Mostrando " . $get_users_stmt->rowCount() . " de " . $total_records . "
                        <span class='show_quantity__message'> " . $display_log_message . "
                        </span>
                      </span>
                        <nav class='navigation--egress navigation'>
                          <ul class='pagination'>";
        if ($current_page > 1) {
          $this->HTML .= "<li class='page__item '><a href='./" . ($current_page - 1) . "' class='page__link '>Anterior</a></li> ";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
          $this->HTML .= "<li class='page__item'>
                                            <a href='./" . $i . "' class='page__link '>" . ($i == $current_page ? '<b class="page__link--selected">' . $i . '</b>' : $i) . "</a>
                                        </li>";
        }
        if ($current_page < $total_pages) {
          $this->HTML .= "<li class='page__item'><a href='./" . ($current_page + 1) . "' class='page__link '>Siguiente</a>
                                            </li>
                                        </ul>
                                    </nav>";
        } else {
          $this->HTML .= "</ul></nav>";
        }
      }
      $this->HTML .= " </section>";
    }
  }

  public function countUsers()
  {
    $total_users_query = 'SELECT count(usuario) AS total_users FROM `usuarios` WHERE NOT id_usuario = 73';
    $total_users_stmt = $this->pdo->prepare($total_users_query);
    $total_users_stmt->execute();
    $total_users_row = $total_users_stmt->fetch(PDO::FETCH_ASSOC);
    return $this->data[1] = $total_users_row['total_users'];
  }

  public function countIndicators()
  {

    $count = 0;
    $total_incomes_query = 'SELECT count(ingreso) AS total_ingreso FROM ingresos';
    $total_incomes_stmt = $this->pdo->prepare($total_incomes_query);
    $total_incomes_stmt->execute();
    $total_incomes_row = $total_incomes_stmt->fetch(PDO::FETCH_ASSOC);

    $count = $count + $total_incomes_row['total_ingreso'];

    $total_egreso_query = 'SELECT count(egreso) AS total_egreso FROM egresos';
    $total_egreso_stmt = $this->pdo->prepare($total_egreso_query);
    $total_egreso_stmt->execute();
    $total_egreso_row = $total_egreso_stmt->fetch(PDO::FETCH_ASSOC);

    $count = $count + $total_egreso_row['total_egreso'];

    return $this->data[2] = $count;
  }
}
