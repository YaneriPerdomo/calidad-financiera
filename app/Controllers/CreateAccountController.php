<?php

namespace App\Controllers;

use App\Models\createAccountModel;


class CreateAccountController extends Controller
{
   public function index()
   {

      return $this->view('create-account', ['title' => 'Login']);
   }

   public function add()
   {
      $user = $_POST['user'];
      $email = $_POST['email'];
      $actividad = $_POST['actividad'];
      $password = $_POST['password'];

      $model = new createAccountModel();
      $model->create([
         'user' => $user,
         'email' => $email,
         'actividad' => $actividad,
         'password' => $password
      ]);

      return $model->status == false
         ? '<script>alert("Sucedio un error"); location.href = "./create-account"</script>'
         : '<script>alert("Usuario creado correctamente"); location.href = "./login"</script>';
   }
}
