<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\ChangesPassword;
use App\Models\ChangesPasswordModel;
use App\Models\ProfileAdminModel;
use App\Models\ProfileModel;
use App\Models\UserModel;

class ChangesPasswordController extends Controller
{
   public function __construct()
   {

      AuthController::checkSession();
   }

   public function index()
   {
      $url = $_SERVER['REQUEST_URI'];
      if (strpos($url, 'user')) {
         return $this->view('user.changes-password');
      } else if (strpos($url, 'admin')) {
         return $this->view('admin.changes-password' , [
             'sidebar_jump' => './',
                'header_break' => './',
                'header_break_login' => './'
         ]);
      }
   }

   public function update()
   {
    
      $update_password = new ChangesPasswordModel();
      $update_password->updateOldPassword([
         'id_usuario' => $_SESSION['id_usuario'],
         'old-password' =>  $_POST['old-password'],
         'new-password' => $_POST['new-password'],
         'confirm-password' => $_POST['confirm-password']
      ]);

     var_dump($update_password->status);

     return $update_password->status == false
     ? '<script>alert("Sucedio un error"); location.href = "./changes-password"</script>'
     : '<script>alert("Contraseña cambiada correctamente"); location.href = "./changes-password"</script>';

    }
}
