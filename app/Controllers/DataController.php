<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\BudgetModel;
use App\Models\dataModel;
use App\Models\indicatorModel;

class DataController extends Controller
{
    public function __construct()
    {
        AuthController::checkSession();
    }

    /*Agregar datos */
    public function store()
    {
        if (empty($_POST)) {
            echo '<script>alert("No se han recibido datos para agregar")
            location.href = "./user"
            </script>';
        }

        $value = str_replace('.', '', $_POST['value']);
        $value = str_replace(',', '.', $value);
 
        $add_data_user = new dataModel();
        $add_data_user->store([
            'type_indicator' => $_POST['type-indicator'],
            'id_graduation_category' => $_POST['id_graduation_category'],
            'id_graduation' => $_POST['id_graduation'],
            'id_insome' => $_POST['id_insome'],
            'value' => $value,
            'observations' => $_POST['observations']
        ]);

        if ($add_data_user->status == true) {
            echo '<script>alert("Datos agregados correctamente")
            location.href = "./data/1"
            </script>';
        } else {
            echo '<script>alert("Error al agregar los datos")
            location.href = "./data/1"
            </script>';
        }
    }

    public function index($page_number)
    {

        $type_rol = '';
        $url = $_SERVER['REQUEST_URI'];

       
        if (strpos($url, 'user')) {
            $type_rol = 'user';

            $get_graduation_categories = new indicatorModel();
            $get_graduation_categories->ShowGraduationCategories();
            $get_graduation_categories->GetGraduation();
            $get_insome = new indicatorModel();
            $get_insome->getInsome();

            $get_transaction = new dataModel();
            $get_transaction->showTransaction($page_number);
            $get_budget = new BudgetModel();
            $get_budget->budgetEachMonth('user');
            return $this->view('user.data', [
                'data' => $get_graduation_categories->data,
                'all_insome' => $get_insome->data_insome,
                'budget' => $get_budget->data,
                'accommodation' => $get_graduation_categories->graduantion[1],
                'services' => $get_graduation_categories->graduantion[2],
                'meal' => $get_graduation_categories->graduantion[3],
                'others' => $get_graduation_categories->graduantion[4],
                'entertainment' => $get_graduation_categories->graduantion[5],
                'debts' => $get_graduation_categories->graduantion[6],
                'HTML' => $get_transaction->HTML,
                'sidebar_jump' => '../',
                'header_break' => '../',
                'header_break_login' => '../../'
            ]);

        } else if (strpos($url, 'guest')) {
            $type_rol = 'guest';

            $get_graduation_categories = new indicatorModel();
            $get_graduation_categories->ShowGraduationCategories();
            $get_graduation_categories->GetGraduation();
            $get_insome = new indicatorModel();
            $get_insome->getInsome();

            $get_transaction = new dataModel();
            $get_transaction->showTransaction($page_number, $type_rol);
            $get_budget = new BudgetModel();
            $get_budget->budgetEachMonth($type_rol);
            return $this->view('guest.data', [
                'data' => $get_graduation_categories->data,
                'all_insome' => $get_insome->data_insome,
                'budget' => $get_budget->data,
                'accommodation' => $get_graduation_categories->graduantion[1],
                'services' => $get_graduation_categories->graduantion[2],
                'meal' => $get_graduation_categories->graduantion[3],
                'others' => $get_graduation_categories->graduantion[4],
                'entertainment' => $get_graduation_categories->graduantion[5],
                'debts' => $get_graduation_categories->graduantion[6],
                'HTML' => $get_transaction->HTML,
                'sidebar_jump' => '../',
                'header_break' => '../'
            ]);
        }

    }
}
