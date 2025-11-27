<?php

namespace App\Controllers;

use App\Models\ActividadModel;
use App\Models\createAccountModel;


class CreateAccountController extends Controller
{
   public function index()
   {
      $actividades = new ActividadModel();
      $actividades->index();
      return $this->view('create-account', ['actividades' => $actividades->data]);
   }

   public function probando($id)
   {
      return $this->view('create-account', ['style' => '../']);
   }
   public function add()
   {

      $post = [
         'name' => trim($_POST['name'] ?? ''),
         'lastname' => trim($_POST['lastname'] ?? ''),
         'email' => trim($_POST['email'] ?? ''),
         'user' => trim($_POST['user'] ?? ''),
         'actividad' => trim($_POST['actividad'] ?? ''),
         'password' => trim($_POST['password'] ?? ''),
         'confirm_password' => trim($_POST['confirm_password'] ?? '')
      ];

      $rules = [
         'name' => ['required:Nombre', 'regex:name'],
         'lastname' => ['required:Apellido', 'regex:lastname'],
         'email' => ['required:Correo electrónico', 'regex:email'],
         'actividad' => ['required:actividad'],
         'user' => ['required:Usuario', 'regex:user'],
         'password' => ['required:Contraseña', 'confirmed'],
         'confirm_password' => ['required:Confirma Contraseña']
      ];

      $userStoreRequest = Validation::request($post, $rules);

      if ($userStoreRequest != '') {
         $this->sessionCreation('alert-danger', $userStoreRequest);
         return header('Location: ./create-account');
      }

      $name = trim($_POST['name']);
      $lastname = trim($_POST['lastname']);
      $user = trim($_POST['user']);
      $email = trim($_POST['email']);
      $id_actividad = trim($_POST['actividad']);
      $password = trim($_POST['password']);


      $model = new createAccountModel();
      $model->create([
         'name' => $name,
         'lastname' => $lastname,
         'user' => $user,
         'email' => $email,
         'id_actividad' => $id_actividad,
         'password' => $password
      ]);

      if (!$model->status) {
         $this->sessionCreation('alert-danger', $model->msg);
         header('Location: ./create-account');
      } else {
         $this->sessionCreation('alert-success', 'El Usuario ha sido creado correctamente');
         header('Location: ./login');
      }

   }
}
