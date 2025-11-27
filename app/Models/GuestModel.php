<?php

namespace App\Models;
use Lib\Database;
use PDO;
use PDOException;

class GuestModel extends Database
{
  public $status = false;
  public $data;
  public $msg;
  public $HTML = "";
  function __construct()
  {
    parent::__construct();
  }
  public function reportGuests($id_person)
  {
    $get_guests_query = 'SELECT 
                              usuario, nombre, apellido, correo_electronico,  estado 
                          FROM 
                             
                              invitados 
                         
                          INNER JOIN 
                              usuarios_cf 
                          ON 
                              invitados.id_usuario = usuarios_cf.id_usuario 
                       
                          AND
                              id_persona = :id_person';
    $get_guests_stmt = $this->pdo->prepare($get_guests_query);
    $get_guests_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_guests_stmt->execute();
    if ($get_guests_stmt->rowCount() > 0) {
      $this->data = $get_guests_stmt->fetchAll(PDO::FETCH_ASSOC);
      return $this->status = true;
    }
  }
  public function AddData($POST = [])
  {
    $search_name_user_not_you_query = 'SELECT * FROM `usuarios_cf` WHERE (usuario = :user )';
    $search_name_user_not_you_stmt = $this->pdo->prepare($search_name_user_not_you_query);
    $search_name_user_not_you_stmt->bindParam('user', $POST['user'], PDO::PARAM_STR);
    $search_name_user_not_you_stmt->execute();
    if ($search_name_user_not_you_stmt->rowCount() > 0) {
      $this->msg = "Ese nombre de usuario ya está en uso. Por favor, elige uno diferente.";
      return $this->status = false;
    }

    $search_email_query = 'SELECT * FROM `invitados` WHERE (correo_electronico = :correo_electronico )';
    $search_email_stmt = $this->pdo->prepare($search_email_query);
    $search_email_stmt->bindParam('correo_electronico', $POST['email'], PDO::PARAM_STR);
    $search_email_stmt->execute();
    if ($search_email_stmt->rowCount() > 0) {
      $this->msg = "El correo electrónico que ingresaste ya está registrado.";
      return $this->status = false;
    }
    try {
      $this->pdo->beginTransaction();
      $hash = password_hash($POST['password'], PASSWORD_DEFAULT);
      $add_data_user_query = 'INSERT INTO usuarios_cf (id_rol, usuario, clave, estado, fecha_creacion) 
      VALUES (3 ,:usuario, :clave, :_estado, NOW())';
      $add_data_user_stmt = $this->pdo->prepare($add_data_user_query);
      $add_data_user_stmt->bindParam('usuario', $POST['user'], PDO::PARAM_STR);
      $add_data_user_stmt->bindParam('_estado', $POST['status'], PDO::PARAM_INT);
      $add_data_user_stmt->bindParam('clave', $hash, PDO::PARAM_STR);
      $add_data_user_stmt->execute();

      $id_user = $this->pdo->lastInsertId();

      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario = :id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_persona = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);

      $add_data_guest_query = 'INSERT INTO invitados (id_usuario, id_persona, nombre, apellido, correo_electronico) 
                                 VALUES 
                                 (:id_usuario, :id_persona, :nombre, :apellido, :correo_electronico)';
      $add_data_guest_stmt = $this->pdo->prepare($add_data_guest_query);
      $add_data_guest_stmt->bindParam('id_usuario', $id_user, PDO::PARAM_INT);
      $add_data_guest_stmt->bindParam('id_persona', $row_id_persona['id_persona'], PDO::PARAM_INT);
      $add_data_guest_stmt->bindParam('nombre', $POST['name'], PDO::PARAM_STR);
      $add_data_guest_stmt->bindParam('apellido', $POST['lastname'], PDO::PARAM_STR);
      $add_data_guest_stmt->bindParam('correo_electronico', $POST['email'], PDO::PARAM_STR);
      $add_data_guest_stmt->execute();

      $this->pdo->commit();

      $this->status = true;
    } catch (PDOException $ex) {
      $this->pdo->rollBack();
      echo $ex->getMessage();
    }
  }

  function UpdateData($POST = [])
  {
    $search_name_user_not_you_query = 'SELECT * FROM `usuarios_cf` 
                                        WHERE usuario = :user AND id_usuario != :id_usuario';
    $search_name_user_not_you_stmt = $this->pdo->prepare($search_name_user_not_you_query);
    $search_name_user_not_you_stmt->bindParam('user', $POST['user'], PDO::PARAM_STR);
    $search_name_user_not_you_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
    $search_name_user_not_you_stmt->execute();
    if ($search_name_user_not_you_stmt->rowCount() > 0) {
      $this->msg = "Ese nombre de usuario ya está en uso. Por favor, elige uno diferente.";
      return $this->status = false;
    }

    try {
      $this->pdo->beginTransaction();

      $update_data_guest_query = 'UPDATE 
                                    invitados 
                                  SET 
                                    nombre = :nombre, apellido = :apellido, correo_electronico = :correo_electronico 
                                  WHERE 
                                    id_usuario = :id_usuario';
      $update_data_guest_stmt = $this->pdo->prepare($update_data_guest_query);

      $update_data_guest_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
      $update_data_guest_stmt->bindParam('nombre', $POST['name'], PDO::PARAM_STR);
      $update_data_guest_stmt->bindParam('apellido', $POST['lastname'], PDO::PARAM_STR);
      $update_data_guest_stmt->bindParam('correo_electronico', $POST['email'], PDO::PARAM_STR);

      $update_data_guest_stmt->execute();

      $update_data_user_query = 'UPDATE usuarios_cf SET usuario = :usuario, estado = :status_ WHERE id_usuario = :id_usuario';
      $update_data_user_stmt = $this->pdo->prepare($update_data_user_query);
      $update_data_user_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
      $update_data_user_stmt->bindParam('usuario', $POST['user'], PDO::PARAM_STR);
      $update_data_user_stmt->bindParam('status_', $POST['estado'], PDO::PARAM_INT);
      $update_data_user_stmt->execute();

      $upd_pass = false;
      if ($POST['password'] != '') {
        $update_password_query = 'UPDATE usuarios_cf SET clave =:clave WHERE id_usuario = :id_usuario';
        $update_password_stmt = $this->pdo->prepare($update_password_query);
        $hash = password_hash($POST['password'], PASSWORD_DEFAULT);
        $update_password_stmt->bindParam('clave', $hash, PDO::PARAM_STR);
        $update_password_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
        $update_password_stmt->execute();
        if ($update_password_stmt->rowCount() > 0) {
          $upd_pass = true;
        }
      }

      if ($update_data_guest_stmt->rowCount() > 0 || $update_data_user_stmt->rowCount() > 0 || $upd_pass == true) {
        $this->pdo->commit();
        return $this->status = true;
      } else {
        $this->status = false;
        return $this->msg = 'Nada que modificar';
      }
    } catch (PDOException $ex) {
      return $this->msg = $ex->getMessage();
    }
  }
  public function showData($id_user)
  {
    $get_data_guest_query = 'SELECT id_usuario , id_persona, nombre, apellido, correo_electronico FROM invitados WHERE id_usuario = :id_usuario';
    $get_data_guest_stmt = $this->pdo->prepare($get_data_guest_query);
    $get_data_guest_stmt->bindParam('id_usuario', $id_user, PDO::PARAM_INT);
    $get_data_guest_stmt->execute();
    $row_data_guest = $get_data_guest_stmt->fetch(PDO::FETCH_ASSOC);

    $get_data_user_query = 'SELECT usuario, estado FROM usuarios_cf WHERE id_usuario = :id_user';
    $get_data_user_stmt = $this->pdo->prepare($get_data_user_query);
    $get_data_user_stmt->bindParam('id_user', $id_user, PDO::PARAM_INT);
    $get_data_user_stmt->execute();
    $row_data_user = $get_data_user_stmt->fetch(PDO::FETCH_ASSOC);

    return $this->data = $row_data_guest + $row_data_user;
  }

  public function show($page = 1, $id_person = null)
  {


    $current_page = $page;
    $count_guests_query = 'SELECT COUNT(*) as total_invitados FROM invitados WHERE id_persona = :id';
    $count_guests_stmt = $this->pdo->prepare($count_guests_query);
    $count_guests_stmt->bindParam('id', $id_person, PDO::PARAM_INT);
    $count_guests_stmt->execute();
    $row_total_guests = $count_guests_stmt->fetch(PDO::FETCH_ASSOC);
    $total_records = $row_total_guests["total_invitados"];
    $records_page = 5;
    $total_pages = ceil($total_records / $records_page);
    // Verificamos si se encontraron resultados

    $get_guests_query = 'SELECT 
                            usuarios_cf.usuario, 
                            nombre, apellido, 
                            correo_electronico, 
                            usuarios_cf.id_usuario, 
                            invitados.id_invitado,  
                            usuarios_cf.estado,
                            ultimo_acceso,
                            fecha_creacion
                        FROM 
                            invitados 
                        INNER JOIN 
                            usuarios_cf 
                        ON 
                            invitados.id_usuario = usuarios_cf.id_usuario 
                        WHERE 
                            invitados.id_persona = :id_person
                        LIMIT 
                            :inicio, :registros_por_pagina';
    $start = ($current_page - 1) * $records_page;

    $get_guests_stmt = $this->pdo->prepare($get_guests_query);
    $get_guests_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_guests_stmt->bindParam(':inicio', $start, PDO::PARAM_INT);
    $get_guests_stmt->bindParam(':registros_por_pagina', $records_page, PDO::PARAM_INT);
    $get_guests_stmt->execute();

    $this->HTML = "";

    if ($get_guests_stmt->rowCount() > 0) {
      $row_guests = $get_guests_stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($row_guests as $row) {
        $created_at = utilities::generacion_fecha($row['fecha_creacion']);
        $created_at_last_session = utilities::generacion_fecha($row['ultimo_acceso']);
        $status = $row['estado'] == 1 ? 'Activo/a' : 'Desactivado/a';
        $this->HTML .= "<tr class='show'>";
        $this->HTML .= "<td >" . $row['usuario'] . "</td>";
        $this->HTML .= "<td>" . $row['nombre'] . "</td>";
        $this->HTML .= "<td>" . $row['apellido'] . "</td>";
        $this->HTML .= "<td>" . $row['correo_electronico'] . "</td>";
        $this->HTML .= "<td>" . $status . "</td>";

        $this->HTML .= "<td>" . $created_at ?? '' . "</td>";
        $this->HTML .= "<td> " . $created_at_last_session ?? '' . "</td>";
        $this->HTML .= "<td class='operations'>";
        $this->HTML .= "
                      
                      <button class='  button--delete' data-model='js_delete_guest' data-id-user='" . $row['id_usuario'] . "' 
        data-id-guest='" . $row['id_invitado'] . "'>
                                <i class='bi bi-trash ' ></i> 
                              </button>
                       
       ";
        $this->HTML .= "<a href='../guest/" . $row['id_usuario'] . "/modify'>
                            <button class='button--modify'>
                              <i class='bi bi-person-lines-fill'></i>
                            </button>
                        </a>";
        $estado = $row['estado'];
        $this->HTML .= "
        
                      <button class='  button--azul'  style='padding:0.5rem'
                              data-model='js_change_state_guest' 
                              data-id-user='" . $row['id_usuario'] . "' data-state='$estado' >
                               <i class='bi bi-person-fill-gear'></i> 
                      </button>
        ";
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
      $userRegistration = 'registro disponible';
      if ($get_guests_stmt->rowCount() == 1) {

      } else {
        $this->HTML .= "<span class='messengerShowUsers'>Mostrando " . $total_records . " de " . $total_records . " 
                          <span class='userRegistration'> " . $userRegistration . "</span> </span>
                        <nav class='navigation--egress navigation'>
                      <ul class='pagination'>";
        if ($current_page > 1) {
          $this->HTML .= "<li class='page__item'><a href='?page=" . ($current_page - 1) . "' class='page__link'>Anterior</a></li> ";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
          $this->HTML .= "<li class='page__item'><a href='?page=$i' class='page__link'>" . ($i == $current_page ? '<b  class="page__link--selected">' . $i . '</b >' : $i) . "</a></li> ";
        }
        if ($current_page < $total_pages) {
          $this->HTML .= "<li class='page__item'><a href='?page=" . ($current_page + 1) . "' class='page__link' >Siguiente</a></li> ";
        } else {
          $this->HTML .= "</ul></nav>";
        }
      }
      $this->HTML .= " </section>";
    } else {
      $userRegistration = 'registros disponibles';
      $this->HTML .= "<span class='messengerShowUsers'>Mostrando " . $get_guests_stmt->rowCount() . " de " . $total_records . " 
                     <span class='userRegistration'> " . $userRegistration . "</span></span> </span>
                        <nav class='navigation--egress navigation'>
                      <ul class='pagination'>";
      if ($current_page > 1) {
        $this->HTML .= "<li class='page__item'><a href='./" . ($current_page - 1) . "' class='page__link'>Anterior</a></li>";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .= "<li class='page__item'><a href='./$i' class='page__link'>" . ($i == $current_page ? '<b  class="page__link--selected">' . $i . '</b>' : $i) . "</a></li>";
      }
      if ($current_page < $total_pages) {
        $this->HTML .= "<li class='page__item'><a href='./" . ($current_page + 1) . "'class='page__link'>Siguiente</a></li></section>";
      } else {
        $this->HTML .= "</ul></nav>";
      }
      $this->HTML .= " </section>";
    }
  }

  public function searchGuest($nameUserSearch, $page = 1, $id_person = null)
  {
    $searchUsers = "%" . $nameUserSearch . "%";
    $current_page = $page;
    $count_guests_query = 'SELECT 
                              COUNT(*) 
                           AS 
                              total_invitados, nombre 
                           FROM 
                              invitados 
                           WHERE 
                              id_persona = :id 
                           AND
                              nombre LIKE :search';
    $count_guests_stmt = $this->pdo->prepare($count_guests_query);
    $count_guests_stmt->bindParam('search', $searchUsers, PDO::PARAM_STR);
    $count_guests_stmt->bindParam('id', $id_person, PDO::PARAM_INT);
    $count_guests_stmt->execute();
    $row_total_guests = $count_guests_stmt->fetch(PDO::FETCH_ASSOC);
    $total_records = $row_total_guests["total_invitados"];
    $records_page = 5;
    $total_pages = ceil($total_records / $records_page);
    // Veri ficamos si se encontraron resultados

    $get_guests_query = 'SELECT 
                            usuarios_cf.usuario, 
                            nombre, apellido, 
                            correo_electronico, 
                            usuarios_cf.id_usuario, 
                            invitados.id_invitado,  
                            usuarios_cf.estado,
                            ultimo_acceso,
                            fecha_creacion
                        FROM 
                            invitados 
                        INNER JOIN 
                            usuarios_cf 
                        ON 
                            invitados.id_usuario = usuarios_cf.id_usuario 
                        WHERE 
                            invitados.id_persona = :id_person
                        AND
                            invitados.nombre LIKE :search
                        LIMIT 
                            :inicio, :registros_por_pagina';
    $start = ($current_page - 1) * $records_page;

    $get_guests_stmt = $this->pdo->prepare($get_guests_query);
    $get_guests_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_guests_stmt->bindParam(':inicio', $start, PDO::PARAM_INT);
    $get_guests_stmt->bindParam('search', $searchUsers, PDO::PARAM_STR);
    $get_guests_stmt->bindParam(':registros_por_pagina', $records_page, PDO::PARAM_INT);
    $get_guests_stmt->execute();

    $this->HTML = "";
    if ($get_guests_stmt->rowCount() > 0) {
      $row_guests = $get_guests_stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($row_guests as $row) {
        $created_at = utilities::generacion_fecha($row['fecha_creacion']);
        $created_at_last_session = utilities::generacion_fecha($row['ultimo_acceso']);
        $status = $row['estado'] == 1 ? 'Activo/a' : 'Desactivado/a';
        $this->HTML .= "<tr class='show'>";
        $this->HTML .= "<td >" . $row['usuario'] . "</td>";
        $this->HTML .= "<td>" . $row['nombre'] . "</td>";
        $this->HTML .= "<td>" . $row['apellido'] . "</td>";
        $this->HTML .= "<td>" . $row['correo_electronico'] . "</td>";
        $this->HTML .= "<td>" . $status . "</td>";

        $this->HTML .= "<td>" . $created_at_last_session ?? '' . "</td>";
        $this->HTML .= "<td> " . $created_at ?? '' . "</td>";
        $this->HTML .= "<td class='operations'>";
        $this->HTML .= "
                        <button class='  button--delete' data-model='js_delete_guest' data-id-user='" . $row['id_usuario'] . "' 
        data-id-guest='" . $row['id_invitado'] . "'>
                                <i class='bi bi-trash ' ></i> 
                              </button> ";
        $this->HTML .= "<a href='../../guest/" . $row['id_usuario'] . "/modify'>
                            <button class='button--modify'>
                              <i class='bi bi-person-lines-fill'></i>
                            </button>
                        </a>";
                         $estado = $row['estado'];
        $this->HTML .= "
        
                      <button class='  button--azul'  style='padding:0.5rem'
                              data-model='js_change_state_guest' 
                              data-id-user='" . $row['id_usuario'] . "' data-state='$estado' >
                               <i class='bi bi-person-fill-gear'></i> 
                      </button>";
        $this->HTML .= "</td>";
        $this->HTML .= "</tr>";
      }
    } else {
      $this->HTML .= "<br>
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
      $userRegistration = 'registro disponible';
      $this->HTML .= "<span class='messengerShowUsers'>Mostrando " . $total_records . " de " . $total_records . " 
                          <span class='userRegistration'> " . $userRegistration . "</span> </span>
                        <nav class='navigation--egress navigation'>
                      <ul class='pagination'>";
      if ($current_page > 1) {
        $this->HTML .= "<li class='page__item'><a href='?page=" . ($current_page - 1) . "' class='page__link'>Anterior</a></li> ";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .= "<li class='page__item'><a href='?page=$i' class='page__link'>" . ($i == $current_page ? '<b  class="page__link--selected">' . $i . '</b >' : $i) . "</a></li> ";
      }
      if ($current_page < $total_pages) {
        $this->HTML .= "<li class='page__item'><a href='?page=" . ($current_page + 1) . "' class='page__link' >Siguiente</a></li> ";
      } else {
        $this->HTML .= "</ul></nav>";
      }
      $this->HTML .= " </section>";
    } else {
      $userRegistration = 'registros disponibles';
      $this->HTML .= "<span class='messengerShowUsers'>Mostrando " . $get_guests_stmt->rowCount() . " de " . $total_records . " 
                     <span class='userRegistration'> " . $userRegistration . "</span></span> </span>
                        <nav class='navigation--egress navigation'>
                      <ul class='pagination'>";
      if ($current_page > 1) {
        $this->HTML .= "<li class='page__item'><a href='./" . ($current_page - 1) . "' class='page__link'>Anterior</a></li>";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .= "<li class='page__item'><a href='./$i' class='page__link'>" . ($i == $current_page ? '<b  class="page__link--selected">' . $i . '</b>' : $i) . "</a></li>";
      }
      if ($current_page < $total_pages) {
        $this->HTML .= "<li class='page__item'><a href='./" . ($current_page + 1) . "'class='page__link'>Siguiente</a></li></section>";
      } else {
        $this->HTML .= "</ul></nav>";
      }
      $this->HTML .= " </section>";
    }
  }

  public function changeStateGuest($POST)
  {
    try {
      $delete_guest_query = 'UPDATE usuarios_cf SET estado = :state_
          WHERE id_usuario = :id';

      $delete_guest_stmt = $this->pdo->prepare($delete_guest_query);
      $delete_guest_stmt->bindParam('id', $POST['id_user'], PDO::PARAM_INT);
      $delete_guest_stmt->bindParam('state_', $POST['state'], PDO::PARAM_INT);
      $delete_guest_stmt->execute();
 

      if ($delete_guest_stmt->rowCount() > 0  ) {
        return $this->status = true;
      } else {
        return $this->msg = 'Nada que modificar';
      }
    } catch (PDOException $th) {
      return $this->msg = $th->getMessage();
    }
  }
  public function destroy($id_user, $id_guest)
  {

    try {
      $delete_guest_query = 'DELETE FROM invitados WHERE id_invitado = :id_invitado';

      $delete_guest_stmt = $this->pdo->prepare($delete_guest_query);
      $delete_guest_stmt->bindParam('id_invitado', $id_guest, PDO::PARAM_INT);
      $delete_guest_stmt->execute();

      $delete_user_query = 'DELETE FROM usuarios_cf WHERE id_usuario = :id_usuario';
      $delete_user_stmt = $this->pdo->prepare($delete_user_query);
      $delete_user_stmt->bindParam('id_usuario', $id_user, PDO::PARAM_INT);
      $delete_user_stmt->execute();

      if ($delete_guest_stmt->rowCount() > 0 && $delete_user_stmt->rowCount() > 0) {
        return $this->status = true;
      } else {
        return $this->msg = 'Ah sucedido un error al eliminar el invitado';
      }
    } catch (PDOException $th) {
      return $this->msg = $th->getMessage();
    }
  }
}
