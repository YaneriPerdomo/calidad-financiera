<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\indicatorModel;

class IndicatorsController extends Controller
{
   public function __construct()
   {

      AuthController::checkSession();
   }

   public function index()
   {

      return $this->view('admin.indicators');
   }

   public function Show(){
      
   }

   public function Create()
   {
      $get_graduation_categories = new indicatorModel();
      $get_graduation_categories->ShowGraduationCategories();

      return $this->view('admin.indicator', ['data' => $get_graduation_categories->data]);
   }


   public function Modify($id)
   {
      //imprimir toda la url
      $type_indicator = '';
      if(strpos($_SERVER['REQUEST_URI'], 'ingreso')){
         $type_indicator =  'ingreso';
      } else{
         $type_indicator =  'egreso';
      }

     
      $get_indicator = new indicatorModel();
      $get_indicator->ShowIndicator($id, $type_indicator);
     
      $get_graduation_categories = new indicatorModel();
      $get_graduation_categories->ShowGraduationCategories();

      return $this->view('admin.indicator', ['data' => $get_graduation_categories->data, 'indicator' => $get_indicator->data, 'type' => $type_indicator]);

      /*
      $get_indicator = new indicatorModel();
      $get_indicator->ShowIndicator($_GET['id']);

      */
   }

   public function Update($id){
      /*
      $update_indicator = new indicatorModel();
      $update_indicator->UpdateIndicator([
         'id' => $id,
         'type-indicator' => $_POST['type-indicator'] ?? '',
         'id_graduation-categorys' => $_POST['id_graduation-category'] ?? '',
         'graduation' => $_POST['graduation'] ?? '',
         'income' => $_POST['income'] ?? ''
      ]);

      return $update_indicator->status == false
         ? '<script>alert("Sucedio un error"); location.href = "./indicator/edit?id=' . $id . '"</script>'
         : '<script>alert("Indicador actualizado correctamente"); location.href = "./indicators"</script>';
      */
   }
   public function AddIndicator()
   {

      $add_indicator = new indicatorModel();
      $add_indicator->AddIndicator([
         'type-indicator' => $_POST['type-indicator'] ?? '',
         'id_graduation-categorys' => $_POST['id_graduation-category'] ?? '',
         'graduation' => $_POST['graduation'] ?? '',
         'income' => $_POST['income'] ?? ''
      ]);

      return $add_indicator->status == false
         ? '<script>alert("Sucedio un error"); location.href = "./indicator/add"</script>'
         : '<script>alert("Indicador agregado correctamente"); location.href = "./indicators"</script>';
   }
}
