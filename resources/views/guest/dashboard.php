<?php
function fc_number_format($number)
{
    return number_format(floatval($number), 2, ',', '.');
}
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de control | Calidad financiera</title>
    <link rel="stylesheet" href="../../../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../../../public/css/pages/_dashboard.css">
    <link rel="stylesheet" href="../../../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../../../public/css/pages/_about.css">
    <link rel="stylesheet" href="../../../../public/css/utilities.css">
    <link rel="stylesheet" href="../../../../public/css/layouts/_base.css">
    <link rel="stylesheet" href="../../../../public/css/layouts/_ico.css">
    <link rel="icon" type="image/x-icon" href="../../../../public/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php
    include '../resources/views/components/guest/header.php';
    ?>
    <main class="main main--content-login">
        <?php
        include '../resources/views/components/guest/sidebar.php';
        ?>
        <article class="style-border control-panel">
            <div class="control-panel__row row">
                <div class="col-lg-6 col-12 ">
                    <div class="row flex-center-full">
                        <div class="col-lg-6 col-12 ">
                            <div class="month">
                                <span for="month" class="form__label form__label--required"><i>Mes
                                        seleccionado</i></span><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-calendar-date"></i></span>
                                    <select select id="month" name="month" class="form-control select--month" required>
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
                                        $month_now = date('m');
                                        $month_now = str_replace('0', '', $month_now);
                                        foreach ($months as $key => $value) {
                                            if ($key == $month_now) {
                                                echo '<option value="' . $key . '" selected> ' . $value . '</option>';
                                            } else {
                                                echo '<option value="' . $key . '"> ' . $value . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <span for="month" class="form__label form__label--required"><i>Año
                                    seleccionado</i></span><br>
                            <div class="year">
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-calendar-check"></i></span>

                                    <select select id="month" name="month" class="form-control select--year" required>
                                        <?php
                                        $current_year = Date('Y');
                                        $url = $_SERVER['REQUEST_URI'];
                                        $year_selected = substr($url, -4);
                                        for ($i = substr($fechaCreacion, 0, 4); $i <= $current_year; $i++) {
                                            $selected = $year_selected == $i ? 'selected' : '';
                                            echo '<option value="' . $i . '" ' . $selected . ' > ' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 col-12 ">
                            <a href="" class="text-decoration-none button--search">Consultar</a>
                        </div>
                        <script>
                            let ItemButttonSearh = document.querySelector('.button--search');
                            let ItemSelectMonth = document.querySelector('.select--month');
                            let ItemSelectYear = document.querySelector('.select--year');

                            ItemButttonSearh.addEventListener('click', async e => {
                                e.preventDefault();
                                const monthValue = ItemSelectMonth.value == 12 || ItemSelectMonth.value == 11 || ItemSelectMonth.value == 10
                                    ? ItemSelectMonth.value : 0 + '' + ItemSelectMonth.value;
                                return window.location.href = `../${monthValue}/${ItemSelectYear.value}`;

                            })
                        </script>
                    </div>
                    <hr>
                    <div class="d-flex monthly-data-total flex-space-between">
                        <div class="monthly-data-total__block monthly-data-total--income">
                            <span class="text-blue monthly-data-total__title fs-4"><b>Ingresos <i
                                        class="bi bi-caret-up-fill  " style="color:var(--color-verde)"></i></b></span>
                            <p class="monthly-data-total__description">Total ingresos mensual</p>
                            <?php
                            $total_income_ = fc_number_format($total_income['Ingresos']);
                            echo '<data value="' . $total_income_ . '" class="text-green fs-3 monthly-data-total__value--income"><b>' . $total_income_ . ' Bs</b></data>';
                            ?>
                        </div>
                        <div class="monthly-data-total__block">
                            <span class="text-blue fs-4"><b>Egresos <i
                                        class="bi bi-caret-down-fill text-red"></i></b></span>
                            <p>Total egresos mensual</p>
                            <?php
                            $total_graduation_ = fc_number_format($total_graduation['Egresos']);
                            echo '<data value="' . $total_graduation_ . '" class="text-red fs-3 monthly-data-total__value--budget"><b>' . $total_graduation_ . ' Bs</b></data>';
                            ?>
                        </div>
                        <div class="monthly-data-total__block">
                            <span class="monthly-data-total__title"> <i class="bi bi-briefcase-fill fs-2"> </i><b>Saldo
                                    mensual</b></span><br>
                            <?php
                            $total_quote = fc_number_format($total_quote['monto_total'] ?? 0);
                            echo fc_number_format($total_income['Ingresos'] - $total_graduation['Egresos']) . ' Bs';
                            //echo '<data value="' . $total_quote . '" class="fs-4"><b>' . $total_quote . ' Bs </b></data>';
                            ?>
                        </div>
                    </div>
                    <div class="charts d-flex w-100">
                        <div class="expenses-income__current-month">
                            <hr>
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="all-income-name">
                            <hr>
                            <pre>
                                <?php

                                echo '<div style="display:none">';
                                foreach ($all_income_name_value as $value) {
                                    echo '<span data-value-bs-all-income="' . $value['valor_total_bs'] . '">' . $value['ingreso'] . '</span>';
                                }
                                echo '</div>';
                                ?>
                            </pre>
                            <canvas id="myChart4" width="400" height="100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 ">
                    <div class="d-flex gap-4 bg-blue p-3 flex-wrap">
                        <div>
                            <span class="fs-3 text-white"><b>Ingresos</b></span>
                            <p class="text-white">Ingresos Anual total</p>
                            <data
                                value="<?php echo fc_number_format($total_annual_income_stmt['total_ingresos_anuales']); ?>"
                                class="text-white fs-3">
                                <b> <?php
                                echo fc_number_format($total_annual_income_stmt['total_ingresos_anuales']);

                                ?> Bs</b></data>
                        </div>
                        <div>
                            <span class="fs-3 text-white"><b>Egresos</b></span>
                            <p class="text-white">Egresos Anual total</p>
                            <data value="<?php
                            echo fc_number_format($total_annual_expenses['total_egresos_anuales']);
                            ?>" class="text-white fs-3">
                                <b> <?php
                                echo fc_number_format($total_annual_expenses['total_egresos_anuales']);

                                ?> Bs</b></data>
                        </div>
                         
                        <div>
                            <span class="fs-3 text-white"><b>Ahorro</b></span>
                            <p class="text-white">Ahorro anual total</p>
                            <data value="<?php echo fc_number_format($total_ahorro); ?>" class="text-white fs-3">
                                <b> <?php
                                echo fc_number_format($total_ahorro);
                                ?> Bs</b></data>
                        </div>
                    </div>
                    <div class="expenses-income__every-month w-100">
                        <hr>
                        <div>
                            <span for="month" class="form__label form__label--required fs-3 text-blue"><b>Resumen de
                                    ingresos o egresos anual</b></span><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i
                                        class="bi bi-person"></i></span>
                                <select id="month" name="month" class="form-control form__select form__select--bar"
                                    required>
                                    <option value="1">Ingresos</option>
                                    <option value="2">Egresos</option>
                                </select>
                            </div>
                        </div>
                        <canvas id="myChart2"></canvas>
                        <canvas id="myChart3" style="display: none;"></canvas>
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


                        $income = [];

                        if (!empty($each_month_total_income) && is_array($each_month_total_income)) {
                            foreach ($each_month_total_income as $value) {
                                if (isset($value['mes']) && isset($value['total_ingresos_bs'])) {
                                    $mes = $value['mes'];
                                    $income[$mes] = $value['total_ingresos_bs'];
                                }
                            }
                        }
                        echo '<div style="display:none">';
                        for ($i = 1; $i <= 12; $i++) {
                            echo '<span data-month-income="' . $months[$i] . '">';
                            if (isset($income[$i]) && $income[$i] != '') {
                                echo $income[$i];
                            } else {
                                echo '0';
                            }
                            echo "</span><br>";
                        }
                        echo '</div>';

                        ?>
                    </div>


                    <?php

                    $months_ = array(
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


                    $graduation = [];

                    if (!empty($each_month_total_graduation) && is_array($each_month_total_graduation)) {
                        foreach ($each_month_total_graduation as $value) {
                            if (isset($value['mes']) && isset($value['total_egreso_bs'])) {
                                $mes = $value['mes'];
                                $graduation[$mes] = $value['total_egreso_bs'];
                            }
                        }
                    }
                    echo '<div style="display:none"  >';
                    for ($i = 1; $i <= 12; $i++) {
                        echo '<span data-month-graduation="' . $months_[$i] . '">';
                        if (isset($graduation[$i]) && $graduation[$i] != '') {
                            echo $graduation[$i];
                        } else {
                            echo '0';
                        }
                        echo "</span><br>";
                    }
                    echo '</div>';

                    ?>



                </div>
            </div>
        </article>

    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>


    <script src="../../../js/components/location_guest.js" type="module"></script>

    <script src="../../../js/cdn.js" type="module"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>