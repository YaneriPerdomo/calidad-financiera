<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class GuestModel extends Database
{

  public $status = false;

  public $data;

  public $HTML = "";
  function __construct()
  {
    parent::__construct();
  }

  public function AddData($POST = [])
  {

    try {
      $this->pdo->beginTransaction();
      $hash =  password_hash($POST['password'], PASSWORD_DEFAULT);
      $add_data_user_query = 'INSERT INTO usuarios (id_rol, usuario, clave) VALUES (3 ,:usuario, :clave)';
      $add_data_user_stmt = $this->pdo->prepare($add_data_user_query);
      $add_data_user_stmt->bindParam('usuario', $POST['user'], PDO::PARAM_STR);
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
      echo  $ex->getMessage();
    }
  }


  function UpdateData($POST = [])
  {
    try {
      $update_data_guest_query = 'UPDATE invitados SET nombre = :nombre, apellido = :apellido, correo_electronico = :correo_electronico WHERE id_usuario = :id_usuario';
      $update_data_guest_stmt = $this->pdo->prepare($update_data_guest_query);
      $update_data_guest_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
      $update_data_guest_stmt->bindParam('nombre', $POST['name'], PDO::PARAM_STR);
      $update_data_guest_stmt->bindParam('apellido', $POST['lastname'], PDO::PARAM_STR);
      $update_data_guest_stmt->bindParam('correo_electronico', $POST['email'], PDO::PARAM_STR);

      $update_data_guest_stmt->execute();
      $row_data_guest = $update_data_guest_stmt->fetch(PDO::FETCH_ASSOC);

      $update_data_user_query = 'UPDATE usuarios SET usuario = :usuario WHERE id_usuario = :id_usuario';
      $update_data_user_stmt = $this->pdo->prepare($update_data_user_query);
      $update_data_user_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
      $update_data_user_stmt->bindParam('usuario', $POST['user'], PDO::PARAM_STR);
      $update_data_user_stmt->execute();

      if ($POST['password'] != '') {
        $update_password_query = 'UPDATE usuarios SET clave =:clave WHERE id_usuario = :id_usuario';
        $update_password_stmt = $this->pdo->prepare($update_password_query);
        $hash = password_hash($POST['password'], PASSWORD_DEFAULT);
        $update_password_stmt->bindParam('clave', $hash, PDO::PARAM_STR);
        $update_password_stmt->bindParam('id_usuario', $POST['id_user'], PDO::PARAM_INT);
        $update_password_stmt->execute();
      }


      return $this->data =  1;
    } catch (PDOException $exh) {
      echo $exh->getMessage();
    }
  }
  public function showData($id_user)
  {
    $get_data_guest_query = 'SELECT id_usuario , id_persona, nombre, apellido, correo_electronico FROM invitados WHERE id_usuario = :id_usuario';
    $get_data_guest_stmt = $this->pdo->prepare($get_data_guest_query);
    $get_data_guest_stmt->bindParam('id_usuario', $id_user, PDO::PARAM_INT);
    $get_data_guest_stmt->execute();
    $row_data_guest = $get_data_guest_stmt->fetch(PDO::FETCH_ASSOC);

    $get_data_user_query = 'SELECT usuario FROM usuarios WHERE id_usuario = :id_user';
    $get_data_user_stmt = $this->pdo->prepare($get_data_user_query);
    $get_data_user_stmt->bindParam('id_user', $id_user, PDO::PARAM_INT);
    $get_data_user_stmt->execute();
    $row_data_user = $get_data_user_stmt->fetch(PDO::FETCH_ASSOC);

    return $this->data =  $row_data_guest + $row_data_user;
  }


  public function show($page = 1, $id_person = null)
  {


    $current_page =  $page;
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
                            usuarios.usuario, nombre, apellido, correo_electronico, usuarios.id_usuario, invitados.id_invitado,  COALESCE(ultimo_acceso, "Aún no ha iniciado sesión") AS ultimo_acceso
                        FROM 
                            invitados 
                        INNER JOIN 
                            usuarios 
                        ON 
                            invitados.id_usuario = usuarios.id_usuario 
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

        $this->HTML .= "<tr class='show'>";
        $this->HTML .= "<td >" . $row['usuario'] . "</td>";
        $this->HTML .=  "<td>" . $row['nombre'] . "</td>";
        $this->HTML .=  "<td>" . $row['apellido'] . "</td>";
        $this->HTML .=  "<td>" . $row['correo_electronico'] . "</td>";
        $this->HTML .=  "<td>" . $row['ultimo_acceso'] . "</td>";
        $this->HTML .=  "<td class='operations'>";
        $this->HTML .= "<button class='  button--delete'>
                           <i class='bi bi-trash js-open-modal-delete'  data-id_guest='" . $row['id_invitado'] . "' data-id_user='" . $row['id_usuario'] . "'></i>  
                        </button>";
        $this->HTML .= "<a href='../guest/" . $row['id_usuario'] . "/modify'>
                            <button class='button--modify'>
                              <i class='bi bi-person-lines-fill'></i>
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
      $userRegistration = 'registro disponible';
      $this->HTML .=  "<span class='messengerShowUsers'>Mostrando " . $total_records . " de " . $records_page . " 
                 <span class='userRegistration'> " . $userRegistration . "</span></span>";
      if ($current_page > 1) {
        $this->HTML .=  "<a href='?page=" . ($current_page - 1) . "'>Anterior</a> ";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .=  "<a href='?page=$i'>" . ($i == $current_page ? '<b>' . $i . '</b>' : $i) . "</a> ";
      }
      if ($current_page < $total_pages) {
        $this->HTML .=  "<a href='?page=" . ($current_page + 1) . "'>Siguiente</a>";
      }
      $this->HTML .=  " </section>";
    } else {
      $userRegistration = 'registros disponibles';
      $this->HTML .=  "<span class='messengerShowUsers'>Mostrando " . $get_guests_stmt->rowCount() . " de " . $records_page . " 
                     <span class='userRegistration'> " . $userRegistration . "</span></span><section style='display: flex;gap: 0.5rem;' 
                     class='operation-pagitation'>";
      if ($current_page > 1) {
        $this->HTML .=  "<a href='./" . ($current_page - 1) . "'>Anterior</a> ";
      }
      for ($i = 1; $i <= $total_pages; $i++) {
        $this->HTML .=  "<a href='./$i'>" . ($i == $current_page ? '<b>' . $i . '</b>' : $i) . "</a> ";
      }
      if ($current_page < $total_pages) {
        $this->HTML .=  "<a href='./" . ($current_page + 1) . "'>Siguiente</a></section>";
      }
      $this->HTML .=  " </section>";
    }
  }
}
