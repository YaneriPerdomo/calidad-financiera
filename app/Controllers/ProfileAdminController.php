<?php

namespace App\Controllers;
use App\Controllers\AuthController;
use App\Models\ProfileAdminModel;
use App\Models\ProfileModel;

class ProfileAdminController extends Controller{
   public function __construct(){
      AuthController::checkSession([1]);
   }

   public function updateData(){
       
    
     
      $update_data_profile = new ProfileAdminModel();
      $update_data_profile->updateData([
         'id_usuario' => $_SESSION['id_usuario'],
         'usuario' => $_POST['user'],
      ]);
      if($update_data_profile->status == true){
          $this->sessionCreation(
                'alert-success',
                'El nombre de usuario ha sido actualizado correctamente.'
            );
            header('location: ./profile', true, 302);
      }else{
              $this->sessionCreation(
                'alert-danger',
                $$update_data_profile->msg
            );
            header('location: ../indicators/1/1', true, 302);
      }
   }
   
}