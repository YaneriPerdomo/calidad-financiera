<?php

namespace App\Controllers;

use App\Controllers\AuthController;
use App\Models\BudgetModel;
use App\Models\dataModel;
use App\Models\indicatorModel;
use PhpParser\Node\Expr\New_;
use Dompdf\Dompdf;
use public_\php\utilities;

require_once '../dompdf/autoload.inc.php';

class DataController extends Controller
{
    public function __construct()
    {
        AuthController::checkSession();
    }

    /*Agregar datos */
    public function store()
    {
        if (empty($_POST)) {
            $this->sessionCreation(
                'alert-danger',
                'No se han recibido datos para agregar'
            );
            return header('location: ./transactions/1', true, 302);
        }

        
      $post = [
         'id_graduation_category' => trim($_POST['id_graduation_category'] ?? ''),
         'value' => trim($_POST['value'] ?? ''),
         'observations' => trim($_POST['observations'] ?? ''),
      ];

      $rules = [
         //'id_graduation_category' => ['required:Nombre', 'regex:name'],
         'value' => ['required:Monto', 'regex:amount'],
         'observations' => ['nullable'],
      ];

      $userStoreRequest = Validation::request($post, $rules);

      if ($userStoreRequest != '') {
         $this->sessionCreation('alert-danger', $userStoreRequest);
         return header('Location: ./add-transaction');
      }

        if ($_POST['type-indicator'] === '2') {
            $category = match ($_POST['id_graduation_category']) {
                '1' => 'Vivienda',
                '2' => 'Servicios',
                '3' => 'Comida',
                '4' => 'Otros',
                '5' => 'Entretenimiento',
                '6' => 'Deudas'
            };
        

            if ($_POST['id_graduation'] == '') {
                $this->sessionCreation(
                    'alert-danger',
                    'Aún no hay registros disponibles para la categoría de egreso: "'.$category.'". <br> Para solicitar el registro de un nuevo indicador, por favor, comuníquese con el administrador del sistema vía Gmail.'
                );
                return header('location: ./add-transaction', true, 302);
            }
        }else{
             if ($_POST['id_insome'] == '') {
                $this->sessionCreation(
                    'alert-danger',
                    'Aún no hay registros disponibles para algun tipo de indicador de ingreso. <br> Para solicitar el registro de un nuevo indicador, por favor, comuníquese con el administrador del sistema vía Gmail.'
                );
                return header('location: ./add-transaction', true, 302);
            }
        }

        
        $value = str_replace('.', '', $_POST['value']);
        $value = str_replace(',', '.', $value);

        $add_data_user = new dataModel();
        $add_data_user->store([
            'type_indicator' => $_POST['type-indicator'],
            'id_graduation_category' => $_POST['id_graduation_category'],
            'id_graduation' => $_POST['id_graduation'],
            'id_insome' => $_POST['id_insome'],
            'value' => $value,
            'observations' => $_POST['observations']
        ]);

        if ($add_data_user->status) {
            $this->sessionCreation(
                'alert-success',
                'La transaccion ha sido registrada exitosamente'
            );
            header('location: ./transactions/1', true, 302);
        } else {
            $this->sessionCreation(
                'alert-danger',
                $add_data_user->msg ?? 'Error: No se pudo completar la operación.'
            );
            header('location: ./add-transaction', true, 302);
        }

    }

    public function index($page_number)
    {

        $type_rol = '';
        $url = $_SERVER['REQUEST_URI'];


        if (strpos($url, 'user')) {
            $type_rol = 'user';

            $get_graduation_categories = new indicatorModel();
            $get_graduation_categories->ShowGraduationCategories();
            $get_graduation_categories->GetGraduation();
            $get_insome = new indicatorModel();
            $get_insome->getInsome();

            $get_transaction = new dataModel();
            $get_transaction->showTransaction($page_number);
            $get_budget = new BudgetModel();
            $get_budget->budgetEachMonth('user');
            return $this->view('user.data', [
                'data' => $get_graduation_categories->data,
                'all_insome' => $get_insome->data_insome,
                'budget' => $get_budget->data,
                'accommodation' => $get_graduation_categories->graduantion[1],
                'services' => $get_graduation_categories->graduantion[2],
                'meal' => $get_graduation_categories->graduantion[3],
                'others' => $get_graduation_categories->graduantion[4],
                'entertainment' => $get_graduation_categories->graduantion[5],
                'debts' => $get_graduation_categories->graduantion[6],
                'HTML' => $get_transaction->HTML,
                'sidebar_jump' => '../',
                'header_break' => '../',
                'header_break_login' => '../../',


            ]);

        } else if (strpos($url, 'guest')) {
            $type_rol = 'guest';

            $get_graduation_categories = new indicatorModel();
            $get_graduation_categories->ShowGraduationCategories();
            $get_graduation_categories->GetGraduation();
            $get_insome = new indicatorModel();
            $get_insome->getInsome();

            $get_transaction = new dataModel();
            $get_transaction->showTransaction($page_number, $type_rol);
            $get_budget = new BudgetModel();
            $get_budget->budgetEachMonth($type_rol);
            return $this->view('guest.data', [
                'data' => $get_graduation_categories->data,
                'all_insome' => $get_insome->data_insome,
                'budget' => $get_budget->data,
                'accommodation' => $get_graduation_categories->graduantion[1],
                'services' => $get_graduation_categories->graduantion[2],
                'meal' => $get_graduation_categories->graduantion[3],
                'others' => $get_graduation_categories->graduantion[4],
                'entertainment' => $get_graduation_categories->graduantion[5],
                'debts' => $get_graduation_categories->graduantion[6],
                'HTML' => $get_transaction->HTML,
                'sidebar_jump' => './../',
                'header_break' => '../',
                'header_break_login' => '../../'
            ]);
        }

    }

