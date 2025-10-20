<?php

namespace App\Controllers;

use App\Models\LoginModel;

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
            $this->sessionCreation('alert-danger', 'Por favor, ingrese usuario y contraseña.');
            header('Location: ./login');
            exit();
        }
        $authentication = new LoginModel;
        $authentication->login(['user' => $user, 'password' => $password]);
        if ($authentication->status == true) {
            if ($authentication->user['estado'] == 0) {
                $this->sessionCreation('alert-danger', 'Lo sentimos, tu cuenta de usuario está deshabilitada. Para obtener asistencia, comunícate con el administrador.');
                header('Location: ./login');
                exit();
            }
            session_start();
            unset($_SESSION['alert-success']);
            $_SESSION['id_usuario'] = $authentication->user['id_usuario'] ?? '';
            $_SESSION['usuario'] = $authentication->user['usuario'];
            $_SESSION['correo_electronico'] = $authentication->user['correo_electronico'] ?? '';
            $_SESSION['nombre'] = $authentication->user['nombre'] ?? '';
            $_SESSION['id_rol'] = $authentication->user['id_rol'];
            switch ($authentication->user['id_rol']) {
                case 1:
                    echo 'hola';
                    $_SESSION['id_persona'] = $authentication->user['id_persona'] ?? '';
                    header('Location: ./user/dashboard/'.date('m/Y'), true, 301);
                    break;
                case 2:
                    header('Location: ./admin/welcome', true, 301);
                    break;
                case 3:
                    $_SESSION['id_persona'] = $authentication->user['id_persona'] ?? '';
                    header('Location: ./guest/dashboard/'.date('m/Y'), true, 301);
                    break;
                default:
                    header('Location: ./login', true, 301);
                    break;
            }

            exit();
        } else {
            $this->sessionCreation('alert-danger', 'Usuario o contraseña incorrecta');
            header('Location: ./login');
            exit();
        }
    }
}
