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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../../../public/css/pages/_about.css">
    <link rel="stylesheet" href="../../../../public/css/utilities.css">
    <link rel="stylesheet" href="../../../../public/css/layouts/_base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .monthly-data-total__block:nth-child(3) {
            padding: 1rem;
            background: var(--color-verde);
            color: white;
        }

        .text-blue {
            color: var(--color-azul)
        }

        .text-red {
            color: var(--color-rojo);
        }

        .text-green {
            color: var(--color-verde);
        }

        .charts {
            max-width: 100%;
            gap: 1rem;
        }

        p {
            margin: 0;
        }

        .bg-blue {
            background-color: var(--color-azul);
        }
    </style>

</head>

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
                <div class="col-6">
                    <div class="row flex-center-full">
                        <div class="col-6">
                            <div class="month">
                                <span for="month" class="form__label form__label--required"><i>Mes
                                        seleccionado</i></span><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-calendar-date"></i></span>
                                    <select select id="month" name="month" class="form-control form__select" required>
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
                            <div class="year">
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-calendar-check"></i></span>
                                    <select select id="month" name="month" class="form-control form__select" required>
                                        <?php
                                        $old_year_for = 20;
                                        $start_year = 2020;
                                        $current_year = substr(date('Y'), 2);
                                        $url = $_SERVER['REQUEST_URI'];
                                        $year_selected = substr($url, -4);

                                        for ($i = $old_year_for; $i <= $current_year; $i++) {

                                            $selected = $old_year_for . $i == $year_selected ? 'selected' : '';
                                            echo '<option value="20' . $i . '" ' . $selected . ' > 20' . $i . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                $url = $_SERVER['REQUEST_URI'];
                                $year_selected = substr($url, -4);
                                ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="" class="text-decoration-none">Consultar</a>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex monthly-data-total flex-space-between">
                        <div class="monthly-data-total__block monthly-data-total--income">
                            <span class="text-blue monthly-data-total__title fs-4"><b>Ingresos <i
                                        class="bi bi-caret-up-fill text-green"></i></b></span>
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
                            echo fc_number_format($total_income['Ingresos'] - $total_graduation['Egresos']);
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
                <div class="col-6">
                    <div class="d-flex gap-4 bg-blue p-3">
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
                            <span class="fs-3 text-white"><b>Presupuesto</b></span>
                            <p class="text-white">Presupuesto anual total</p>
                            <data value="<?php echo fc_number_format($annual_budget['monto_total']); ?>"
                                class="text-white fs-3">
                                <b> <?php
                                echo fc_number_format($annual_budget['monto_total']);
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


    <script src="../../../js/components/location_user.js" type="module"></script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('myChart');
    const $VALUE_BUDGET = document.querySelector('.monthly-data-total__value--budget');
    const $VALUE_INCOME = document.querySelector(".monthly-data-total__value--income");

    // Verificar que los elementos existen y tienen valores
    let budgetValue = $VALUE_BUDGET ? parseFloat($VALUE_BUDGET.value) || 0 : 0;
    let incomeValue = $VALUE_INCOME ? parseFloat($VALUE_INCOME.value) || 0 : 0;

    // Calcular porcentajes con manejo de división por cero
    let percentage_expenses = 0;
    let percentage_income = 100;

    if (incomeValue > 0) {
        percentage_expenses = (budgetValue / incomeValue) * 100;
        percentage_income = 100 - percentage_expenses;
    }

    // Asegurarse que los porcentajes estén entre 0 y 100
    percentage_expenses = Math.min(100, Math.max(0, percentage_expenses));
    percentage_income = Math.min(100, Math.max(0, percentage_income));
    const ctx_ = new Chart(ctx, {
        type: 'doughnut', // Tipo de gráfico
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
                            const label = context.label || ''; // "Ingresos" o "Egresos"
                            const value = context.raw || 0; // El valor numérico (ej: 40)
                            return ` ${value.toFixed(2)}%`; // Formato: "Ingresos: 40.00%"
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


    const ctx3_ = document.getElementById('myChart3');
    const ctx4_ = document.getElementById('myChart4');
    const ctx2_ = document.getElementById('myChart2');
    let $data_month = document.querySelectorAll('[data-month-income]');
    console.info($data_month[3].textContent)
    const miGrafico = new Chart(ctx2_, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Resumen de ingresos anual', // Puedes cambiar la etiqueta
                data: [$data_month[0].textContent,
                $data_month[1].textContent,
                parseFloat($data_month[2].textContent),
                $data_month[3].textContent,
                $data_month[4].textContent,
                $data_month[5].textContent,
                $data_month[6].textContent,
                $data_month[7].textContent,
                $data_month[8].textContent,
                $data_month[9].textContent,
                $data_month[10].textContent,
                $data_month[11].textContent,

                ], // Aquí van tus datos
                backgroundColor: ['#2fac2f',], // Color de las barras
                borderColor: ['#2fac2f',], // Color del borde de las barras
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true, // Inicia el eje Y en 0
                    title: {
                        display: false,
                        text: 'Cantidad' // Etiqueta del eje Y
                    },
                    ticks: {
                        callback: function (value, index, values) {
                            return value.toLocaleString('es-VE', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mes' // Etiqueta del eje X
                    }
                }
            },
            plugins: {
                legend: {
                    display: true, // Muestra la leyenda
                    position: 'top' // Posición de la leyenda (top, bottom, left, right)
                },
                title: {
                    display: false,
                    text: 'Resumen de ingresos anual', // Título del gráfico
                    font: {
                        size: 16
                    }
                }
            }
        }
    });

    let $data_month_graduation = document.querySelectorAll('[data-month-graduation]');
    const miGrafico_ = new Chart(ctx3_, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Resumen de egresos mensual', // Puedes cambiar la etiqueta
                data: [$data_month_graduation[0].textContent,
                $data_month_graduation[1].textContent,
                parseFloat($data_month_graduation[2].textContent),
                $data_month_graduation[3].textContent,
                $data_month_graduation[4].textContent,
                $data_month_graduation[5].textContent,
                $data_month_graduation[6].textContent,
                $data_month_graduation[7].textContent,
                $data_month_graduation[8].textContent,
                $data_month_graduation[9].textContent,
                $data_month_graduation[10].textContent,
                $data_month_graduation[11].textContent,

                ], // Aquí van tus datos
                backgroundColor: ['rgb(242, 69, 69)',

                ], // Color de las barras
                borderColor: [
                    'rgb(242, 69, 69'
                ], // Color del borde de las barras
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true, // Inicia el eje Y en 0
                    title: {
                        display: false,
                        text: 'Cantidad' // Etiqueta del eje Y
                    },
                    ticks: {
                        callback: function (value, index, values) {
                            return value.toLocaleString('es-VE', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mes' // Etiqueta del eje X
                    }
                }
            },
            plugins: {
                legend: {
                    display: true, // Muestra la leyenda
                    position: 'top' // Posición de la leyenda (top, bottom, left, right)
                },
                title: {
                    display: false,
                    text: 'Resumen de egresos anual', // Título del gráfico
                    font: {
                        size: 16
                    }
                }
            }
        }
    });

    let $data_value_all_income_name = document.querySelectorAll('[data-value-bs-all-income]');

    let data_all_income_name = [];
    let data_all_income_value = [];
    $data_value_all_income_name.forEach(element => {
        data_all_income_name.push(element.textContent)
    })

    $data_value_all_income_name.forEach(element => {
        data_all_income_value.push(element.getAttribute('data-value-bs-all-income'))
    })

    console.info(data_all_income_name)
    const miGrafico_4 = new Chart(ctx4_, {
        type: 'pie', // Tipo de gráfico
        data: {
            labels: data_all_income_name,
            datasets: [{
                label: '',
                data: data_all_income_value,

                borderColor: [
                    'white',
                ],
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
                    display: false,
                    text: 'Ejemplo de Gráfico de Pastel'
                }
            }
        }
    });



    const $FORM_SELECT_BAR = document.querySelector('.form__select--bar');
    $FORM_SELECT_BAR.addEventListener('change', e => {
        let value_selected = e.target.value;
        console.info(value_selected)
        switch (value_selected) {
            case '1':
                ctx3_.style.display = 'none'
                ctx2_.removeAttribute('style');
                break;
            case '2':
                ctx2_.style.display = 'none'
                ctx3_.removeAttribute('style');
                break;

            default:
                break;
        }
    })
</script>

</html>