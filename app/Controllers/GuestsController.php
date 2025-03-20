<?php

namespace App\Controllers;
use App\Controllers\AuthController;
 
class GuestsController extends Controller
{
   public function __construct(){
     
      AuthController::checkSession();
   }

   public function index()
   {
    
      return $this->view('user.guests');
   }
   
    
    
 
     
}