<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\DashboardModel;
use App\Models\ProfileModel;
use App\Models\UserModel;

class UserController extends Controller
{
   public function __construct()
   {

      AuthController::checkSession();
   }

   public function index( $month,$year)
   {
     
      $GetTotalIncome = new DashboardModel();
      $GetTotalIncome->GetTotalIncome($month, $year, 'user');
      $GetTotalIncome->GetTotalGraduation($month, $year, 'user');
      $GetTotalIncome->GetAllIncomeNameValue($month, $year, 'user');
      $GetTotalIncome->GetTotalQuote($month, $year, 'user');
      $GetTotalIncome->GetEachMonthTotalIncome($year, 'user');
      $GetTotalIncome->GetEachMonthTotalGraduation($year, 'user');
      $GetTotalIncome->GetTotalAnnualIncome($year, 'user');
      $GetTotalIncome->GetTotalAnnualExpenses($year, 'user');
      $GetTotalIncome->GetAnnualBudget($year, 'user');
      return $this->view('user.dashboard', ['main_jump' => './', 
      'total_income' => $GetTotalIncome->data_total_income ,
      'total_graduation' => $GetTotalIncome->data_total_graduation,
      'total_quote' => $GetTotalIncome->data_total_quote, 
      'each_month_total_income' => $GetTotalIncome->data_each_month_total_income,
      'each_month_total_graduation' => $GetTotalIncome->data_each_month_total_graduation, 
      'all_income_name_value' => $GetTotalIncome->data_all_income_name_value,
      'total_annual_income_stmt' => $GetTotalIncome->data_total_annual_income_stmt, 
      'total_annual_expenses' => $GetTotalIncome->data_total_annual_expenses, 
      'annual_budget' => $GetTotalIncome->data_annual_budget,
      'year' => $year
   ]);
   }

   //Muestra los detalles de un usuario el formulario para editar un usuario
   public function edit()
   {
      $url = $_SERVER['REQUEST_URI'];

      preg_match_all('/\d+/', $url, $coincidencias);

      $id = implode($coincidencias[0]);

      $get_user = new UserModel();
      $get_user->edit($id);

      return $this->view('admin.user-modify', [
         'data' => $get_user->data,
         'header_jump' => '../',
         'sidebar_jump' => '../'
      ]);
   }

   public function update()
   {
      $update_user = new UserModel();
      $update_user->update([
         'id_usuario' => trim($_POST['id_user']),
         'usuario' => trim($_POST['user']),
         'correo_electronico' => trim($_POST['email']),
         'nombre' => trim($_POST['name']),
         'apellido' => trim($_POST['lastname']),
         'id_actividad' => trim($_POST['id_actividad']),
         'new-password' => trim($_POST['new-password']),
         'confirm-password' => trim($_POST['confirm-password'])
      ]);

      if ($update_user->status == true) {
         echo '<script>alert("Datos actualizados correctamente")
         location.href = "../dashboard/1"
         </script>';
      } else {
         echo '<script>alert("Sucedio un error al actualizar los datos")
         location.href = "./profile"
         </script>';
      }
   }
}
