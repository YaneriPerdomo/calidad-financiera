<?php

namespace App\Controllers;
use App\Controllers\AuthController;
use App\Models\indicatorModel;
 
class IndicatorsController extends Controller
{
   public function __construct(){
     
      AuthController::checkSession();
   }

   public function index()
   {
    
      return $this->view('admin.indicators');
   }
   
    public function showAddForm(){
      $get_graduation_categories = new indicatorModel();
      $get_graduation_categories->ShowGraduationCategories();

      return $this->view('admin.add-indicator', ['data' => $get_graduation_categories->data]);      
    }
    
    public function AddIndicator(){

      $add_indicator = new indicatorModel();
       $add_indicator->AddIndicator([
         'type-indicator' => $_POST['type-indicator'] ?? '',
         'id_graduation-categorys' => $_POST['id_graduation-category'] ?? '',
         'graduation' => $_POST['graduation'] ?? '',
         'income' => $_POST['income'] ?? ''
      ]);
  
       return $add_indicator->status == false
      ? '<script>alert("Sucedio un error"); location.href = "./add-indicator"</script>'
      : '<script>alert("Indicador agregado correctamente"); location.href = "./indicators"</script>';
    

    }
 
}