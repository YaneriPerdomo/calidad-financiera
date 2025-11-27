<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\AhorroModel;
use App\Models\BudgetModel;
use App\Models\ChangesPassword;
use App\Models\ChangesPasswordModel;
use App\Models\dataModel;
use App\Models\indicatorModel;
use App\Models\ProfileAdminModel;
use App\Models\ProfileModel;
use App\Models\UserModel;

class AhorroController extends Controller
{
   public function __construct()
   {
      AuthController::checkSession();
   }

   public function store($porcentaje, $id){
    
    $update_ahorro = new AhorroModel();
    $update_ahorro->update($porcentaje, $id);
    if($update_ahorro->status == true){
        return 'bien hecho';
    }else{
        return 'mal hecho';
    }
   }

     public function index()
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
            $get_budget = new BudgetModel();
            $get_budget->budgetEachMonth('user');

          
            return $this->view('user.sudgeting-and-savings', [
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
                'sidebar_jump' => './',
                'header_break' => './',
                'header_break_login' => '../',


            ]);

        } else if (strpos($url, 'guest')) {
            $type_rol = 'guest';

            $get_graduation_categories = new indicatorModel();
            $get_graduation_categories->ShowGraduationCategories();
            $get_graduation_categories->GetGraduation();
            $get_insome = new indicatorModel();
            $get_insome->getInsome();

            $get_transaction = new dataModel();
            $get_budget = new BudgetModel();
            $get_budget->budgetEachMonth($type_rol);
            return $this->view('guest.sudgeting-and-savings', [
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
                'sidebar_jump' => './',
                'header_break' => './',
                'header_break_login' => '../'
            ]);
        }

    }


   
}
