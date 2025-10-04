<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\AdminModel;
use App\Models\DashboardModel;
use App\Models\GuestModel;
use Dompdf\Dompdf;
require_once '../dompdf/autoload.inc.php';
class GuestsController extends Controller
{
   public function __construct()
   {
      AuthController::checkSession();
   }

   // Mostrar la vista principal del modulo invitados
   public function index($month, $year)
   {


      $GetTotalIncome = new DashboardModel();
      $GetTotalIncome->GetTotalIncome($month, $year, 'guest');
      $GetTotalIncome->GetTotalGraduation($month, $year, 'guest');
      $GetTotalIncome->GetAllIncomeNameValue($month, $year, 'guest');
      $GetTotalIncome->GetTotalQuote($month, $year, 'guest');
      $GetTotalIncome->GetEachMonthTotalIncome($year, 'guest');
      $GetTotalIncome->GetEachMonthTotalGraduation($year, 'guest');
      $GetTotalIncome->GetTotalAnnualIncome($year, 'guest');
      $GetTotalIncome->GetTotalAnnualExpenses($year, 'guest');
      $GetTotalIncome->GetAnnualBudget($year, 'guest');
      $GetTotalIncome->GetAllGraduationNameValue($month, $year, 'guest');
      $GetTotalIncome->GetAhorroAnual($year, 'guest');
      $sum_total_ahorro = 0;
      if ($GetTotalIncome->data_ahorro != '') {
         foreach ($GetTotalIncome->data_ahorro as $key => $value) {
            $sum_total_ahorro = $sum_total_ahorro + $value['total'] * $value['porcentaje_ahorro'] / 100;
         }
      }
      return $this->view('guest.dashboard', [
         'main_jump' => './',
         'total_ahorro' => $sum_total_ahorro,
         'total_income' => $GetTotalIncome->data_total_income,
         'total_graduation' => $GetTotalIncome->data_total_graduation,
         'total_quote' => $GetTotalIncome->data_total_quote,
         'each_month_total_income' => $GetTotalIncome->data_each_month_total_income,
         'each_month_total_graduation' => $GetTotalIncome->data_each_month_total_graduation,
         'all_income_name_value' => $GetTotalIncome->data_all_income_name_value,
         'data_all_gradation_name_value' => $GetTotalIncome->data_all_gradation_name_value,
         'total_annual_income_stmt' => $GetTotalIncome->data_total_annual_income_stmt,
         'total_annual_expenses' => $GetTotalIncome->data_total_annual_expenses,
         'annual_budget' => $GetTotalIncome->data_annual_budget,
         'fechaCreacion' => $GetTotalIncome->fechaCreacion,
         'year' => $year,
         'month' => $month,
         'sidebar_jump' => './../../',
         'header_break' => '../../',
         'header_break_login' => '../../../'
      ]);

   }

   public function searchGuest($nameUserSearch, $page)
   {
      $show_users = new GuestModel();
      $show_users->searchGuest($nameUserSearch, $page, $_SESSION['id_persona']);
      return $this->view('user.guests', [
         'HTML' => $show_users->HTML,
         'header_jump' => '../../',
         'sidebar_jump' => '../../',
         'header_break' => '../../',
         'header_break_login' => '../../../',
         'searchUsers' => true,
         'nameUser' => $nameUserSearch
      ]);
   }
   public function show($page)
   {
      $show_guests = new GuestModel();
      $show_guests->show($page, $_SESSION['id_persona']);

      return $this->view('user.guests', [
         'HTML' => $show_guests->HTML,
         'sidebar_jump' => '../',
         'header_break' => '../',
         'header_break_login' => '../../',
         'searchUsers' => false,
         'nameUser' => ''
      ]);
   }

