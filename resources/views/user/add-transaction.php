<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Agregar Transacción | Calidad Financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../public/css/components/_table.css">
    <link rel="stylesheet" href="../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../public/css/components/_form.css">
    <link rel="stylesheet" href="../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/css/pages/_about.css">
    <link rel="stylesheet" href="../../public/css/utilities.css">
    <link rel="stylesheet" href="../../public/css/layouts/_ico.css">
    <link rel="stylesheet" href="../../public/css/layouts/_base.css">
    <link rel="icon" type="image/x-icon" href="../../public/img/logo.ico">
    <link rel="stylesheet" href="../../public/css/components/_presentation-system-web.css">
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
        <div>
            <article class="main__transaction flex-center-full w-100 ">
                <form action="./data" method="POST" class="form form--transaction just-one-form">
                    <legend class="form__title">
                        <b>Agregar Transacción</b>
                    </legend>
                    <p class="form__description">
                        Registra un nuevo movimiento financiero, clasificándolo como un ingreso o un egreso,
                        y asegúrate de añadir todos los detalles importantes para tu contabilidad.
                    </p>
                    <?php
                    if (isset($_SESSION['alert-danger'])) {
                        echo '
                        <div class="alert alert-danger" role="alert">
                            ' . $_SESSION['alert-danger'] . '
                        </div>';
                        unset($_SESSION['alert-danger']);
                    }
                    ?>
                    <hr class="form__separator">
                    <div class="form__data">
                        <div class="row form__row">
                            <div class="col-12 col-lg-4 form__col form__col--title">
                                <span class="form__subtitle">Detalles de la Transacción</span>
                            </div>
                            <div class="col-12 col-lg-8 form__col form__col--inputs">
                                <label for="name" class="form__label form__label--required">Tipo de
                                    Transacción</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon" id="basic-addon1"><i
                                            class="bi bi-arrow-left-right"></i></span>
                                    <select id="type-indicator" name="type-indicator" class="form-control form__select"
                                        required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Ingreso</option>
                                        <option value="2">Egreso</option>
                                    </select>
                                </div>
                                <div class="graduation-group hidden">
                                    <label for="id_graduation-category"
                                        class="form__label form__label--required">Categoría de egreso</label><br>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text form__icon" id="basic-addon1"><i
                                                class="bi bi-folder2-open"></i></span>
                                        <select id="id_graduation-category" name="id_graduation_category"
                                            class="form-control form__select" required>
                                            <?php
                                            foreach ($data as $value) {
                                                $categoryId = $value['id_categoria_egreso'];
                                                $categoryName = $value['categoria'];
                                                echo '<option value="' . $categoryId . '"> ' . $categoryName . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <label for="id_graduation"
                                        class="form__label form__label--required">Egreso</label><br>
                                    <div class="input-group mb-3">
                                        <span class="form__icon input-group-text" id="basic-addon1"><i
                                                class="bi bi-tag-fill"></i></span>
                                        <select id="id_graduation" name="id_graduation"
                                            class="form-control form__select">
                                            <?php
                                            echo '<option value="" required> Seleccione una opción</option>';

                                            foreach ($accommodation as $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '"" > ' . $value['egreso'] . '</option>';
                                            }

                                            foreach ($services as $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '"" style="display:none" > ' . $value['egreso'] . '</option>';
                                            }
                                            foreach ($meal as $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '"  style="display:none" > ' . $value['egreso'] . '</option>';
                                            }
                                            foreach ($others as $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '"   style="display:none"> ' . $value['egreso'] . '</option>';
                                            }
                                            foreach ($entertainment as $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '"  style="display:none"> ' . $value['egreso'] . '</option>';
                                            }
                                            foreach ($debts as $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '"  style="display:none"> ' . $value['egreso'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="income hidden">
                                    <label for="insome" class="form__label form__label--required">Ingreso</label><br>
                                    <div class="input-group mb-3">
                                        <span class="form__icon input-group-text" id="basic-addon1"><i
                                                class="bi bi-wallet2"></i></span>
                                        <select id="id_insome" name="id_insome" class="form-control form__select">
                                            <?php
                                            foreach ($all_insome as $value) {
                                                $id_insome = $value['id_ingreso'];
                                                $insome = $value['ingreso'];
                                                echo '<option value="' . $id_insome . '"> ' . $insome . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="value hidden">
                                    <label for="value" class="form__label form__label--required">Monto</label><br>
                                    <div class="input-group mb-3">
                                        <span class="form__icon input-group-text" id="basic-addon1">
                                            <i class="bi bi-cash-stack"></i>
                                        </span>
                                        <input type="text" name="value" id="monto"
                                            class="form__input form__input--item form-control" placeholder="Ej. 1500.00"
                                            aria-label="Valor de la transacción" aria-describedby="basic-addon1"
                                            value="">
                                    </div>
                                </div>
                                <script>
                                    let montoInput = document.querySelector('#monto');
                                    function formatearNumero(numero, decimales = 2) {
                                        if (isNaN(numero) || numero === null) {
                                            return '';
                                        }
                                        let partes = numero.toFixed(decimales).split('.');
                                        let parteEntera = partes[0]; // Ej: "1234"
                                        let parteDecimal = partes.length > 1 ? partes[1] : '';
                                        let regexMiles = /(\d+)(\d{3})/;
                                        while (regexMiles.test(parteEntera)) {
                                            parteEntera = parteEntera.replace(regexMiles, '$1.$2');
                                        }
                                        let resultado = parteEntera;
                                        if (decimales > 0) {
                                            resultado += ',' + parteDecimal.padEnd(decimales, '0');
                                        }
                                        return resultado;
                                    }
                                    function limpiarYConvertir(valor) {
                                        let regexMontoBS = /^[\d\.\,]+$/;
                                        if (!regexMontoBS.test(valor)) {
                                            console.info('mal')
                                            return;
                                        }
                                        if (typeof valor !== 'string') {
                                            valor = String(valor);
                                        }
                                        let limpio = valor.replace(/\./g, '');
                                        limpio = limpio.replace(',', '.');
                                        let numero = parseFloat(limpio);
                                        if (isNaN(numero)) {
                                            return null; 
                                        }
                                        return numero;
                                    }
                                    montoInput.addEventListener('input', e => {
                                        const valorActual = e.target.value;
                                        console.info('hl')
                                        if (e.target.value.length > 20) {
                                            montoInput.value = valorActual.slice(0, 20)
                                        }
                                    })
                                    montoInput.addEventListener('blur', e => {
                                        const valorActual = e.target.value;
                                        const numeroLimpio = limpiarYConvertir(valorActual);
                                        if (numeroLimpio === null || numeroLimpio === 0 && valorActual.length > 0) {
                                            return montoInput.value = '';
                                        }
                                        if (numeroLimpio >= 1000 || valorActual.includes(',')) {
                                            e.target.value = formatearNumero(numeroLimpio);
                                        } else {
                                            e.target.value = formatearNumero(numeroLimpio, 2);
                                        }
                                    });
                                </script>
                                <div class="observations">
                                    <label for="observations" class="form__label ">Observaciones</label><br>
                                    <div class="input-group mb-3">
                                        <span class="form__icon input-group-text" id="basic-addon1"><i
                                                class="bi bi-journal-text"></i></span>
                                        <textarea type="text" name="observations"
                                            class="form__input form__input--item form-control"
                                            placeholder="Añade una descripción de la transacción."
                                            aria-label="Observaciones" aria-describedby="basic-addon1"
                                            value=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="form__separator">
                    <div class="flex-center-full form__actions gap-3">
                        <button class="form__button button--back" type="button">
                            <a href="./transactions/1" class="text-black text-decoration-none">
                                <i class="bi bi-arrow-left-square"></i> Regresar</a>
                        </button>
                        <button class="form__button form__button--submit" type="submit">
                              <i class="bi bi-file-earmark-text"></i>
                            Agregar Transacción</button>
                    </div>
                </form>
            </article>
        </div>

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


    <script src="../js/cdn.js" type="module"></script>
    <script src="../js/components/location_user.js" type="module"></script>

</body>

</html>