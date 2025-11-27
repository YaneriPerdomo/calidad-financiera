<?php
namespace App\Controllers;

class Validation
{

    public static function request($post = [], $rules)
    {
        ///^[0-9]{1,3}(\.[0-9]{3})*(,[0-9]{1,2})?$/
        $regex = [
            'user' =>
                [
                    'regex' => '/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ]{4,20}$/',
                    'msg' => 'El usuario no cumple con el formato. Solo permite letras, números y tildes. La longitud debe ser de 4 a 8 caracteres.<br>'
                ],
                'note' =>
                [
                    'regex' => '/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ ]{200}$/',
                    'msg' => 'Las observaciones no cumplen con el formato. Solo permite letras, números y tildes. La longitud debe ser menor o igual a  200 caracteres.<br>'
                ],
            'amount' =>
                [
                    'regex' => '/^[0-9]{1,3}(\.[0-9]{3})*(,[0-9]{1,2})?$/',
                    'msg' => 'El monto debe ser un valor numérico (bs). Tenga en cuenta que debe ingresar un máximo de 2 centavos. <br>'
                ],
                
            'name' =>
                [
                    'regex' => '/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]{0,25}$/',
                    'msg' => 'El nombre no cumple con el formato. Solo puede contener letras y tildes. La longitud debe ser de 4 a 8 caracteres.<br>'
                ],
            'lastname' =>
                [
                    'regex' => '/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]{0,25}$/',
                    'msg' => 'El apellido no cumple con el formato. Solo puede contener letras y tildes. La longitud debe ser de 4 a 8 caracteres.<br>'
                ],
            'indicator' =>
                [
                    'regex' => '/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ ]{0,25}$/',
                    'msg' => 'El indicador no cumple con el formato. Solo puede contener letras y tildes. La longitud debe ser de 4 a 25 caracteres.<br>'
                ],
            'email' =>
                [
                    'regex' => '/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
                    'msg' => 'El correo electrónico no cumple con el formato de Gmail. Asegúrese de que el dominio sea @gmail.com.<br>'
                ]
        ];

        $errorMessage = '';
        $camposRequeridos = [];
        foreach ($post as $key => $value) {
            foreach ($rules[$key] as $data) {
                $parts = explode(':', $data) ?? null;
                $rule = $parts[0];
                $param = $parts[1] ?? null;
                if ($rule === 'nullable') {
                    continue;
                }
                if ($rule === 'confirmed') {
                    if ($post[$key] != $post['confirm_password']) {
                        $errorMessage .= 'La contraseña y la confirmación no coinciden.<br>';
                        break;
                    }
                }
                if ($rule === 'required') {
                    if ($post[$key] === '') {
                        array_push($camposRequeridos, $param);
                        break;
                    }
                }
                if ($rule === 'regex') {
                    if (!preg_match($regex[$param]['regex'], $post[$key])) {
                        $errorMessage .= $regex[$param]['msg'];
                        break;
                    }
                }
            }
        }
        $ultimoIndice = count($camposRequeridos) - 1;
        if (count($camposRequeridos) > 1) {
            $listaFormateada = '';
            foreach ($camposRequeridos as $indice => $nombreCampo) {
                if ($indice == 0) {
                    $listaFormateada .= $nombreCampo;
                } else if ($indice == $ultimoIndice) {
                    $listaFormateada .= ' y ' . $nombreCampo;
                } else {
                    $listaFormateada .= ', ' . $nombreCampo;
                }
            }
        } else {
            $listaFormateada = $camposRequeridos[0] ?? '';
        }
        if (count($camposRequeridos) == 1) {
            $errorMessage .= 'El siguiente campo es obligatorio: ' . $listaFormateada;
        } else if (count($camposRequeridos) > 1) {
            $errorMessage .= 'Los siguientes campos son obligatorios: ' . $listaFormateada;
        }
        return $errorMessage;
    }
}
?>