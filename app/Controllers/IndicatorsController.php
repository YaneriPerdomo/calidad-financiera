<?php

namespace App\Controllers;

use App\Models\indicatorModel;

class IndicatorsController extends Controller
{
    public function __construct()
    {
        AuthController::checkSession([1]);
    }

    public function index($page_e = 1, $page_i = 1)
    {
        $show_indicators = new indicatorModel;
        $show_indicators->show($page_e, $page_i);
        return $this->view('admin.indicators', [
            'HTML_graduantion' => $show_indicators->HTML_graduantion,
            'HTML_insome' => $show_indicators->HTML_insome,
            'sidebar_jump' => '../../',
            'header_jump' => '../../',
            'header_break_login' => '../../../',
        ]);
    }

    public function deleteGraduation()
    {
        $delete_graduation = new indicatorModel;
        $delete_graduation->deleteGraduation(['id_egreso' => $_POST['id_egreso']]);
        if ($delete_graduation->status) {
            $this->sessionCreation(
                'alert-success',
                'Indicador eliminado correctamente'
            );
            header('location: ../indicators/1/1', true, 302);
        } else {
            $this->sessionCreation(
                'alert-danger',
                'Error: No se pudo completar la operación.'
            );
            header('location: ../indicators/1/1', true, 302);
        }
    }

    public function deleteInsome()
    {
        $delete_insome = new indicatorModel;
        $delete_insome->deleteinsome(['id_ingreso' => $_POST['id_ingreso']]);
        if ($delete_insome->status) {
            $this->sessionCreation(
                'alert-success',
                'Indicador eliminado correctamente'
            );
            header('location: ../indicators/1/1', true, 302);
        } else {
            $this->sessionCreation(
                'alert-danger',
                'Error: No se pudo completar la operación.'
            );
            header('location: ../indicators/1/1', true, 302);
        }
    }

    public function Create()
    {
        $get_graduation_categories = new indicatorModel;
        $get_graduation_categories->ShowGraduationCategories();
        return $this->view('admin.indicator', [
            'data' => $get_graduation_categories->data,
            'sidebar_jump' => '../',
            'header_jump' => '../',
            'js_jump' => '../../',
            'jump_indicators' => '../',
            'header_break_login' => '../../',
        ]);
    }

    public function Operation()
    {
        if ($_POST['operation'] == 'update') {
            $this->Update();
        } else {
            $this->AddIndicator();
        }
    }

    public function Modify($id)
    {
        $type_indicator = '';
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, 'ingreso')) {
            $type_indicator = 'ingreso';
        } else {
            $type_indicator = 'egreso';
        }
        preg_match_all('/\d+/', $url, $coincidencias);
        $id = implode($coincidencias[0]);
        $get_indicator = new indicatorModel;
        $get_indicator->ShowIndicator($id, $type_indicator);
        $get_graduation_categories = new indicatorModel;
        $get_graduation_categories->ShowGraduationCategories();
        return $this->view('admin.indicator', [
            'data' => $get_graduation_categories->data,
            'indicator' => $get_indicator->data,
            'type' => $type_indicator,
            'id' => $id,
            'type_indicator',
            'jump_indicators' => '../../',
            'sidebar_jump' => '../../',
            'header_jump' => '../../',
            'header_break_login' => '../../../',
            'js_jump' => '../../../',
        ]);
    }

    public function Update()
    {
        $msg = '';
        if ($_POST['type-indicator'] == 1) { // Ingreso
            if ($_POST['income'] == '') {
                $msg = 'Por favor, ingrese el nombre del indicador de ingreso correctamente.';
                $type = match ($_POST['type-indicator']) {
                    '1' => 'ingreso',
                    '2' => 'egreso',
                };
                $id = trim($_POST['id']);
                $this->sessionCreation('alert-danger', $msg);
                return header("Location: ../../indicator/{$id}-{$type}/modify");
            }
        } else {
            if ($_POST['graduation'] == '') {
                $msg = 'Por favor, ingrese el nombre del indicador de ingreso correctamente.';
                $type = match ($_POST['type-indicator']) {
                    '1' => 'ingreso',
                    '2' => 'egreso',
                };
                $id = trim($_POST['id']);
                $this->sessionCreation('alert-danger', $msg);
                return header("Location: ../../indicator/{$id}-{$type}/modify");
            }
        }
        $update_indicator = new indicatorModel;
        $update_indicator->UpdateIndicator([
            'id' => $_POST['id'],
            'operation' => $_POST['operation'],
            'type-indicator' => $_POST['type-indicator'] ?? '',
            'id_graduation-categorys' => $_POST['id_graduation-category'] ?? '',
            'graduation' => $_POST['graduation'] ?? '',
            'income' => $_POST['income'] ?? '',
        ]);
        if ($update_indicator->status == true) {
            $type = match ($_POST['type-indicator']) {
                '1' => 'Ingreso',
                '2' => 'Egreso',
            };
            $this->sessionCreation(
                'alert-success',
                $type . ' actualizado con éxito.'
            );
            header('location: ../../indicators/1/1', true, 302);
        } else {
            $type = match ($_POST['type-indicator']) {
                '1' => 'ingreso',
                '2' => 'egreso',
            };
            $id = trim($_POST['id']);
            $this->sessionCreation(
                'alert-danger',
                $update_indicator->msg ?? 'Error: No se pudo completar la operación.'
            );
            header("Location: ../../indicator/{$id}-{$type}/modify");
        }
    }

    public function AddIndicator()
    {

       
        $post = [
            'type-indicator' => trim($_POST['type-indicator'] ?? ''),
            'id_graduation-categorys' => trim($_POST['id_graduation-category'] ?? ''),
            'graduation' => trim($_POST['graduation'] ?? ''),
            'income' => trim($_POST['income'] ?? ''),
        ];

        
        $rules = [
            'type-indicator' => ['required:Tipo de indicador'],
            'graduation' => [ 'regex:indicator'],
        ];
        $userStoreRequest = Validation::request($post, $rules);
        if ($userStoreRequest != '') {
            $this->sessionCreation('alert-danger', $userStoreRequest);
            return header('Location:  ../indicator/add');
        }


        $add_indicator = new indicatorModel;
        $add_indicator->AddIndicator([
            'type-indicator' => $_POST['type-indicator'] ?? '',
            'id_graduation-categorys' => $_POST['id_graduation-category'] ?? '',
            'graduation' => $_POST['graduation'] ?? '',
            'income' => $_POST['income'] ?? '',
        ]);
        if (!$add_indicator->status) {
            $this->sessionCreation(
                'alert-danger',
                $add_indicator->msg
            );
            header('Location: ../indicator/add');
            exit();
        } else {
            $this->sessionCreation('alert-success', 'Indicador agregado correctamente');
            header('Location: ../indicators/1/1');
            exit();
        }
    }
}
