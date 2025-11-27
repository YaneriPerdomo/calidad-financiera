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
    <title>Inicio | Calidad Financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../../../public/css/components/_presentation-system-web.css">
    <link rel="stylesheet" href="../../../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../../../public/css/pages/_about.css">
    <link rel="stylesheet" href="../../../../public/css/utilities.css">
    <link rel="stylesheet" href="../../../../public/css/layouts/_base.css">
    <link rel="stylesheet" href="../../../../public/css/layouts/_ico.css">
    <link rel="stylesheet" href="../../../../public/css/pages/_dashboard.css">
    <link rel="icon" type="image/x-icon" href="../../../../public/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
    <style>

    </style>
<body>
    <?php
    include '../resources/views/components/user/header.php';
    ?>
    <main class="main main--content-login">
        <?php
        include '../resources/views/components/user/sidebar.php';
        ?>

        <article class="style-border control-panel">
            <div class="control-panel__row row">
                <div class="col-xl-6 col-12 ">
                    <div class="row flex-center-full">
                        <div class="col-xl-6 col-12 ">
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

                                        $month_now = $month;
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
                        <div class="col-xl-6 col-12 ">
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
                        <div class="monthly-data-total__block monthly-balance">
                            <span class="monthly-data-total__title"> <i class="bi bi-briefcase-fill fs-2"> </i><b>Saldo
                                    mensual</b></span><br>
                            <?php
                            $total_quote = fc_number_format($total_quote['monto_total'] ?? 0);
                            echo fc_number_format($total_income['Ingresos'] - $total_graduation['Egresos']) . ' Bs';
                            //echo '<data value="' . $total_quote . '" class="fs-4"><b>' . $total_quote . ' Bs </b></data>';
                            ?>
                        </div>
                    </div>

                    <div class="row  ">
                        <div class="expenses-income__current-month col-xl-6 col-12 ">
                            <hr>
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="col-md-6 col-12 ">
                            <hr>
                            <span for="type" class="form__label form__label--required text-blue " style="margin: button 0.3rem;"> 
                                <b>
                                    Composición de
                                    ingresos/egresos por fuente 
                                </b>
                            </span> 
                            <div class="input-group mb-3">
                                <span class="form__icon icon-composition input-group-text"><i class="bi bi-graph-up"></i></span>
                                <select id="type" name="type"
                                    class="form-control form__select form__select--bar-composition" required>
                                    <option value="1">Ingresos</option>
                                    <option value="2">Egresos</option>
                                </select>
                            </div>
                            <div class="all-income-graduation" style="display:none">
                                 <pre>
                                <?php
                                echo '<div >';
                                foreach ($all_income_name_value as $value) {
                                    echo '<span data-value-bs-all-income="' . $value['valor_total_bs'] . '">' . $value['ingreso'] . '</span>';
                                }
                                echo '</div>';
                                ?>
                                </pre>
                            </div>
                                <canvas id="myChart4" width="400" height="100"></canvas>

                            <div class="all-graduation" style="display:none">
                                 <pre>
                                <?php
                                echo '<div  >';
                                foreach ($data_all_gradation_name_value as $value) {
                                    echo '<span data-value-bs-all-gradation="' . $value['valor_total_bs'] . '">' . $value['egreso'] . '</span>';
                                }
                                echo '</div>';
                                ?>
                                </pre>
                            </div>
                                                                <canvas id="myChart5" width="400" height="100 " style="display:none"></canvas>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 ">
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
                            <span for="type" class="form__label form__label--required fs-3 text-blue"><b>Resumen Anual
                                    por Tipo de Transacción</b></span><br>
                            <div class="input-group mb-3">
                                <span class="form__icon icon-resumen-anual input-group-text"><i class="bi bi-graph-up"></i></span>
                                <select id="type" name="type" class="form-control form__select form__select--bar"
                                    required>
                                    <option value="1">Ingresos</option>
                                    <option value="2">Egresos</option>
                                </select>
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
    <?php
    include '../resources/views/components/presentation.php';
    ?>

    <script src="../../../js/components/presentation_system_web.js" type="module"></script>

    <script src="../../../js/components/location_user.js" type="module"></script>

    </script>

