<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\AdminModel;
use App\Models\DashboardModel;
use App\Models\ProfileModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
require_once '../dompdf/autoload.inc.php';


class UserController extends Controller
{
   public function __construct()
   {

      AuthController::checkSession();
   }

   public function index($month, $year)
   {

      $GetTotalIncome = new DashboardModel();
      $GetTotalIncome->GetTotalIncome($month, $year, 'user');
      $GetTotalIncome->GetTotalGraduation($month, $year, 'user');
      $GetTotalIncome->GetAllIncomeNameValue($month, $year, 'user');
      $GetTotalIncome->GetTotalQuote($month, $year, 'user');
       $GetTotalIncome->GetAllGraduationNameValue($month, $year, 'user');
      $GetTotalIncome->GetEachMonthTotalIncome($year, 'user');
      $GetTotalIncome->GetEachMonthTotalGraduation($year, 'user');
      $GetTotalIncome->GetTotalAnnualIncome($year, 'user');
      $GetTotalIncome->GetTotalAnnualExpenses($year, 'user');
      $GetTotalIncome->GetAnnualBudget($year, 'user');
      $GetTotalIncome->GetAhorroAnual($year, 'user');
      $sum_total_ahorro = 0;
       
      if ($GetTotalIncome->data_ahorro != '') {
         foreach ($GetTotalIncome->data_ahorro as $key => $value) {
            $sum_total_ahorro = $sum_total_ahorro + $value['total'] * $value['porcentaje_ahorro'] / 100;
         }
      }
 

      return $this->view('user.dashboard', [
         'main_jump' => './',
         'total_ahorro' => $sum_total_ahorro,
         'total_income' => $GetTotalIncome->data_total_income,
         'total_graduation' => $GetTotalIncome->data_total_graduation,
         'total_quote' => $GetTotalIncome->data_total_quote,
         'each_month_total_income' => $GetTotalIncome->data_each_month_total_income,
         'each_month_total_graduation' => $GetTotalIncome->data_each_month_total_graduation,
         'all_income_name_value' => $GetTotalIncome->data_all_income_name_value,
         'total_annual_income_stmt' => $GetTotalIncome->data_total_annual_income_stmt,
         'total_annual_expenses' => $GetTotalIncome->data_total_annual_expenses,
         'annual_budget' => $GetTotalIncome->data_annual_budget,
         'month' => $month,
         'data_all_gradation_name_value' => $GetTotalIncome->data_all_gradation_name_value,
         'fechaCreacion' => $GetTotalIncome->fechaCreacion,
         'year' => $year,
         'sidebar_jump' => '../../',
         'header_break_login' => '../../../',
         'header_break' => '../../'

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
         'header_break_login' => '../../',
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
         'confirm-password' => trim($_POST['confirm-password']),
         'status' => trim($_POST['status'] ?? 0)
      ]);


      if ($update_user->status == true) {
         echo '<script>alert("Datos actualizados correctamente")
         location.href = "../users/1"
         </script>';
      } else {
         echo '<script>alert("Sucedio un error al actualizar los datos")
         location.href = "./profile"
         </script>';
      }
   }

   public function deleteAccount()
   {

      $update_user = new UserModel();
      $update_user->deleteAccount();
      if ($update_user->status == true) {
         echo '<script>alert("Cuenta eliminada exitosamente, ya no podra ingresa a esta cuenta")
         location.href = "../login"
         </script>';
      } else {
         echo '<script>alert("Sucedio un error al actualizar los datos")
         location.href = "../user"
         </script>';
      }
   }

   public function reportUsers()
   {

      // Contenido HTML
      $users = new AdminModel();
      $users->reportUsers();
      $value = '';
      foreach ($users->users as $data) {
         $status = $data['estado'] == 1 ? 'Activo/a' : 'Desactivado/a';
         $value .= "<tr class='show'>
                              <td>" . $data['usuario'] . "</td>
                             <td>" . $data['nombre'] . "</td>
                              <td>" . $data['apellido'] . "</td>
                               <td>" . $data['correo_electronico'] . "</td>
                                <td>" . $data['actividad'] . "</td>
                                 <td>" . $status . "</td>
                         </tr>";
      }

      $created_at_last_session = substr(date('Y-m-d'), 0, 10);

      $completion_date = explode('-', $created_at_last_session);

      $writtenEveryMonth = array(
         '01' => 'Enero',
         '02' => 'Febrero',
         '03' => 'Marzo',
         '04' => 'Abril',
         '05' => 'Mayo',
         '06' => 'Junio',
         '07' => 'Julio',
         '08' => 'Agosto',
         '09' => 'Septiembre',
         '10' => 'Octubre',
         '11' => 'Noviembre',
         '12' => 'Diciembre'
      );

      $monthWritten = $writtenEveryMonth[$completion_date[1]];

      $created_at_last_session = $completion_date[2] . ' de ' . $monthWritten . ' de ' . $completion_date[0];
      // Contenido HTML
      $html = '
    <head>
        <style>
            .table {
                width: 100%;
                border-collapse: collapse;
            }

            thead > tr > th {
                background: rgb(55, 139, 170)  ;
                color:white;
                text-align: left;
            }

            .table th, .table td {
                padding: 8px;
            }

            .dataTable tr:nth-child(2n+1) {
                background: rgba(0, 0, 0, 0.07);
            }

            .text-r{
                text-align: right;
            }
        </style>
    </head>
    <body>
        <strong> Calidad Financiera </strong>
        <div class="text-r"> ' . $created_at_last_session . '<div>
        <div style="width: 100%;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Apellido </th>
                        <th>Correo electronico</th>
                        <th>Actividad</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody class="dataTable">
                    ' . $value . '
                </tbody>
            </table>
        </div>
    </body>
    ';




      $dompdf = new Dompdf(); //Objeto domPdf

      $options = $dompdf->getOptions();
      $options->set(array('isRemoteEnabled' => true));
      $dompdf->setOptions($options);

      // Cargar el contenido HTML
      $dompdf->loadHtml($html);

      // (Opcional) Configurar el tamaño del papel, orientación, etc.
      $dompdf->setPaper('letter');

      // Renderizar el PDF
      $dompdf->render();

      // Descargar el PDF
      $name_pdf = date('d-m-Y') . '-todos-los-usuarios.pdf';
      return $dompdf->stream($name_pdf, array("Attachment" => 1));

   }

   public function destroy()
   {

      $user = new UserModel();
      $user->destroy($_POST['id_persona'], $_POST['id_usuario']);
      if ($user->status == true) {
         echo '<script>alert("Datos actualizados correctamente")
         location.href = "../users/1"
         </script>';
      } else {
         echo '<script>alert("' . $user->msg . '")
         location.href = "../users/1"
         </script>';
      }

   }

}
