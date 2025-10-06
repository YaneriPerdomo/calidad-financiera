<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\ProfileAdminModel;
use App\Models\ProfileGuestModel;
use App\Models\ProfileModel;
use App\Models\UserModel;
use PhpParser\Node\Stmt\Return_;

class ProfileController extends Controller
{
   public function __construct()
   {
      AuthController::checkSession();
   }

   public function index()
   {

      $type_rol = '';
      $url = $_SERVER['REQUEST_URI'];
      if (strpos($url, 'user')) {
         $type_rol = 'user';
         $show_data_profile = new UserModel();
         $show_data_profile->edit($_SESSION['id_usuario']);
         return $this->view('user.profile', [
            'data' => $show_data_profile->data,
            'sidebar_jump' => './',
            'todas_actividades' => $show_data_profile->todas_actividades,
                'header_break' => './',
                'header_jump' => './',
                'header_break_login' => '../'
         ]);
      } else if (strpos($url, 'admin')) {
         $type_rol = 'admin';
         $show_data_profile = new ProfileAdminModel();
         $show_data_profile->showData($_SESSION['id_usuario']);

         return $this->view('admin.profile', [
            'data' => $show_data_profile->data,
            'header_jump' => './',
            'sidebar_jump' => './',
            'header_break' => './../../',
            'header_break_login' => './../'
         ]);
      } else if (strpos($url, 'guest')) {
         $show_data_profile = new ProfileGuestModel();
         $show_data_profile->ShowData($_SESSION['id_usuario']);
         $type_rol = 'guest';
         return $this->view('guest.profile', ['data' => $show_data_profile->data,
         'header_break_login' => '../',
         'sidebar_jump' => './',
         'header_break' => './'
      ]);
      }

      echo $type_rol;
   }

   public function updateData()
   {
      if (empty($_POST)) {
         echo '<script>alert("No se han recibido datos para actualizar")
         location.href = "./profile"
         </script>';
      }
      $update_data_profile = new UserModel();
      $update_data_profile->update([
         'id_usuario' => $_SESSION['id_usuario'],
         'usuario' => $_POST['user'],
         'correo_electronico' => $_POST['email'],
         'nombre' => $_POST['name'],
         'apellido' => $_POST['lastname'],
         'id_actividad' => $_POST['id_actividad']
      ], 'user');

      
      if ($update_data_profile->status == true) {
         echo '<script>alert("Datos actualizados correctamente")
         location.href = "./profile"
         </script>';
      } else {
         echo '<script>alert("'.$update_data_profile->msg.'")
         location.href = "./profile"
         </script>';
      }
   }
}
