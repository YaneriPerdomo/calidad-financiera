<?php

namespace App\Controllers;

 
class AdminController extends Controller
{

   public function __construct()
   {

       AuthController::checkSession();
   }
   public function index(){
    
      return $this->view('admin.dashboard');
   }

    
     
}