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
        // Get user input from the form
        $user = $_POST['user'] ?? '';
        $password = $_POST['password'] ?? '';
    
        // Validate input (optional but recommended)
        if (empty($user) || empty($password)) {
            echo '<script>alert("Por favor, ingrese usuario y contraseña.");
                  location.href = "./login";</script>';
            exit();
        }
    
        // Authenticate the user
        $authentication = new LoginModel();
        $authentication->login(['user' => $user, 'password' => $password]);
    
        // Debugging: Uncomment to see the raw POST data and login result
        // var_dump($_POST);
        // var_dump($loginResult);
    
        // Check if login was successful
        if ($authentication->status == true) {
     
            session_start();  
            $_SESSION['id_usuario'] = $authentication->user['id_usuario'] ?? '';
            $_SESSION['usuario'] = $authentication->user['usuario']  ;
            $_SESSION['correo_electronico'] = $authentication->user['correo_electronico'] ?? '';
            $_SESSION['nombre'] = $authentication->user['nombre'] ?? '';
            switch ($authentication->user['id_rol']) {
                case 1:
                    echo 'hola';
                    $_SESSION['id_persona'] = $authentication->user['id_persona'] ?? '';                    
                    header('Location: ./user/dashboard/'.Date('m/Y'), true, 301);
                    break;
                case 2:
                    header('Location: ./admin/dashboard/1', true, 301);
                    break;
                case 3:
                    $_SESSION['id_persona'] = $authentication->user['id_persona'] ?? '';
                    header('Location: ./guest/dashboard/1', true, 301);
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
