<?php

namespace App\Controllers;

class AuthController
{
   public static function checkSession($id_rol = [1,null])
   {
      session_start();
      if (!isset($_SESSION['usuario'])   ) {
         //|| $_SESSION['id_rol'] == $id_rol[1]
        
         header('Location: ./../login');
         exit();
      }
   }
}
?>