    public function Annulment(){
        $test = new dataModel();
        $test->Annulment([
            'tipo' => $_POST['tipo'],
            'id' => $_POST['id_transaccion'],
        ]);

          if ($test->status) {
            $this->sessionCreation(
                'alert-success',
                'La transaccion ha sido anulada exitosamente'
            );
            header('location: ../transactions/1', true, 302);
        } else {
            $this->sessionCreation(
                'alert-danger',
                $add_data_user->msg ?? 'Error: No se pudo completar la operación.'
            );
            header('location: ../transactions/1', true, 302);
        }
       
    }

    public function reportData()
    {
        if ($_POST['report_format'] == 0) {
            $this->sessionCreation(
                'alert-danger__wm',
                'Error al generar el reporte de transacciones: El formato de reporte seleccionado no es válido.'
            );
            return header('location: ../transactions/1', true, 302);
        }


        if ($_POST['periodo_seleccion'] == '0') {

            if ($_POST['fecha_inicio'] == "" || $_POST['fecha_fin'] == "") {
                $this->sessionCreation(
                    'alert-danger__wm',
                    'Error al generar el reporte de transacciones: Debe especificar una Fecha de Inicio y una Fecha de Fin para el período personalizado.'
                );
                return header('location: ../transactions/1', true, 302);
            }

        }

        function generacion_fecha($valor = null)
        {
            if ($valor != null) {
                $data = substr($valor, 0, 10);
                $completion_date = explode('-', $data);
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
                return $data = $completion_date[2] . ' de ' . $monthWritten . ' de ' . $completion_date[0];
            } else {
                return 'N/A';
            }
        }

        if ($_POST['periodo_seleccion'] == '0') {
            if ($_POST['fecha_inicio'] > $_POST['fecha_fin']) {
                $this->sessionCreation(
                    'alert-danger__wm',
                    'La Fecha de Inicio no puede ser posterior a la Fecha Final. Por favor, corrija el rango de fechas.'
                );
                return header('location: ../transactions/1', true, 302);
            }
        }
        $get_report = new dataModel();
        if ($_POST['report_format'] == '1') {
            $get_report->reportData([
                'periodo_seleccion' => $_POST['periodo_seleccion'],
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin' => $_POST['fecha_fin'],
                'withIndicator' => true,
                'id_rol' => $_SESSION['id_rol']
            ]);


            $g = $get_report->data;
            if ($g == '') {
                switch ($_POST['periodo_seleccion']) {
                    case '0':
                        $this->sessionCreation(
                            'alert-danger__wm',
                            'No se encontraron transacciones en el rango de fechas seleccionado. Verifique los parámetros ingresados.'
                        );
                        return header('location: ../transactions/1', true, 302);
                        break;
                    case '1':
                        $this->sessionCreation(
                            'alert-danger__wm',
                            'No se encontraron transacciones que generaran el informe seleccionado, posiblemente porque no existe registro de ingresos ni gastos de hoy.'
                        );
                        return header('location: ../transactions/1', true, 302);
                        break;
                    case '2':
                        $this->sessionCreation(
                            'alert-danger__wm',
                            'No se encontraron transacciones que generaran el informe, posiblemente porque no existe registro de ingresos ni gastos. '
                        );
                        return header('location: ../transactions/1', true, 302);
                        break;
                    default:
                        // ...
                        break;
                }
            }

            $hora_de_hoy = generacion_fecha(date('Y-m-d'));


            $f_r = '';
            if ($_POST['periodo_seleccion'] == 0) {
                $f_r = '<span>Del ' . generacion_fecha($_POST['fecha_inicio']) . ' al ' . generacion_fecha($_POST['fecha_fin']) . ' <span>';
            }

              $filename = __DIR__ . '/../../public/img/logo.png';

            $img = "data:image/png;base64," . base64_encode(file_get_contents($filename));

            $html = '
    <head>
        <style>
            .table {
                width: 100%;
                border-collapse: collapse;
            }
                .text-line-th{
    text-decoration: line-through;
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
        ' . $f_r . '
        <div class="text-r"> ' . $hora_de_hoy . '<div>
        <div style="width: 100%;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo de indicador</th>
                        <th>Categoria</th>
                        <th>Concepto </th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody class="dataTable">
                    ' . $g . '
                </tbody>
            </table>
        </div>
    </body>
    ';

            $dompdf = new Dompdf;

            $options = $dompdf->getOptions();
            $options->set(['isRemoteEnabled' => true]);
            $dompdf->setOptions($options);

            $dompdf->loadHtml($html);

            $dompdf->setPaper('letter');

            $dompdf->render();
            $name = $_SESSION['nombre'];
            if ($_SESSION['id_rol'] == 3) {
                $name = $get_report->name ?? $_SESSION['nombre'];
            }
            $name_pdf = 'reporte_de_transacciones_' . date('d-m-Y') . '_' . $name . '.pdf';

            return $dompdf->stream($name_pdf, ['Attachment' => 1]);
        } else if ($_POST['report_format'] == '2') {
            $get_report->reportData([
                'periodo_seleccion' => $_POST['periodo_seleccion'],
                'fecha_inicio' => $_POST['fecha_inicio'],
                'fecha_fin' => $_POST['fecha_fin'],
                'withIndicator' => false,
                'id_rol' => $_SESSION['id_rol']
            ]);
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

            $f_r = '';
            if ($_POST['periodo_seleccion'] == 0) {
                $f_r = 'Del ' . generacion_fecha($_POST['fecha_inicio']) . ' al ' . generacion_fecha($_POST['fecha_fin']) . ' ';
            }
            $data = $get_report->data;

            if ($get_report->data == '') {
                switch ($_POST['periodo_seleccion']) {
                    case '0':
                        $this->sessionCreation(
                            'alert-danger__wm',
                            'No se encontraron transacciones en el rango de fechas seleccionado. Verifique los parámetros ingresados.'
                        );
                        return header('location: ../transactions/1', true, 302);
                        break;
                    case '1':
                        $this->sessionCreation(
                            'alert-danger__wm',
                            'No se encontraron transacciones que generaran el informe seleccionado, posiblemente porque no existe registro de ingresos ni gastos de hoy.'
                        );
                        return header('location: ../transactions/1', true, 302);
                        break;
                    case '2':
                        $this->sessionCreation(
                            'alert-danger__wm',
                            'No se encontraron transacciones que generaran el informe, posiblemente porque no existe registro de ingresos ni gastos. '
                        );
                        return header('location: ../transactions/1', true, 302);
                        break;
                    default:
                        // ...
                        break;
                }
            }
            $name = $_SESSION['nombre'];
            if ($_SESSION['id_rol'] == 3) {
                $name = $get_report->name ?? $_SESSION['nombre'];
            }

            $filename = 'reporte_de_transaccionces_' . date('d/m/Y') . '_' . $name . '.csv';

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');

            $output = fopen('php://output', 'w');

            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));


            fputcsv($output, ['Calidad Financiera'], ';');

            fputcsv($output, ['Fecha de Generación: ' . $formatted_date], ';');
            fputcsv($output, ['Rango de Fechas', $f_r], ';');

            fputcsv($output, [''], ';');

            $headers = ['Tipo de indicador', 'Categoria', 'Concepto', 'Monto', 'Fecha', 'Observaciones'];
            fputcsv($output, $headers, ';');

            foreach ($data as $row) {
                $monto = $monto = number_format($row['valor_bs'], 2, ',', '.');
                $created_at = generacion_fecha($row['fecha']);
                $get_egreso_o_ingreso = '';
                $get_sub_egreso = '';
                if ($row['id_egreso'] == null) {
                    $get_egreso_o_ingreso = $get_report->getInsomeOrEgresoExcel($row, 'Ingreso');
                } else {
                    $get_egreso_o_ingreso = $get_report->getInsomeOrEgresoExcel($row, 'Egreso');
                    $get_sub_egreso = $get_report->getInsomeOrEgresoExcel($row, 'categoriaEgreso');
                }
                $value_bs = $row['id_egreso'] == null ? '+' . $monto : '-' . $monto;
                $row_ = [
                    $get_egreso_o_ingreso ?? '',
                    $get_sub_egreso ?? '',
                    $value_bs ?? '',
                    $created_at ?? '',
                    $row['notas']
                ];

                fputcsv($output, $row_, ';');
            }

            fclose($output);
            exit;


        }

    }
}
