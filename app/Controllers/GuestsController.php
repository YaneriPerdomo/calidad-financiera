<?php

namespace App\Controllers;

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

        $GetTotalIncome = new DashboardModel;
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
            'header_break_login' => '../../../',
        ]);

    }

    public function searchGuest($nameUserSearch, $page)
    {
        $show_users = new GuestModel;
        $show_users->searchGuest($nameUserSearch, $page, $_SESSION['id_persona']);

        return $this->view('user.guests', [
            'HTML' => $show_users->HTML,
            'header_jump' => '../../',
            'sidebar_jump' => '../../',
            'header_break' => '../../',
            'header_break_login' => '../../../',
            'searchUsers' => true,
            'nameUser' => $nameUserSearch,
        ]);
    }

    public function show($page)
    {
        $show_guests = new GuestModel;
        $show_guests->show($page, $_SESSION['id_persona']);

        return $this->view('user.guests', [
            'HTML' => $show_guests->HTML,
            'sidebar_jump' => '../',
            'header_break' => '../',
            'header_break_login' => '../../',
            'searchUsers' => false,
            'nameUser' => '',
        ]);
    }

    public function reportGuests()
    {
        if ($_POST['report_format'] == 0) {
            $this->sessionCreation(
                'alert-danger__wm',
                'Error al generar el reporte de invitados: El formato de reporte seleccionado no es válido.'
            );
            return header('location: ../guests/1', true, 302);
        }
        $users = new GuestModel;
        $users->reportGuests($_SESSION['id_persona']);
        $data = $users->data;

        if ($data == '') {
            $this->sessionCreation(
                'alert-danger__wm',
                'No hay datos disponibles para generar este reporte en este momento.'
            );
            return header('location: ../guests/1', true, 302);
        }
        if ($_POST['report_format'] == 1) {
            $value = '';
            foreach ($users->data as $data) {
                $status = $data['estado'] == 1 ? 'Activo/a' : 'Desactivado/a';
                $value .= "<tr class='show'>
                              <td>" . $data['usuario'] . '</td>
                             <td>' . $data['nombre'] . '</td>
                              <td>' . $data['apellido'] . '</td>
                               <td>' . $data['correo_electronico'] . '</td>
                                 <td>' . $status . '</td>
                         </tr>';
            }

            $created_at_last_session = substr(date('Y-m-d'), 0, 10);

            $completion_date = explode('-', $created_at_last_session);

            $writtenEveryMonth = [
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
                '12' => 'Diciembre',
            ];
            $monthWritten = $writtenEveryMonth[$completion_date[1]];
            $created_at_last_session = $completion_date[2] . ' de ' . $monthWritten . ' de ' . $completion_date[0];
            $filename = __DIR__ . '/../../public/img/logo.png';
            $img = "data:image/png;base64," . base64_encode(file_get_contents($filename));
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
          <div > 
                <img src="' . $img . '" style="width:120px" >
         </div>
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

            $dompdf = new Dompdf; // Objeto domPdf

            $options = $dompdf->getOptions();
            $options->set(['isRemoteEnabled' => true]);
            $dompdf->setOptions($options);

            // Cargar el contenido HTML
            $dompdf->loadHtml($html);

            // (Opcional) Configurar el tamaño del papel, orientación, etc.
            $dompdf->setPaper('letter');

            // Renderizar el PDF
            $dompdf->render();

            // Descargar el PDF
            $name_pdf = date('d-m-Y') . '-todos-los-invitados-de-' . $_SESSION['usuario'] . '.pdf';

            return $dompdf->stream($name_pdf, ['Attachment' => 1]);
        } else {
            $date_parts = explode('-', date('Y-m-d'));
            $month_map = [
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
                '12' => 'Diciembre',
            ];
            $formatted_date = $date_parts[2] . ' de ' . $month_map[$date_parts[1]] . ' de ' . $date_parts[0];

            $filename = 'reporte_invitados_' . date('d/m/Y') . '.csv';

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');

            $output = fopen('php://output', 'w');

            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));


            fputcsv($output, ['Calidad Financiera'], ';');

            fputcsv($output, ['Fecha de Generación: ' . $formatted_date], ';');

            fputcsv($output, [''], ';');

            $headers = ['Usuario', 'Nombre', 'Apellido', 'Correo Electrónico', 'Actividad', 'Estado'];
            fputcsv($output, $headers, ';');

            foreach ($data as $data) {
                $status = $data['estado'] == 1 ? 'Activo/a' : 'Desactivado/a';

                $row = [
                    $data['usuario'] ?? '',
                    $data['nombre'] ?? '',
                    $data['apellido'] ?? '',
                    $data['correo_electronico'] ?? '',
                    $data['actividad'] ?? '',
                    $status,
                ];

                fputcsv($output, $row, ';');
            }

            fclose($output);
            exit;
        }
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
                'title' => 'Agregar',
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
        


        $post = [
            'name' => trim($_POST['name'] ?? ''),
            'lastname' => trim($_POST['lastname'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'user' => trim($_POST['user'] ?? ''),
            'password' => trim($_POST['password'] ?? ''),
            'confirm_password' => trim($_POST['confirm_password'] ?? '')
        ];

        $rules = [
            'name' => ['required:Nombre', 'regex:name'],
            'lastname' => ['required:Apellido', 'regex:lastname'],
            'email' => ['required:Correo electrónico', 'regex:email'],
            'user' => ['required:Usuario', 'regex:user'],
            'password' => [
                'nullable',
                'confirmed',
            ],
            'confirm_password' => ['nullable']
        ];
        $userStoreRequest = Validation::request($post, $rules);
        if ($userStoreRequest != '') {
            $this->sessionCreation('alert-danger', $userStoreRequest);
            return header('Location: ./guest/' . $_POST['id_user'] . '/modify');
        }

        if ($_POST['user'] == '' || $_POST['name'] == '' || $_POST['lastname'] == '' || $_POST['email'] == '') {
            $this->sessionCreation(
                'alert-danger',
                'Por favor, rellene lo(s) campo(s)'
            );
            return header('location: ./guest/' . $_POST['id_user'] . '/modify', true, 302);

        }

        $add_data_guest = new GuestModel;
        $add_data_guest->UpdateData([
            'id_user' => trim($_POST['id_user']),
            'id_person' => trim($_POST['id_person']),
            'user' => trim($_POST['user']) ?? 'nada',
            'name' => trim($_POST['name']),
            'lastname' => trim($_POST['lastname']),
            'email' => trim($_POST['email']) ?? null,
            'password' => $_POST['password'] ?? '',
            'estado' => $_POST['status'],
        ]);

      
        if ($add_data_guest->status == true) {
            $this->sessionCreation(
                'alert-success',
                'Los datos han sido actualizados correctamente.'
            );
            header('location: ./guests/1', true, 302);
        } else {
            if ($add_data_guest->msg != 'Nada que modificar') {
                $this->sessionCreation(
                    'alert-danger',
                    $add_data_guest->msg
                );     }
                header('location: ./guest/' . $_POST['id_user'] . '/modify', true, 302);
       
        }
    }

    public function changeState(){

       
        $change_state_user = new GuestModel;
        $change_state_user->changeStateGuest([
            'id_user' => trim($_POST['id_usuario_guest']),
            'state' => intval(trim($_POST['new_status'])),
        ]);

      
        if ($change_state_user->status == true) {
            $this->sessionCreation(
                'alert-success',
                'El cambio de estado se ha actualizado correctamente.'
            );
            header('location: ../guests/1', true, 302);
        } else {
            if ($change_state_user->msg != 'Nada que modificar') {
                $this->sessionCreation(
                    'alert-danger',
                    $change_state_user->msg
                );     }
                header('location: ../guests/1', true, 302);
       
        }
    }
    public function showData($id)
    {

        $get_data_guest = new GuestModel;
        $get_data_guest->showData($id);

        return $this->view('user.guest', [
            'data' => $get_data_guest->data,
            'sidebar_jump' => '../../',
            'header_break' => '../../',
            'button_back' => '../../',
            'js_jump' => '../../../',
            'style_jump' => '../../../',
            'title' => 'Modificar',
            'operation' => 'update',
        ]);
    }

    public function AddData()
    {
        if (empty($_POST)) {
            echo '<script>alert("No se han recibido datos para agregar")
         location.href = "./add-guest"
         </script>';
        }

        $status = '';
        if (isset($_POST['status'])) {
            $status = 1;
        } else {
            $status = 0;
        }

        $post = [
            'name' => trim($_POST['name'] ?? ''),
            'lastname' => trim($_POST['lastname'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'user' => trim($_POST['user'] ?? ''),
            'password' => trim($_POST['password'] ?? ''),
            'confirm_password' => trim($_POST['confirm_password'] ?? '')
        ];

        $rules = [
            'name' => ['required:Nombre', 'regex:name'],
            'lastname' => ['required:Apellido', 'regex:lastname'],
            'email' => ['required:Correo electrónico', 'regex:email'],
            'user' => ['required:Usuario', 'regex:user'],
            'password' => ['required:Contraseña', 'confirmed'],
            'confirm_password' => ['required:Confirma Contraseña']
        ];

        $userStoreRequest = Validation::request($post, $rules);

        if ($userStoreRequest != '') {
            $this->sessionCreation('alert-danger', $userStoreRequest);
            return header('Location: ./guest/add');
        }

        $add_data_guest = new GuestModel;
        $add_data_guest->AddData([
            'user' => trim($_POST['user']),
            'name' => trim($_POST['name']),
            'lastname' => trim($_POST['lastname']),
            'email' => trim($_POST['email']) ?? null,
            'password' => $_POST['password'],
            'status' => $status,
        ]);

        if ($add_data_guest->status == true) {
            $this->sessionCreation(
                'alert-success',
                'Los datos han sido registrados correctamente'
            );
            header('location: ./guests/1', true, 302);
        } else {
            $this->sessionCreation(
                'alert-danger',
                $add_data_guest->msg
            );
            return header('location: ./guest/add', true, 302);
        }

    }

    public function destroy()
    {
        $guest = new GuestModel;
        $guest->destroy(
            $_POST['id_usuario'],
            $_POST['id_invitado'],
        );

        if ($guest->status) {
            $this->sessionCreation(
                'alert-success',
                'Los datos han sido eliminados correctamente'
            );
            header('location: ../guests/1', true, 302);
        } else {
            $this->sessionCreation(
                'alert-danger',
                $guest->msg
            );
            header('location: ../guests/1', true, 302);
        }
    }
}
