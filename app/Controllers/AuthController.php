<?php

namespace App\Controllers;

class AuthController{
    public static function checkSession(){
        session_start(); 
  
        if (!isset($_SESSION['usuario'])) {
           header('Location: ./../login');
           exit(); 
        }
     }
}
?>