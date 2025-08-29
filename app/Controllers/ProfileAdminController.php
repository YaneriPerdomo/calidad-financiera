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
         echo '<script>alert("Datos actualizados correctamente")
         location.href = "./profile"
         </script>';
      }else{
         echo '<script>alert("'.$update_data_profile->msg.'")
         location.href = "./profile"
         </script>';
      }
   }
   
}