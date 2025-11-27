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
      AuthController::checkSession([1, 2]);
   }

   public function index()
   {
      $url = $_SERVER['REQUEST_URI'];
      if (strpos($url, 'user')) {
         return $this->view('user.changes-password', [
            'sidebar_jump' => './',
            'header_break' => './',
            'header_jump' => './',
            'header_break_login' => '../'
         ]);
      } else if (strpos($url, 'admin')) {
         return $this->view('admin.changes-password', [
            'sidebar_jump' => './',
            'header_break' => './',
            'header_jump' => './',
            'header_break_login' => '../'
         ]);
      }
   }

   public function update()
   {
      
      $post = [
           'old-password' => trim( $_POST['old-password'] ?? ''),
         'new-password' => trim($_POST['new-password'] ?? ''),
         'confirm_password' => trim($_POST['confirm_password'] ?? '')
      ];

      $rules = [
         'old-password' => ['required:Contraseña Actual'],
         'new-password' => ['required:Contraseña', 'confirmed'],
         'confirm_password' => ['required:Confirma Contraseña']
      ];
      $userStoreRequest = Validation::request($post, $rules);
      if ($userStoreRequest != '') {
         $this->sessionCreation('alert-danger', $userStoreRequest);
         return header('Location: ./changes-password');
      }

       $update_password = new ChangesPasswordModel();
      $update_password->updateOldPassword([
         'id_usuario' => $_SESSION['id_usuario'],
         'old-password' => $_POST['old-password'],
         'new-password' => $_POST['new-password'],
         'confirm_password' => $_POST['confirm_password']
      ]);


      if ($update_password->status == true) {
         $this->sessionCreation(
            'alert-success',
            'La contraseña ha sido actualizada correctamente.'
         );
         header('location: ./changes-password', true, 302);
      } else {
         $this->sessionCreation(
            'alert-danger',
            $update_password->msg ?? 'Error: No se pudo completar la operación.'
         );
         header('location: ./changes-password', true, 302);
      }

   }
}
