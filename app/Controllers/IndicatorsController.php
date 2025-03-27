<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\indicatorModel;
use FontLib\TrueType\Header;

class IndicatorsController extends Controller
{
   public function __construct()
   {

      AuthController::checkSession();
   }

   public function index($page_e = 1, $page_i = 1)
   {
      $show_indicators = new indicatorModel();
      $show_indicators->show($page_e, $page_i);

      
      return $this->view('admin.indicators', ['HTML_graduantion' => $show_indicators->HTML_graduantion,
             'HTML_insome' => $show_indicators->HTML_insome]);
   }


   public function Show() {}

   public function Create()
   {
      $get_graduation_categories = new indicatorModel();
      $get_graduation_categories->ShowGraduationCategories();
   
      return $this->view('admin.indicator', ['data' => $get_graduation_categories->data, 
      'jump_indicators' => '../']);
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
      //imprimir toda la url
      $type_indicator = '';
      $url = $_SERVER['REQUEST_URI'];
      if (strpos($url, 'ingreso')) {
         $type_indicator =  'ingreso';
      } else {
         $type_indicator =  'egreso';
      }

      preg_match_all('/\d+/', $url, $coincidencias);

      $id = implode($coincidencias[0]);

      $get_indicator = new indicatorModel();
      $get_indicator->ShowIndicator($id, $type_indicator);

      $get_graduation_categories = new indicatorModel();
      $get_graduation_categories->ShowGraduationCategories();


      return $this->view('admin.indicator', ['data' => $get_graduation_categories->data, 'indicator' =>
      $get_indicator->data, 'type' => $type_indicator, 'id' => $id,  'type_indicator', 
      'jump_indicators' => '../../']);

      /*
      $get_indicator = new indicatorModel();
      $get_indicator->ShowIndicator($_GET['id']);

      */
   }

   public function Update()
   {

      $update_indicator = new indicatorModel();
      $update_indicator->UpdateIndicator([
         'id' => $_POST['id'],
         'operation' => $_POST['operation'],
         'type-indicator' => $_POST['type-indicator'] ?? '',
         'id_graduation-categorys' => $_POST['id_graduation-category'] ?? '',
         'graduation' => $_POST['graduation'] ?? '',
         'income' => $_POST['income'] ?? ''
      ]);

      if ($update_indicator->status == true) {
         header('location: ../../indicators', true, 302);
      } else {
         $_SESSION['error_message'] = "Sucedió un error a la hora de actualizar el indicador.";
         $type = match ($_POST['type-indicator']) {
            "1" => 'ingreso',
            "2" => 'egreso',
         };
         $id = trim($_POST['id']);
         header("Location: ../../indicator/{$id}-{$type}/modify");
      }
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
         : '<script>alert("Indicador agregado correctamente"); location.href = "../indicators"</script>';
   }
}
