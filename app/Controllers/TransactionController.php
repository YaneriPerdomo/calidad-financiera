<?php

namespace App\Controllers;

use App\Models\indicatorModel;

class TransactionController  extends Controller{

    
    public function __construct()
    {
        AuthController::checkSession();
    }

    public function index(){
        $get_graduation_categories = new indicatorModel();
        $get_graduation_categories->ShowGraduationCategories();
        $get_graduation_categories->GetGraduation();
        $get_insome = new indicatorModel();
        $get_insome->getInsome();


        return $this->view('user.add-transaction', [
            'data' => $get_graduation_categories->data,
            'all_insome' => $get_insome->data_insome,
            'accommodation' => $get_graduation_categories->graduantion[1],
            'services' => $get_graduation_categories->graduantion[2],
            'meal' => $get_graduation_categories->graduantion[3],
            'others' => $get_graduation_categories->graduantion[4],
            'entertainment' => $get_graduation_categories->graduantion[5],
            'debts' => $get_graduation_categories->graduantion[6],

        ]);
    }
}
