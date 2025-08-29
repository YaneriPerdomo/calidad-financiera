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
        $user = $_POST['user'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($user) || empty($password)) {
            echo '<script>alert("Por favor, ingrese usuario y contraseña.");
                  location.href = "./login";</script>';
            exit();
        }

        $authentication = new LoginModel();
        $authentication->login(['user' => $user, 'password' => $password]);

        if ($authentication->status == true) {
            if ($authentication->user['estado'] == 0) {
                return '<script>alert("Lo sentimos, tu cuenta de usuario está deshabilitada. Para obtener asistencia, comunícate con el administrador.");
                  location.href = "./login";</script>';
                exit();
            }
            session_start();
            $_SESSION['id_usuario'] = $authentication->user['id_usuario'] ?? '';
            $_SESSION['usuario'] = $authentication->user['usuario'];
            $_SESSION['correo_electronico'] = $authentication->user['correo_electronico'] ?? '';
            $_SESSION['nombre'] = $authentication->user['nombre'] ?? '';
            $_SESSION['id_rol'] = $authentication->user['id_rol'];  
            switch ($authentication->user['id_rol'] ) {
                case 1:
                    echo 'hola';
                    $_SESSION['id_persona'] = $authentication->user['id_persona'] ?? '';
                    header('Location: ./user/dashboard/' . Date('m/Y'), true, 301);
                    break;
                case 2:
                    header('Location: ./admin/welcome', true, 301);
                    break;
                case 3:
                    $_SESSION['id_persona'] = $authentication->user['id_persona'] ?? '';
                    header('Location: ./guest/dashboard/' . Date('m/Y'), true, 301);
                    break;
                default:
                    header('Location: ./login', true, 301);
                    break;
            }

            exit();
        } else {
            echo '<script>alert("Usuario o contraseña incorrecta.");
                  location.href = "./login";</script>';
            exit();
        }
    }
}
