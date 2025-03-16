<?php

namespace App\Controllers;

use Lib\Database;

class Controller
{
   public function view($route, $data = [])
   {
      // Destructurar arreglo
      extract($data); // Convierte las claves del arreglo $data en variables

      $route = str_replace('.', '/', $route); //opcional
      if (file_exists("../resources/views/{$route}.php")) {

         ob_start();
         include "../resources/views/{$route}.php";
         $content = ob_get_clean();

         return $content;
      } else {
         return "El archivo no existe";
      }
   }



   public function redirect($route)
   {
      header("Location: {$route}");
   }

   //Verificar si el usuario esta logueado

}
