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
      AuthController::checkSession([1,2]);
   }

   public function index()
   {
      $url = $_SERVER['REQUEST_URI'];
      if (strpos($url, 'user')) {
         return $this->view('user.changes-password',[
             'sidebar_jump' => './',
                'header_break' => './',
                'header_jump' => './',
                'header_break_login' => '../'
         ]);
      } else if (strpos($url, 'admin')) {
         return $this->view('admin.changes-password' , [
             'sidebar_jump' => './',
                'header_break' => './',
                'header_jump' => './',
                'header_break_login' => '../'
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

       
     
       if($update_password->status == true){
          $this->sessionCreation(
                'alert-success',
                'La contraseña ha sido actualizada correctamente.'
            );
            header('location: ./changes-password', true, 302);
      }else{
              $this->sessionCreation(
                'alert-danger',
                $update_password->msg
            );
            header('location: ./changes-password', true, 302);
      }
    
    }
}
