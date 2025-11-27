<?php

namespace App\Controllers;

use App\Models\ProfileAdminModel;
use App\Models\ProfileGuestModel;
use App\Models\UserModel;

class ProfileController extends Controller
{
    public function __construct()
    {
        AuthController::checkSession();
    }

    public function index()
    {

        $type_rol = '';
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, 'user')) {
            $type_rol = 'user';
            $show_data_profile = new UserModel;
            $show_data_profile->edit($_SESSION['id_usuario']);

            return $this->view('user.profile', [
                'data' => $show_data_profile->data,
                'sidebar_jump' => './',
                'todas_actividades' => $show_data_profile->todas_actividades,
                'header_break' => './',
                'header_jump' => './',
                'header_break_login' => '../',
            ]);
        } elseif (strpos($url, 'admin')) {
            $type_rol = 'admin';
            $show_data_profile = new ProfileAdminModel;
            $show_data_profile->showData($_SESSION['id_usuario']);

            return $this->view('admin.profile', [
                'data' => $show_data_profile->data,
                'header_jump' => './',
                'sidebar_jump' => './',
                'header_break' => './../../',
                'header_break_login' => './../',
            ]);
        } elseif (strpos($url, 'guest')) {
            $show_data_profile = new ProfileGuestModel;
            $show_data_profile->ShowData($_SESSION['id_usuario']);
            $type_rol = 'guest';

            return $this->view('guest.profile', [
                'data' => $show_data_profile->data,
                'header_break_login' => '../',
                'sidebar_jump' => './',
                'header_break' => './',
            ]);
        }

        echo $type_rol;
    }

    public function updateData()
    {
        if (empty($_POST)) {
            echo '<script>alert("No se han recibido datos para actualizar")
         location.href = "./profile"
         </script>';
        }

        $post = [
            'name' => trim($_POST['name'] ?? ''),
            'lastname' => trim($_POST['lastname'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'user' => trim($_POST['user'] ?? ''),
            'id_actividad' => trim($_POST['id_actividad'] ?? ''),

        ];

        $rules = [
            'name' => ['required:Nombre', 'regex:name'],
            'lastname' => ['required:Apellido', 'regex:lastname'],
            'email' => ['required:Correo electrónico', 'regex:email'],
            'id_actividad' => ['required:actividad'],
            'user' => ['required:Usuario', 'regex:user'],

        ];
        $userStoreRequest = Validation::request($post, $rules);
        if ($userStoreRequest != '') {
            $this->sessionCreation('alert-danger', $userStoreRequest);
            return header('Location: ./profile');
        }
        $update_data_profile = new UserModel;
        $update_data_profile->update([
            'id_usuario' => $_SESSION['id_usuario'],
            'usuario' => $_POST['user'],
            'correo_electronico' => $_POST['email'],
            'nombre' => $_POST['name'],
            'apellido' => $_POST['lastname'],
            'id_actividad' => $_POST['id_actividad'],
        ], 'user');

        if ($update_data_profile->status) {
            $this->sessionCreation(
                'alert-success',
                'Datos actualizados correctamente.'
            );
            header('location: ./profile', true, 302);
        } else {
            if ($update_data_profile->msg != 'Nada que modificar') {
                $this->sessionCreation(
                    'alert-danger',
                   $$update_data_profile->msg ?? 'Error: No se pudo completar la operación.'
                );
            }
            header('location: ./profile', true, 302);
        }

    }
}
