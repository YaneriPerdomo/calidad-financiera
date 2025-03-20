<?php

namespace App\Controllers;
use App\Controllers\AuthController;
use App\Models\ProfileModel;

class ProfileController extends Controller{
   public function __construct(){
      AuthController::checkSession();
   }

   public function index(){
      $show_data_profile = new ProfileModel();
      $show_data_profile->showData($_SESSION['id_usuario']);
      return $this->view('user.profile' , ['data' => $show_data_profile->data]);
   }
   
   public function updateData(){
      if(empty($_POST)){
         echo '<script>alert("No se han recibido datos para actualizar")
         location.href = "./profile"
         </script>';
      }
      $update_data_profile = new ProfileModel();
      $update_data_profile->updateData([
         'id_usuario' => $_SESSION['id_usuario'],
         'usuario' => $_POST['user'],
         'correo_electronico' => $_POST['email'],
         'nombre' => $_POST['name'],
         'apellido' => $_POST['lastname'],
         'id_actividad' => $_POST['id_actividad']
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