<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Controllers\AdminController;

class LoginController extends Controller
{
    public function index()
    {

        return $this->view('login', ['title' => 'Login']);
    }

    public function authentication()
    {
        $user = $_POST['user'];
        $password = $_POST['password'];

        $authentication =  new LoginModel();
        $authentication->login(['user' => $user, 'password' => $password]);

        if ($authentication->status == false) {
            echo '<script>alert("Usuario o contraseña incorrecta")
            location.href = "./login"
            </script>';
        }

        if ($authentication->status == true) {
            session_start(); // Inicia la sesión
            $_SESSION['usuario'] = $authentication->user;
            $_SESSION['id_usuario'] = $authentication->user->id_usuario;
            $_SESSION['correo_electronico'] = $authentication->user->correo_electronico;
            var_dump($authentication->user);
            switch ($authentication->user->id_rol) {
                case 1:
                    header('Location: ./user/dashboard',  true, 301);
                    break;
                case 2:
                    header('Location: ./admin/dashboard',  true, 301);
                    break;
                case 3:
                    header('Location: ./guest/dashboard',  true, 301);
                    break;
                default:

                    break;
            }


            echo 'Bienvenido';
        }

        //  header('Location: ./admin/dashboard',  true, 301);
        exit();
    }
}
