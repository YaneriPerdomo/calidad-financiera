<?php

namespace App\Controllers;
use App\Controllers\AuthController;
use App\Models\ProfileModel;
 
class ChangesPasswordController extends Controller
{
   public function __construct(){
     
      AuthController::checkSession();
   }

   public function index()
   {
    
      return $this->view('user.changes-password');
   }
   
    public function updatePassword(){
        $updatePassword = new ProfileModel();
        $updatePassword->updatePassword([
         'old-password' =>  $_POST['old-password'],
         'new-password' => $_POST['new-password'],
         'confirm-password' => $_POST['confirm-password']
        ]);

        return $updatePassword->status == false
        ? '<script>alert("Sucedio un error"); location.href = "./changes-password"</script>'
        : '<script>alert("Contraseña cambiada correctamente"); location.href = "./changes-password"</script>';
      
    }
    
}