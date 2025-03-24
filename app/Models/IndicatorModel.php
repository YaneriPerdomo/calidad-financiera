<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class indicatorModel extends Database
{


   public $status = false;

  public $data;
  function __construct()
  {
    parent::__construct();
  }


  public function ShowIndicator($id, $type){
    switch ($type) {
      case 'ingreso':
            $this->data =$this->FindOneDate('ingresos', $id, 'id_ingreso', ['ingreso']);
      break;
      case 'egreso':
            $this->data =$this->FindOneDate('egresos', $id, 'id_egreso', ['id_categoria_egreso','egreso']);
      break;
      default:
        echo 'No se encontro el tipo de indicador';
      break;
    }
  }

  public function FindOneDate($table, $id, $id_field,  array $fields = ['*']){
    $fieldsString = implode(',', $fields);
    $find_query = "SELECT {$fieldsString} FROM {$table} WHERE {$id_field} = :id";
    $find_stmt = $this->pdo->prepare($find_query);
    $find_stmt->bindParam('id', $id, PDO::PARAM_INT);
    $find_stmt->execute();
    $result = $find_stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  public function ShowGraduationCategories()
  {

    try {
      $get_graduation_categories_query = 'SELECT * FROM `categorias_egreso` ORDER BY IF(id_categoria_egreso = 4, 1, 0), id_categoria_egreso; ';
      $get_graduation_categories_stmt = $this->pdo->prepare($get_graduation_categories_query);
      $get_graduation_categories_stmt->execute();
      $this->data = $get_graduation_categories_stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
      echo  $ex->getMessage();
    }
  }

  public function UpdateIndicator($POST = []){
     
      
      if (is_array($POST) ) {
        switch ($POST['type-indicator']) {
          case '1':
             $update_income_query = 'UPDATE ingresos SET ingreso = :ingreso WHERE id_ingreso = :id_ingreso';    
             $update_income_stmt = $this->pdo->prepare($update_income_query);
             $update_income_stmt->bindParam('ingreso', $POST['income'], PDO::PARAM_STR);
             $update_income_stmt->bindParam('id_ingreso', $POST['id'], PDO::PARAM_INT);
             $update_income_stmt->execute();
            
             if($update_income_stmt->rowCount()> 0){
               return $this->status = true;
             }    
          break;
          case '2':
            $update_graduation_query = 'UPDATE egresos SET egreso = :egreso WHERE id_egreso = :id_egreso';    
            $update_graduation_stmt = $this->pdo->prepare($update_graduation_query);
            $update_graduation_stmt->bindParam('egreso', $POST['graduation'], PDO::PARAM_STR);
            $update_graduation_stmt->bindParam('id_egreso', $POST['id'], PDO::PARAM_INT);
            $update_graduation_stmt->execute();
            if($update_graduation_stmt->rowCount()> 0){
              return $this->status = true;
            }  
            break;
          
        }
        
      }
  
  }

  public function AddIndicator($POST = [])
  {
    if(!isset($POST['type-indicator']) || !isset($POST['id_graduation-categorys'])  || !isset($POST['graduation']) ){
      return false;
    }
    if (is_array($POST) ) {
      $add_indicator = match ($POST['type-indicator']) {
        '1'  => $this->AddIncome($POST['income']),
        '2' => $this->AddGraduation($POST['id_graduation-categorys'], $POST['graduation']),
        default => false,
      };
      return $this->status = $add_indicator;
    }

  }

  protected function AddIncome($income)
  {
    $add_income_query = 'INSERT INTO ingresos (ingreso) VALUES (:ingreso)';
    $add_income_stmt = $this->pdo->prepare($add_income_query);
    $add_income_stmt->bindParam('ingreso', $income, PDO::PARAM_STR);
    $add_income_stmt->execute();
    return $add_income_stmt->rowCount() > 0 ? true : false;
  }

  protected function AddGraduation($id, $graduation)
  {
    $add_graduation_query = 'INSERT INTO egresos (id_categoria_egreso, egreso) VALUES (:id_categoria_egreso, :egreso)';
    $add_graduation_stmt = $this->pdo->prepare($add_graduation_query);
    $add_graduation_stmt->bindParam('id_categoria_egreso', $id, PDO::PARAM_INT);
    $add_graduation_stmt->bindParam('egreso', $graduation, PDO::PARAM_STR);
    $add_graduation_stmt->execute();
    return $add_graduation_stmt->rowCount() > 0 ? true : false;
  }
  public function __destruct()
  {
    $this->pdo = null;
  }
}
