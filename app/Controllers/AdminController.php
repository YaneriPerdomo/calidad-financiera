<?php

namespace App\Controllers;

use App\Models\AdminModel;

class AdminController extends Controller
{

   public function __construct()
   {

       AuthController::checkSession();
   }
   public function index($page){
      

      $show_users = new AdminModel();
      $show_users->ShowUsers($page);
      return $this->view('admin.dashboard', ['HTML' => $show_users->HTML,
         'header_jump'=> '../',
         'sidebar_jump' => '../'
      ]);
   }

   //Mostrar de manera detalladamente a sus usuarios
   public function show(){
      
   }
     
}