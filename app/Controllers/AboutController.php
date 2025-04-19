<?php

namespace App\Controllers;

use App\Controllers\AuthController;

class AboutController extends Controller
{
   public function __construct()
   {

      AuthController::checkSession();
   }

   public function index()
   {
      if (preg_match('/admin/', $_SERVER['REQUEST_URI'], $rol)) {
         return $this->view('admin.about', ['sidebar_jump' => './', 'header_jump' => './']);
      } else if (preg_match('/user/', $_SERVER['REQUEST_URI'], $rol)) {
         return $this->view('user.about');
      } else if (preg_match('/guest/', $_SERVER['REQUEST_URI'], $rol)) {
         return $this->view('guest.about',  ['sidebar_jump' => './', 'header_jump' => './']);
      }
   }
}