   public function reportGuests()
   {
      $users = new GuestModel();
      $users->reportGuests($_SESSION['id_persona']);
      $value = '';
      foreach ($users->data as $data) {
         $status = $data['estado'] == 1 ? 'Activo/a' : 'Desactivado/a';
         $value .= "<tr class='show'>
                              <td>" . $data['usuario'] . "</td>
                             <td>" . $data['nombre'] . "</td>
                              <td>" . $data['apellido'] . "</td>
                               <td>" . $data['correo_electronico'] . "</td>
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
      $name_pdf = date('d-m-Y') . '-todos-los-invitados-de-' . $_SESSION['usuario'] . '.pdf';
      return $dompdf->stream($name_pdf, array("Attachment" => 1));

   }
   public function create()
   {
      return $this->view(
         'user.guest',
         [
            'sidebar_jump' => '../',
            'header_break' => '../',
            'button_back' => '../',
            'style_jump' => '../../',
            'js_jump' => '../../',
            'header_break_login' => '../../',
            'operation' => 'add',
            'title' => 'Agregar'
         ]
      );
   }

   public function OperationData()
   {
      if ($_POST['operation'] == 'update') {
         return $this->UpdateData();
      } else {
         return $this->AddData();
      }
   }

   public function UpdateData()
   {

      if (empty($_POST)) {
         echo '<script>alert("No se han recibido datos para agregar")
         location.href = "./guest"
         </script>';
      }

      if ($_POST['user'] == "" || $_POST['name'] == "" || $_POST['lastname'] == "" || $_POST['email'] == "") {
         echo '<script>alert("Por favor, rellene lo(s) campo(s)")
         location.href = "./guest/' . $_POST['id_user'] . '/modify"
         </script>';
      }

      $add_data_guest = new GuestModel();
      $add_data_guest->UpdateData([
         'id_user' => trim($_POST['id_user']),
         'id_person' => trim($_POST['id_person']),
         'user' => trim($_POST['user']) ?? 'nada',
         'name' => trim($_POST['name']),
         'lastname' => trim($_POST['lastname']),
         'email' => trim($_POST['email']) ?? NULL,
         'password' => $_POST['password'] ?? '',
         'status' => trim($_POST['status'] ?? 0)
      ]);


      return ($add_data_guest->status == true)
         ? '<script>alert("' . $add_data_guest->msg . '"); location.href = "../guest"</script>'
         : '<script>alert("Datos registrados correctamente"); location.href = "./guests/1"</script>';
   }

   public function showData($id)
   {

      $get_data_guest = new GuestModel();
      $get_data_guest->showData($id);
      return $this->view('user.guest', [
         'data' => $get_data_guest->data,
         'sidebar_jump' => '../../',
         'header_break' => '../../',
         'button_back' => '../../',
         'js_jump' => '../../../',
         'style_jump' => '../../../',
         'title' => 'Modificar',
         'operation' => 'update'
      ]);
   }

   public function AddData()
   {
      if (empty($_POST)) {
         echo '<script>alert("No se han recibido datos para agregar")
         location.href = "./add-guest"
         </script>';
      }
      $add_data_guest = new GuestModel();
      $add_data_guest->AddData([
         'user' => trim($_POST['user']),
         'name' => trim($_POST['name']),
         'lastname' => trim($_POST['lastname']),
         'email' => trim($_POST['email']) ?? NULL,
         'password' => $_POST['password'],
         'status' => trim($_POST['status'] ?? 0)
      ]);
      return $add_data_guest->status == false
         ? '<script>alert("' . $add_data_guest->msg . '"); location.href = "./guest/add"</script>'
         : '<script>alert("Datos registrados correctamente"); location.href = "./guests/1"</script>';
   }

   public function destroy()
   {
      $guest = new GuestModel();
      $guest->destroy(
         $_POST['id_usuario'],
         $_POST['id_invitado'],
      );
      return $guest->status == false
         ? '<script>alert("' . $guest->msg . '"); location.href = "./guest/add"</script>'
         : '<script>alert("Datos eliminados correctamente"); location.href = "../guests/1"</script>';
   }
}
