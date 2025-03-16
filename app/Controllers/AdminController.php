<?php

namespace App\Controllers;

 
class AdminController extends Controller
{
   public function index()
   {
    
      return $this->view('admin.dashboard');
   }
   
     
}