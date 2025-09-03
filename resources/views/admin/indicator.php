<?php // Vista del panel de control del usuario 
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($indicator) ? 'Modificar' : 'Agregar' ?> Indicador | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/components/_buttons.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/components/_footer.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/components/_header.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/components/_body.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/components/_form.css">
    <link rel="stylesheet"
        href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/components/_presentation-system-web.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/components/_sidebar.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/pages/_about.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/pages/_guest.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/utilities.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>css/layouts/_base.css">
    <link rel="stylesheet" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>/css/layouts/_ico.css">
    <link rel="icon" type="image/x-icon" href="<?php echo isset($indicator) ? '../../../' : '../../' ?>/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    include '../resources/views/components/admin/header.php';
    ?>
    <main class="main main--content-login">
        <?php
        include '../resources/views/components/admin/sidebar.php';
        ?>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<script>alert("' . $_SESSION['error_message'] . '");</script>';
            unset($_SESSION['error_message']);
        }
        ?>
        <div class="flex-center-full w-100">
            <form action="<?php echo isset($indicator) ? "../$id-{$type}/modify" : '../indicator/add' ?>" method="POST"
                class="form form--guest">
                <input type="hidden" name="operation" value="<?php echo empty($indicator) ? 'add' : 'update' ?>">
                <input type="hidden" name="id" value="<?php echo $id ?? '' ?>">
                <input type="hidden" name="type_indicator" value="<?php
                if (isset($indicator)) {
                    if ($type == 'ingreso') {
                        echo 'ingreso';
                    } else if ($type == 'egreso') {
                        echo 'egreso';
                    } else {
                        echo '';
                    }
                }
                ?>">
                <legend class="form__title">
                    <b> <?php echo isset($indicator) ? 'Modificar' : 'Agregar' ?> indicador</b>
                </legend>
                <p class="form__description"> Controla tu información protegiendo tu privacidad y recuerda que puedes
                    actualizar tu perfil en cualquier momento. </p>
                <hr class="form__separator">
                <div class="form__data">
                    <div class="row form__row">
                        <div class="col-12 col-lg-4 form__col form__col--title">
                            <span class="form__subtitle">Indicador </span>
                        </div>
                        <div class="col-12 col-lg-8 form__col form__col--inputs">
                            <label for="name" class="form__label form__label--required">Tipo de indicador</label><br>
                            <div class="input-group mb-3">
                                <span class="input-group-text form__icon" id="basic-addon1"><i
                                        class="bi bi-tag"></i></span>
                                <select id="type-indicator" name="type-indicator" class="form-control form__select"
                                    required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <?php
                                    if (isset($indicator)) {
                                        if ($type == 'ingreso') {
                                            echo '<option value="1" selected>Ingreso</option>
                                    <option value="2" disabled>Egreso</option>';
                                        } else {
                                            echo '<option value="1" disabled>Ingreso</option>
                                    <option value="2" selected >Egreso</option>';
                                        }
                                    } else {
                                        echo '<option value="1">Ingreso</option>
                                <option value="2">Egreso</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="graduation-group hidden">
                                <label for="name" class="form__label form__label--required">Categoría de
                                    egreso</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon" id="basic-addon1"><i
                                            class="bi bi-cash-stack"></i></span>
                                    <select id="id_graduation-category" name="id_graduation-category"
                                        class="form-control form__select" required>
                                        <?php

                                        if (isset($indicator['id_categoria_egreso'])) {
                                            $selectedCategoryId = $indicator['id_categoria_egreso'];
                                        } else {
                                            echo '<option value="0" disabled selected>Seleccione una opción</option>';
                                            $selectedCategoryId = null;
                                        }

                                        foreach ($data as $value) {
                                            $categoryId = $value['id_categoria_egreso'];
                                            $categoryName = $value['categoria'];
                                            $selected = ($categoryId == $selectedCategoryId) ? 'selected' : '';

                                            echo '<option value="' . $categoryId . '" ' . $selected . '> ' . $categoryName . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label for="graduation" class="form__label form__label--required">Egreso</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-cash-coin"></i></span>
                                    <input type="text" name="graduation"
                                        class="form__input form__input--item form-control"
                                        placeholder="Nombre del egreso (ej. Pago de alquiler de oficina)"
                                        aria-label="Indicador de egreso" aria-describedby="basic-addon1"
                                        value="<?php echo trim($indicator['egreso'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="income hidden">
                                <label for="income" class="form__label form__label--required">Ingreso</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-currency-dollar"></i></span>
                                    <input type="text" name="income" class="form__input form__input--item form-control"
                                        placeholder="Nombre del ingreso (ej. Sueldo)" aria-label="Indicador de ingreso"
                                        aria-describedby="basic-addon1"
                                        value="<?php echo $indicator['ingreso'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="form__separator">
                <div class="flex-center-full form__actions gap-3">
                    <button class="form__button button--back" type="button">
                        <a href="<?php echo $jump_indicators ?>indicators/1/1" class="text-black text-decoration-none">
                            <i class="bi bi-arrow-left-square-fill"></i> Regresar</a>
                    </button>
                    <button class="form__button form__button--submit" type="submit">
                        <i class="bi bi-check-circle-fill"></i>Actualizar datos</button>
                </div>
            </form>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>


    <script>
        let $TYPE_INDICATOR_SELECT = document.querySelector('#type-indicator');
        let $GRADUATION_GROUP = document.querySelector('.graduation-group');
        let $INCOME = document.querySelector(".income");

        function type_indicator(value) {

            if (value === '1') {
                $GRADUATION_GROUP.classList.add('hidden');
                $INCOME.classList.remove('hidden');
            } else if (value == 2) {
                $GRADUATION_GROUP.classList.remove('hidden');
                $INCOME.classList.add('hidden');
            } else {
                return
            }
        }
        $TYPE_INDICATOR_SELECT.addEventListener('change', (e) => {
            let VALUE = e.target.value;
            type_indicator(VALUE);
        })

        document.addEventListener('DOMContentLoaded', e => {
            type_indicator($TYPE_INDICATOR_SELECT.value);
        })
    </script>
    <?php
    include '../resources/views/components/admin/presentation.php';
    ?>

    <script src="<?php echo $js_jump ?>js/components/presentation_system_web.js" type="module"></script>
    <script src="<?php echo $js_jump ?>js/components/location_admin.js" type="module"></script>
    <script src="<?php echo $js_jump ?>js/cdn.js" type="module"></script>
 
</body>

</html>