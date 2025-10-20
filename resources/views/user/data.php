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
    <link rel="stylesheet" href="../../../public/css/layouts/_ico.css">
    <link rel="stylesheet" href="../../../public/css/utilities.css">
    <link rel="stylesheet" href="../../../public/css/layouts/_base.css">
    <link rel="stylesheet" href="../../../public/css/components/_presentation-system-web.css">

    <link rel="icon" type="image/x-icon" href="../../../public/img/logo.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    include '../resources/views/components/user/header.php';
    ?>
    <main class="main ">
        <?php
        include '../resources/views/components/user/sidebar.php';
    ?>
        <article class="style-border">
            <div class="row ">
                <div class="col-lg-6 col-12 ">
                    <div class="flex-space-between ">
                        <h1 class="fs-3"><strong>Transacciones</strong></h1>
                        <div class="">
                            <button type="button" class="button--orange" title="Agregar indicador">
                                <a href="./../add-transaction" class="text-decoration-none text-white">+ Agregar
                                    transaccion</a>
                            </button>
                        </div>
                    </div>
                       <?php
                if (isset($_SESSION['alert-danger'])) {
                    echo '
                        <div class="alert alert-danger" role="alert">
                            '.$_SESSION['alert-danger'].'
                        </div>';
                    unset($_SESSION['alert-danger']);
                }
    ?>
                <?php
        if (isset($_SESSION['alert-success'])) {
            echo '
                            <div class="alert alert-success" role="alert">
                                '.$_SESSION['alert-success'].' </div>';
            unset($_SESSION['alert-success']);
        }
    ?>
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
                <div class="col-lg-6 col-12 ">
                    <div class="main__budget ">
                        <div class="flex-space-between ">
                            <h2 class="fs-3"><b>Presupuesto y Ahorro</b></h2>
                            <div class="meta meta--budget-year">
                                <span class="meta__title">
                                    <i>
                                        Año: <?php
                // fecha actual
                $ano_actual = date('Y');
    echo $ano_actual
    ?>
                                    </i>
                                </span>
                            </div>
                            <!---<div style="  align-self: start;">
                                <button class="button--orange">
                                    <a href="../data/add-ahorro" class="text-decoration-none text-white">
                                        + Agregar porcentaje de ahorro
                                    </a>
                                </button>
                            </div>--->
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

                                $months = [
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
                                    12 => 'Diciembre',
                                ];

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
        echo '<td>'.$months[$i].'</td>';
        if ($presupuesto[$i] == '') {
            echo '<td> No disponible</td>';
        } else {
            echo '<td>'.number_format($presupuesto[$i], 2, ',', '.').' Bs.'.'</td>';
        }
        if ($ahorro[$i] == '') {
            echo '<td> No disponible</td>';
        } else {
            echo "<td>
                                                <div class='input-group'>
                                                    <span class='input-group-text form__icon'><i class='bi bi-piggy-bank'></i></span>
                                                    <select name='ahorro'
                                                        class=' form-control form__input form__input--select' required>
                                                        <option value='' disabled>
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
            echo '</td>';
        }
        if ($ahorro[$i] == '') {
            echo '<td> No disponible</td>';
        } else {
            $paso_ahorro = $presupuesto[$i] * $ahorro[$i] / 100;
            echo '<td>'.number_format($paso_ahorro, 2, ',', '.').' Bs.'.'</td>';
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

    <script>
        document.addEventListener('change', async e => {
            if (e.target.matches("[name='ahorro']")) {
                console.info(e.target.selectedOptions[0].getAttribute('data-id'))
                let dataId = e.target.selectedOptions[0].getAttribute('data-id') ?? 0;
                try {
                    const response = await fetch(`../data/add-number-ahorro/${e.target.value}/${dataId}`, {
                        method: 'POST',
                        headers: {
                            Accept: "application/text",
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            value: e.target.value,

                        }),
                    });
                    if (!response.ok) {
                        const errorText = await response.text();
                        let errorMessage = `Error HTTP: ${response.status}`;
                        try {
                            const errorJson = JSON.parse(errorText);
                            errorMessage = errorJson.message || errorText;
                        } catch (e) {
                            errorMessage =
                                errorText || "Error desconocido en el servidor.";
                        }
                        throw new Error(errorMessage);
                    }
                    const data = await response.text();
                    if (data == 'bien hecho') {
                        window.location.href = '../data/1';
                    } else {
                        alert('Sucedio un error')
                    }
                } catch (error) {
                    console.error("Error en la búsqueda de cliente:", error);
                    alert(
                        `No se pudo buscar el cliente: ${error.message || "Ocurrió un error inesperado."
                        }`
                    );
                }
            }
        })
    </script>
    <script>
        let $TYPE_INDICATOR_SELECT = document.querySelector('#type-indicator');
        let $GRADUATION_GROUP = document.querySelector('.graduation-group');
        let $INCOME = document.querySelector(".income");
        const $VALUE = document.querySelector(".value")

        function type_indicator(value) {

            if (value === '1') {
                $GRADUATION_GROUP.classList.add('hidden');
                $INCOME.classList.remove('hidden');
                $VALUE.classList.remove('hidden')
            } else if (value == 2) {
                $GRADUATION_GROUP.classList.remove('hidden');
                $INCOME.classList.add('hidden');
                $VALUE.classList.remove('hidden')
            } else {
                return
            }
        }


        const $TYPE_GRADUATION = document.querySelector('#id_graduation-category');
        let $data_graduation_category = document.querySelectorAll('[data-graduation-category]');
        $TYPE_INDICATOR_SELECT.addEventListener('change', (e) => {
            let VALUE = e.target.value;
            type_indicator(VALUE);
        })


        $TYPE_GRADUATION.addEventListener('change', e => {
            console.info($data_graduation_category);
            let selected_value = e.target.value;

            $data_graduation_category.forEach(element => {
                element.style.display = 'none';
            });

            $data_graduation_category.forEach(element => {
                if (element.getAttribute('data-graduation-category') == selected_value) {
                    element.removeAttribute('style');
                }
            });


        })


        document.addEventListener('DOMContentLoaded', e => {
            type_indicator($TYPE_INDICATOR_SELECT.value);
        })
    </script>
    <?php
    include '../resources/views/components/presentation.php';
    ?>

    <script src="../../js/components/presentation_system_web.js" type="module"></script>
    <script src="../../js/cdn.js" type="module"></script>
    <script src="../../js/components/location_user.js" type="module"></script>
   
</body>

</html>