<?php

namespace App\Models;

use Lib\Database;
use PDO;
use PDOException;

class DashboardModel extends Database
{

  public $HTML = '';

  public $data_total_income;
  public $data_total_graduation;
  public $status = false;

  public $data_total_quote;

  public $data_each_month_total_income;

  public $data_each_month_total_graduation;

  public $data_all_income_name_value;

  public $data_total_annual_income_stmt;

  public $data_total_annual_expenses;

  public $data_annual_budget;

  public $data_ahorro;

  public $fechaCreacion;
  function __construct()
  {
    parent::__construct();
  }

  //SELECT SUM(valor_bs) FROM `transacciones` WHERE YEAR(fecha) = '2025' AND  id_egreso  IS NOT NULL;
  public function GetAnnualBudget($year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];

      $date_creation_query = 'SELECT fecha_creacion FROM usuarios WHERE id_usuario =:id_user';
      $date_creation_stmt = $this->pdo->prepare($date_creation_query);
      $date_creation_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);

      $date_creation_stmt->execute();
      $get_date_create = $date_creation_stmt->fetch(PDO::FETCH_ASSOC);
      $this->fechaCreacion = $get_date_create['fecha_creacion'];
    } else {
      $id_person = $_SESSION['id_persona'];
      $get_id_person_query = 'SELECT id_usuario FROM personas WHERE id_persona =:id_person';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_user = $row_id_person['id_usuario'];

      $date_creation_query = 'SELECT fecha_creacion FROM usuarios WHERE id_usuario =:id_user';
      $date_creation_stmt = $this->pdo->prepare($date_creation_query);
      $date_creation_stmt->bindParam('id_user', $id_user, PDO::PARAM_INT);

      $date_creation_stmt->execute();
      $get_date_create = $date_creation_stmt->fetch(PDO::FETCH_ASSOC);
      $this->fechaCreacion = $get_date_create['fecha_creacion'];



    }

    $get_annual_budget_query = 'SELECT 
                                  SUM(monto_total) AS monto_total 
                                FROM 
                                  presupuestos_ahorros
                                WHERE 
                                  year(fecha) = :year_ AND id_persona =:id_person';
    $get_annual_budget_stmt = $this->pdo->prepare($get_annual_budget_query);
    $get_annual_budget_stmt->bindParam('year_', $year, PDO::PARAM_INT);
    $get_annual_budget_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_annual_budget_stmt->execute();
    if ($get_annual_budget_stmt->rowCount() > 0) {
      $this->data_annual_budget = $get_annual_budget_stmt->fetch(PDO::FETCH_ASSOC);
    }
  }

  public function GetTotalAnnualIncome($year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $get_total_annual_income_query = 'SELECT 
                                  SUM(valor_bs) as total_ingresos_anuales 
                                FROM 
                                  `transacciones` 
                                WHERE
                                  year(fecha) = :year_ AND id_ingreso is not null AND id_persona = :id_person ';
    $get_total_annual_expenses_stmt = $this->pdo->prepare($get_total_annual_income_query);
    $get_total_annual_expenses_stmt->bindParam('year_', $year, PDO::PARAM_INT);
    $get_total_annual_expenses_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_total_annual_expenses_stmt->execute();

    if ($get_total_annual_expenses_stmt->rowCount() > 0) {
      $this->data_total_annual_income_stmt = $get_total_annual_expenses_stmt->fetch(PDO::FETCH_ASSOC);
    }
  }


  public function GetTotalAnnualExpenses($year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $get_total_annual_expenses_query = 'SELECT 
                                  SUM(valor_bs) as total_egresos_anuales 
                                FROM 
                                  `transacciones` 
                                WHERE
                                  year(fecha) = :year_ AND id_egreso is not null AND id_persona = :id_person ';
    $get_total_annual_income_stmt = $this->pdo->prepare($get_total_annual_expenses_query);
    $get_total_annual_income_stmt->bindParam('year_', $year, PDO::PARAM_INT);
    $get_total_annual_income_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_total_annual_income_stmt->execute();

    if ($get_total_annual_income_stmt->rowCount() > 0) {
      $this->data_total_annual_expenses = $get_total_annual_income_stmt->fetch(PDO::FETCH_ASSOC);
    }
  }
  public function GetAllIncomeNameValue($month, $year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $get_all_income_name_value_query = 'SELECT 
                                            ingresos.ingreso, SUM(transacciones.valor_bs) AS valor_total_bs
                                         FROM 
                                            transacciones 
                                         INNER JOIN 
                                            ingresos 
                                         ON 
                                            transacciones.id_ingreso = ingresos.id_ingreso 
                                         WHERE 
                                            id_persona = :id_person AND  YEAR(fecha) = :year_ AND  month(fecha) = :month_ AND ingresos.id_ingreso is not null 
                                         GROUP BY 
                                            ingresos.id_ingreso';
    $get_all_income_name_value_stmt = $this->pdo->prepare($get_all_income_name_value_query);
    $get_all_income_name_value_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_all_income_name_value_stmt->bindParam('year_', $year, PDO::PARAM_INT);
    $get_all_income_name_value_stmt->bindParam('month_', $month, PDO::PARAM_INT);
    $get_all_income_name_value_stmt->execute();

    if ($get_all_income_name_value_stmt->rowCount() > 0) {
      $this->data_all_income_name_value = $get_all_income_name_value_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }

  public function GetAhorroAnual($year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $get_ahorro_anual_query = 'SELECT 
                                  SUM(monto_total) AS total, fecha, porcentaje_ahorro  
                              FROM 
                                  presupuestos_ahorros 
                              WHERE 
                                  year(fecha) = :year_
                              AND 
                                  id_persona = :id_persona 
                              GROUP BY 
                                  month(fecha)';
    $get_ahorro_anual_stmt = $this->pdo->prepare($get_ahorro_anual_query);
    $get_ahorro_anual_stmt->bindParam('year_', $year, PDO::PARAM_INT);
    $get_ahorro_anual_stmt->bindParam('id_persona', $id_person, PDO::PARAM_INT);
    $get_ahorro_anual_stmt->execute();

    if ($get_ahorro_anual_stmt->rowCount() > 0) {
      return $this->data_ahorro = $get_ahorro_anual_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }
  public function GetEachMonthTotalGraduation($year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $get_each_month_total_graduation_query = 'SELECT 
                                                MONTH(fecha) 
                                              AS 
                                                mes, SUM(valor_bs) 
                                              AS 
                                                total_egreso_bs 
                                              FROM 
                                                transacciones 
                                              WHERE 
                                                id_egreso IS NOT NULL
                                              AND 
                                                id_persona = :id_person
                                              AND 
                                                YEAR(fecha) = :_year
                                              GROUP BY 
                                                mes 
                                              ORDER BY 
                                                mes; ';
    $get_each_month_total_graduation_stmt = $this->pdo->prepare($get_each_month_total_graduation_query);
    $get_each_month_total_graduation_stmt->bindParam('_year', $year, PDO::PARAM_INT);
    $get_each_month_total_graduation_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_each_month_total_graduation_stmt->execute();

    if ($get_each_month_total_graduation_stmt->rowCount() > 0) {
      $this->data_each_month_total_graduation = $get_each_month_total_graduation_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }

  public function GetEachMonthTotalIncome($year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $get_each_month_total_income_query = 'SELECT 
                                                MONTH(fecha) 
                                              AS 
                                                mes, SUM(valor_bs) 
                                              AS 
                                                total_ingresos_bs 
                                              FROM 
                                                transacciones 
                                              WHERE 
                                                id_ingreso IS NOT NULL
                                              AND 
                                                id_persona = :id_person
                                              AND 
                                                YEAR(fecha) = :_year
                                              GROUP BY 
                                                mes 
                                              ORDER BY 
                                                mes; ';
    $get_each_month_total_income_stmt = $this->pdo->prepare($get_each_month_total_income_query);
    $get_each_month_total_income_stmt->bindParam('_year', $year, PDO::PARAM_INT);
    $get_each_month_total_income_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_each_month_total_income_stmt->execute();

    if ($get_each_month_total_income_stmt->rowCount() > 0) {
      $this->data_each_month_total_income = $get_each_month_total_income_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }
  public function GetTotalIncome($month, $year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $GetTotalIncomeQuery = 'SELECT 
                            SUM(valor_bs) 
                            AS 
                            Ingresos 
                            FROM 
                            `transacciones` 
                            WHERE 
                            id_ingreso 
                            IS NOT NULL
                            AND 
                            month(fecha) = :_month 
                            AND 
                            year(fecha) = :_year
                            AND 
                            id_persona = :id_person';
    $GetTotalIncomeStmt = $this->pdo->prepare($GetTotalIncomeQuery);
    $GetTotalIncomeStmt->bindParam('_month', $month, PDO::PARAM_INT);
    $GetTotalIncomeStmt->bindParam('_year', $year, PDO::PARAM_INT);
    $GetTotalIncomeStmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $GetTotalIncomeStmt->execute();

    if ($GetTotalIncomeStmt->rowCount() > 0) {
      $this->data_total_income = $GetTotalIncomeStmt->fetch(PDO::FETCH_ASSOC);
    }
  }

  public function GetTotalGraduation($month, $year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $get_total_graduation_query = 'SELECT 
                            SUM(valor_bs) 
                            AS 
                            Egresos 
                            FROM 
                            `transacciones` 
                            WHERE 
                            id_egreso 
                            IS NOT NULL
                            AND 
                            month(fecha) = :_month 
                            AND 
                            year(fecha) = :_year
                            AND 
                            id_persona = :id_person';
    $get_total_graduation_stmt = $this->pdo->prepare($get_total_graduation_query);
    $get_total_graduation_stmt->bindParam('_month', $month, PDO::PARAM_INT);
    $get_total_graduation_stmt->bindParam('_year', $year, PDO::PARAM_INT);
    $get_total_graduation_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_total_graduation_stmt->execute();

    if ($get_total_graduation_stmt->rowCount() > 0) {
      $this->data_total_graduation = $get_total_graduation_stmt->fetch(PDO::FETCH_ASSOC);
    }
  }

  public function GetTotalQuote($month, $year, $type_rol)
  {
    if ($type_rol == 'user') {
      $get_id_person_query = 'SELECT id_persona FROM personas WHERE id_usuario =:id_user';
      $get_id_person_stmt = $this->pdo->prepare($get_id_person_query);
      $get_id_person_stmt->bindParam('id_user', $_SESSION['id_usuario'], PDO::PARAM_INT);
      $get_id_person_stmt->execute();
      $row_id_person = $get_id_person_stmt->fetch(PDO::FETCH_ASSOC);
      $id_person = $row_id_person['id_persona'];
    } else {
      $id_person = $_SESSION['id_persona'];
    }

    $get_total_quote_query = ' SELECT 
                                            monto_total 
                                        FROM 
                                            `presupuestos_ahorros` 
                                        WHERE 
                                            month(fecha) = :_month 
                                        AND 
                                            year(fecha) = :_year 
                                        AND 
                                            id_persona = :id_person';
    $get_total_quote_stmt = $this->pdo->prepare($get_total_quote_query);
    $get_total_quote_stmt->bindParam('_month', $month, PDO::PARAM_INT);
    $get_total_quote_stmt->bindParam('_year', $year, PDO::PARAM_INT);
    $get_total_quote_stmt->bindParam('id_person', $id_person, PDO::PARAM_INT);
    $get_total_quote_stmt->execute();

    if ($get_total_quote_stmt->rowCount() > 0) {
      $this->data_total_quote = $get_total_quote_stmt->fetch(PDO::FETCH_ASSOC);
    }
  }
}