</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    const ctx = document.getElementById('myChart');
    const $VALUE_BUDGET = document.querySelector('.monthly-data-total__value--budget');
    const $VALUE_INCOME = document.querySelector(".monthly-data-total__value--income");

    function parseVEF(value) {
        if (typeof value === 'string') {
            return parseFloat(value.replace(/\./g, '').replace(',', '.'));
        }
        return parseFloat(value);
    }

    const canvasContainer = ctx.parentNode;

    const budgetValue = $VALUE_BUDGET ? parseVEF($VALUE_BUDGET.value) || 0 : 0;
    const incomeValue = $VALUE_INCOME ? parseVEF($VALUE_INCOME.value) || 0 : 0;

    if (budgetValue === 0 && incomeValue === 0) {
        canvasContainer.style.display = 'none';
    } else {
        // Calculate percentages
        const total = budgetValue + incomeValue;
        let percentage_expenses = 0;
        let percentage_income = 0;

        if (total > 0) {
            percentage_expenses = (budgetValue / total) * 100;
            percentage_income = (incomeValue / total) * 100;
        }

        // Initialize the doughnut chart
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Ingresos', 'Egresos'],
                datasets: [{
                    label: '',
                    data: [percentage_income, percentage_expenses],
                    backgroundColor: [
                        '#2fac2f',
                        'rgb(242, 69, 69)',
                    ],
                    borderColor: [
                        '#2fac2f',
                        'rgb(242, 69, 69)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const value = context.raw || 0;
                                return ` ${value.toFixed(2)}%`;
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Distribución de ingresos/egresos'
                    }
                }
            }
        });
    }

    const ctx3_ = document.getElementById('myChart3');
    const ctx4_ = document.getElementById('myChart4');
    const ctx2_ = document.getElementById('myChart2');

    // Parse data for the income bar chart
    const $data_month = document.querySelectorAll('[data-month-income]');
    const incomeData = Array.from($data_month).map(element => parseVEF(element.textContent));

    const miGrafico = new Chart(ctx2_, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Resumen de ingresos anual',
                data: incomeData,
                backgroundColor: ['#2fac2f'],
                borderColor: ['#2fac2f'],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: false,
                        text: 'Cantidad'
                    },
                    ticks: {
                        callback: function (value, index, values) {
                            return value.toLocaleString('es-VE', {
                                style: 'currency',
                                currency: 'VEF',
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mes'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: false,
                    text: 'Resumen de ingresos anual',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });

    // Parse data for the graduation bar chart
    const $data_month_graduation = document.querySelectorAll('[data-month-graduation]');
    const graduationData = Array.from($data_month_graduation).map(element => parseVEF(element.textContent));
    const miGrafico_ = new Chart(ctx3_, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Resumen de egresos mensual',
                data: graduationData,
                backgroundColor: ['rgb(242, 69, 69)'],
                borderColor: ['rgb(242, 69, 69)'],
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: false,
                        text: 'Cantidad'
                    },
                    ticks: {
                        callback: function (value, index, values) {
                            return value.toLocaleString('es-VE', {
                                style: 'currency',
                                currency: 'VEF',
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mes'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: false,
                    text: 'Resumen de egresos anual',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });

    const $data_value_all_income_name = document.querySelectorAll('[data-value-bs-all-income]');
    const data_all_income_name = [];
    const data_all_income_value = [];

    $data_value_all_income_name.forEach(element => {
        data_all_income_name.push(element.textContent);
        data_all_income_value.push(parseVEF(element.getAttribute('data-value-bs-all-income')));
    });

    const ctx5_ = document.getElementById('myChart5');
    const $data_value_all_gradation_name = document.querySelectorAll('[data-value-bs-all-gradation]');
    const data_all_gradation_name = [];
    const data_all_gradation_value = [];

    $data_value_all_gradation_name.forEach(element => {
        data_all_gradation_name.push(element.textContent);
        data_all_gradation_value.push(parseVEF(element.getAttribute('data-value-bs-all-gradation')));
    });

    const miGrafico_5 = new Chart(ctx5_, {
        type: 'pie',
        data: {
            labels: data_all_gradation_name,
            datasets: [{
                label: '',
                data: data_all_gradation_value,
                borderColor: ['white'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                colors: {
                    forceOverride: true
                },
                title: {
                    display: true,
                    text: 'Composición de egresos por fuente'
                }
            }
        }
    });

    const miGrafico_4 = new Chart(ctx4_, {
        type: 'pie',
        data: {
            labels: data_all_income_name,
            datasets: [{
                label: '',
                data: data_all_income_value,
                borderColor: ['white'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                colors: {
                    forceOverride: true
                },
                title: {
                    display: true,
                    text: 'Composición de ingresos por fuente'
                }
            }
        }
    });

    const $FORM_SELECT_BAR = document.querySelector('.form__select--bar');
    const $ICON_COMPOSITION =  document.querySelector('.icon-composition > i');
    const $ICON_RESUMEN_ANUAL = document.querySelector('.icon-resumen-anual > i');
    $FORM_SELECT_BAR.addEventListener('change', e => {
        const value_selected = e.target.value;
        switch (value_selected) {
            case '1':
                $ICON_RESUMEN_ANUAL.setAttribute('class',  'bi bi-graph-up');
                ctx3_.style.display = 'none';
                ctx2_.removeAttribute('style');
                break;
            case '2':
                $ICON_RESUMEN_ANUAL.setAttribute('class', 'bi bi-graph-down' );
                ctx2_.style.display = 'none';
                ctx3_.removeAttribute('style');
                break;
            default:
                break;
        }
    });

    const $FORM_SELECT_BAR_COMPOSITION = document.querySelector('.form__select--bar-composition');
      $FORM_SELECT_BAR_COMPOSITION.addEventListener('change', e => {
        const value_selected = e.target.value;
        switch (value_selected) {
            case '1':
                ctx5_.style.display = 'none';
                $ICON_COMPOSITION.setAttribute('class', 'bi bi-graph-up');
                ctx4_.removeAttribute('style');
                break;
            case '2':
                $ICON_COMPOSITION.setAttribute('class', 'bi bi-graph-down')
                ctx4_.style.display = 'none';
                ctx5_.removeAttribute('style');
                break;
            default:
                break;
        }
    });
</script>

<script src="../../../js/cdn.js" type="module"></script>

</html>