<?php

namespace App\Controllers;
use App\Controllers\AuthController;
use App\Models\ProfileAdminModel;
use App\Models\ProfileModel;

class ProfileAdminController extends Controller{
   public function __construct(){
      AuthController::checkSession();
   }

   public function index(){
      $show_data_profile = new ProfileAdminModel();
      $show_data_profile->showData($_SESSION['id_usuario']);
      return $this->view('admin.profile' , ['data' => $show_data_profile->data]);
   }
   
   public function updateData(){
      if(empty($_POST)){
         echo '<script>alert("No se han recibido datos para actualizar")
         location.href = "./profile"
         </script>';
      }
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
         echo '<script>alert("Error al actualizar los datos")
         location.href = "./profile"
         </script>';
      }
   }
   
}