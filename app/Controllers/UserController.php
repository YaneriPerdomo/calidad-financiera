<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\ProfileModel;
use App\Models\UserModel;

class UserController extends Controller
{
   public function __construct()
   {

      AuthController::checkSession();
   }

   public function index()
   {
      return $this->view('user.dashboard', ['main_jump' => './']);
   }

   //Muestra los detalles de un usuario el formulario para editar un usuario
   public function edit()
   {
      $url = $_SERVER['REQUEST_URI'];

      preg_match_all('/\d+/', $url, $coincidencias);

      $id = implode($coincidencias[0]);

      $get_user = new UserModel();
      $get_user->edit($id);

      return $this->view('admin.user-modify', ['data' => $get_user->data]);
   }

   public function update()
   {
      $update_user = new UserModel();
      $update_user->update([
         'id_usuario' => trim($_POST['id_user']),
         'usuario' => trim($_POST['user']),
         'correo_electronico' => trim($_POST['email']),
         'nombre' => trim($_POST['name']),
         'apellido' => trim($_POST['lastname']),
         'id_actividad' => trim($_POST['id_actividad']),
         'new-password' => trim($_POST['new-password']),
         'confirm-password' => trim($_POST['confirm-password'])
      ]);

      if ($update_user->status == true) {
         echo '<script>alert("Datos actualizados correctamente")
         location.href = "../dashboard/1"
         </script>';
      } else {
         echo '<script>alert("Sucedio un error al actualizar los datos")
         location.href = "./profile"
         </script>';
      }
   }
}
