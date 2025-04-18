<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datos| Calidad financiera</title>
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
    <link rel="stylesheet" href="../../../public/css/layouts/_base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
                <div class="col-6">
                    <div class="flex-space-between ">
                        <h1><strong>Transacciones</strong></h1>
                        <div class="">
                            <button type="button" class="button--black" title="Agregar indicador">
                                <a href="./../add-transaction" class="text-decoration-none text-white">+ Agregar transaccion</a>
                            </button>
                        </div>
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
                                </tr>
                            </thead>
                            <?php
                            echo $HTML;
                            ?>
                </div>
                <div class="col-6">
                    <div class="main__budget ">
                        <h2><b>Presupuesto</b></h2>
                        <section class='table'>
                            <table class='dataTable'>
                                <thead>
                                    <tr>
                                        <th>Mes</th>
                                        <th>Presupuesto</th>
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

                                $count = 0;
                                $test = '';
                                $array = [];
                                $count = 0;

                                if ($budget != '') {
                                    foreach ($budget as  $value) {
                                        $mes = $value['mes']; // Asume que $value['mes'] es un número (0-11)
                                        if (isset($presupuesto[$mes])) { // Verifica si la clave existe
                                            $presupuesto[$mes] = $value['monto_total'];
                                        }
                                    }
                                }


                                for ($i = 1; $i <= 12; $i++) {
                                    echo "<tr class='show'>";
                                    echo   "<td>" . $months[$i] . "</td>";
                                    if ($presupuesto[$i] == '') {
                                        echo   "<td> No disponible</td>";
                                    } else {
                                        echo   "<td>" . $presupuesto[$i] . ' Bs.' . "</td>";
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
    d
    <script src="../../js/components/location.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>