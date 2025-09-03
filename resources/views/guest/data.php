<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datos | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../../public/css/components/_table.css">
    <link rel="stylesheet" href="../../../public/css/components/_pagination.css">
    <link rel="stylesheet" href="../../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../../public/css/pages/_about.css">
    <link rel="stylesheet" href="../../../public/css/utilities.css">
    <link rel="stylesheet" href="../../../public/css/components/_presentation-system-web.css">
    <link rel="stylesheet" href="../../../public/css/layouts/_ico.css">
    <link rel="icon" type="image/x-icon" href="../../../public/img/logo.ico">
    <link rel="stylesheet" href="../../../public/css/layouts/_base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    include '../resources/views/components/user/header.php';
    ?>
    <main class="main ">
        <?php
        include '../resources/views/components/guest/sidebar.php';
        ?>
        <article class="style-border">
            <div class="row ">
                <div class="col-lg-6 col-12">
                    <div class="flex-space-between ">
                        <h1 class="fs-3"><strong>Transacciones</strong></h1>
                    </div>
                    <section class='table'>
                        <table class='dataTable'>
                            <thead>
                                <tr>
                                    <th>Tipo de indicador</th>
                                    <th>Categoria</th>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Fecha</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <?php
                            echo $HTML;
                            ?>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="main__budget ">
                        <div class="flex-space-between ">
                            <h2 class="fs-3"><b>Presupuesto y Ahorro</b></h2>
                            <div class="meta meta--budget-year">
                                <span class="meta__title">
                                    <i>
                                        Año: <?php
                                        //fecha actual
                                        $ano_actual = date('Y');
                                        echo $ano_actual
                                            ?>
                                    </i>
                                </span>
                            </div>
                        </div>
                        <section class='table'>
                            <table class='dataTable'>
                                <thead>
                                    <tr>
                                        <th>Mes</th>
                                        <th>Ingreso</th>
                                        <th>Porcentaje de Ahorro</th>
                                        <th>Valor de ahorro</th>
                                    </tr>
                                </thead>
                                <?php

                                $months = array(
                                    1 => 'Enero',
                                    2 => 'Febrero',
                                    3 => 'Marzo',
                                    4 => 'Abril',
                                    5 => 'Mayo',
                                    6 => 'Junio',
                                    7 => 'Julio',
                                    8 => 'Agosto',
                                    9 => 'Septiembre',
                                    10 => 'Octubre',
                                    11 => 'Noviembre',
                                    12 => 'Diciembre'
                                );

                                $presupuesto = array_fill(1, 12, ''); // Más eficiente que escribir manualmente
                                $ahorro = array_fill(1, 12, '');
                                $id_presupuesto_ahorro = array_fill(1, 12, '');
                                $count = 0;
                                $test = '';
                                $array = [];
                                $count = 0;

                                if ($budget != '') {
                                    foreach ($budget as $value) {
                                        $mes = $value['mes']; // Asume que $value['mes'] es un número (0-11)
                                        if (isset($presupuesto[$mes])) { // Verifica si la clave existe
                                            $presupuesto[$mes] = $value['monto_total'];
                                            $ahorro[$mes] = $value['porcentaje_ahorro'];
                                            $id_presupuesto_ahorro[$mes] = $value['id_presupuesto_ahorro'];
                                        }
                                    }
                                }


                                for ($i = 1; $i <= 12; $i++) {
                                    echo "<tr class='show'>";
                                    echo "<td>" . $months[$i] . "</td>";
                                    if ($presupuesto[$i] == '') {
                                        echo "<td> No disponible</td>";
                                    } else {
                                        echo "<td>" . number_format($presupuesto[$i], 2, ',', '.') . ' Bs.' . "</td>";
                                    }
                                    if ($ahorro[$i] == '') {
                                        echo "<td> No disponible</td>";
                                    } else {
                                        echo "<td>
                                                <div class='input-group'>
                                                    <span class='input-group-text form__icon'><i class='bi bi-piggy-bank'></i></span>
                                                    <select name='ahorro'disabled
                                                        class=' form-control form__input form__input--select' required>
                                                        <option value='' >
                                                            Seleccione una opcion
                                                        </option>
                                                </div>";
                                        for ($j = 0; $j <= 100; $j++) {
                                            if ($ahorro[$i] == $j) {
                                                echo "<option value='$j'selected data-id='$id_presupuesto_ahorro[$i]'>$ahorro[$i]%</option>";
                                            } else {
                                                echo "<option value='$j' data-id='$id_presupuesto_ahorro[$i]'>  $j% </option>";
                                            }
                                        }
                                        echo "</td>";
                                    }
                                    if ($ahorro[$i] == '') {
                                        echo "<td> No disponible</td>";
                                    } else {
                                        $paso_ahorro = $presupuesto[$i] * $ahorro[$i] / 100;
                                        echo "<td>" . number_format($paso_ahorro, 2, ',', '.') . ' Bs.' . "</td>";
                                    }
                                    echo '</tr>';
                                }
                                ?>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </article>

        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>
    <?php
    include '../resources/views/components/presentation.php';
    ?>

    <script src="../../js/components/presentation_system_web.js" type="module"></script>
    <script src="../../js/components/location_guest.js" type="module"></script>
    <script src="../../js/cdn.js" type="module"></script>
 
</body>

</html>