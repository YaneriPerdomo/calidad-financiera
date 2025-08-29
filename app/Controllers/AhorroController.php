<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\AhorroModel;
use App\Models\ChangesPassword;
use App\Models\ChangesPasswordModel;
use App\Models\ProfileAdminModel;
use App\Models\ProfileModel;
use App\Models\UserModel;

class AhorroController extends Controller
{
   public function __construct()
   {
      AuthController::checkSession();
   }

   public function store($porcentaje, $id){
    
    $update_ahorro = new AhorroModel();
    $update_ahorro->update($porcentaje, $id);
    if($update_ahorro->status == true){
        return 'bien hecho';
    }else{
        return 'mal hecho';
    }
    
   }

   
}
