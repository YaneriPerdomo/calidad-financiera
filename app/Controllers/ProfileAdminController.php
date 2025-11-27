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
       
        $post = [
            'user' => trim($_POST['user'] ?? ''),
        ];

        $rules = [
            'user' => ['required:Usuario', 'regex:user'],
        ];
        $userStoreRequest = Validation::request($post, $rules);
        if ($userStoreRequest != '') {
            $this->sessionCreation('alert-danger', $userStoreRequest);
            return header('Location: ./profile');
        }
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
          if ($update_data_profile->msg != 'Nada que modificar') {
              $this->sessionCreation(
                'alert-danger',
                $$update_data_profile->msg ?? 'Error: No se pudo completar la operación.'
            );
          }
            header('location: ./profile', true, 302);
      }
   }
   
}