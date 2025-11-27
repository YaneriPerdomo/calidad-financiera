<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transacciones | Calidad Financiera</title>
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
    <link rel="stylesheet" href="../../../public/css/components/_modal.css">
    <link rel="stylesheet" href="../../../public/css/pages/_data.css">
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
                <div class=" col-12 ">
                    <div class="flex-space-between ">
                        <h1 class="fs-3"><strong>Transacciones</strong></h1>
                        <div class="button-pdf">
                            <button type="button" class="button--orange m-2" title="Descargar un reporte en PDF"
                                data-model='js_report'>
                                  <i class="bi bi-file-earmark-text"></i>
                                Generar Reporte
                            </button>
                            <button type="button" class="button--azul" title="Agregar persona invitada">
                                <a href="./../add-transaction" class="text-decoration-none text-white">
                                    <i class="bi bi-file-plus"></i>
                                    Agregar Transaccion</a>
                            </button>
                        </div>
                    </div>
                    <?php
                    if (isset($_SESSION['alert-danger'])) {
                        echo '
                        <div class="alert alert-danger" role="alert">
                            ' . $_SESSION['alert-danger'] . '
                        </div>';
                        unset($_SESSION['alert-danger']);
                    }
                    ?>
                    <?php
                    if (isset($_SESSION['alert-success'])) {
                        echo '
                            <div class="alert alert-success" role="alert">
                                ' . $_SESSION['alert-success'] . ' </div>';
                        unset($_SESSION['alert-success']);
                    }
                    ?>
                    <section class='table'>
                        <table class='dataTable'>
                            <thead>
                                <tr>
                                    <th>Tipo de Indicador</th>
                                    <th>Categoria</th>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Fecha de Registro</th>
                                    <th>Observaciones</th>
                                    <th>Operación</th>
                                </tr>
                            </thead>
                            <?php
                            echo $HTML;
                            ?>
                </div>
            </div>
        </article>

        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>

    <div class="model model--selection-report"
        style="<?php echo isset($_SESSION['alert-danger__wm']) ? '' : 'display:none' ?>">
        <form action="../transactions/report" method="post" class="model__form">

            <div class="model__header bg-dorado">
                <span class="model_title">
                    Generar Reporte de Transacciones
                </span>
            </div>
            <div class="model__body">
                <?php
                if (isset($_SESSION['alert-danger__wm'])) {
                    echo '
                        <div class="alert alert-danger" role="alert">
                            ' . $_SESSION['alert-danger__wm'] . '
                        </div>';
                    unset($_SESSION['alert-danger__wm']);
                }
                ?>
                <p class="form__label">Seleccione el período del reporte:</p>
                <div class="flex-center-full" style="gap:1rem">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" checked name="periodo_seleccion"
                            id="periodoHoy">
                        <label class="form-check-label" for="periodoHoy">
                            Solo Hoy
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="0" name="periodo_seleccion"
                            id="periodoRango">
                        <label class="form-check-label" for="periodoRango">
                            Rango de Fechas
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="2" name="periodo_seleccion"
                            id="periodoRango">
                        <label class="form-check-label" for="periodoRango">
                            Todas
                        </label>
                    </div>
                </div>

                <label for="report-format" class="form__label form__label--required mt-3">Formato del
                    Reporte</label><br>
                <div class="input-group w-100">
                    <span class="input-group-text form__icon" id="format-icon"><i
                            class="bi bi-file-earmark-spreadsheet"></i></span>
                    <select id="report-format" name="report_format" class="form-control form__select" required>
                        <option value="0" disabled>-- Seleccione un formato --</option>
                        <option value="1">PDF (.pdf)</option>
                        <option value="2">Excel (CSV)</option>
                    </select>
                </div>

                <div class="data-range-report" style="display:none;">
                    <label for="fecha-inicio" class="form__label mt-3">Fecha de Inicio</label>
                <div class="input-group mb-3">
                    <span class="input-group-text form__icon" id="fecha-inicio-icon"><i
                            class="bi bi-calendar-check"></i></span> <input type="date" name="fecha_inicio"
                        id="fecha-inicio" class="form-control form__input form__input--item"
                        aria-label="Fecha de Inicio" value="">
                </div>

                <label for="fecha-fin" class="form__label">Fecha de Fin</label>
                <div class="input-group mb-3">
                    <span class="input-group-text form__icon" id="fecha-fin-icon"><i
                            class="bi bi-calendar-check"></i></span> <input type="date" name="fecha_fin" id="fecha-fin"
                        class="form-control form__input form__input--item" aria-label="Fecha de Fin" value="">
                </div>
                </div>


            </div>
            <div class="model__buttons" style="margin-left: 1rem; margin-right: 1rem;">
                <button class="model__exit model__exit-report button__exit button--cancel" type="button">
                    <i class="bi bi-arrow-left"></i>
                    Cancelar
                </button>

                <button type="submit" class="model__submit button--orange">
                       <i class="bi bi-file-earmark-text"></i>
                    Generar y Descargar
                </button>
            </div>
        </form>
    </div>

    <script type="module" src="../../js/components/periodo_selecion.js"></script>
   
    <script>
        let modalReport = document.querySelector(".model--selection-report");

        document.addEventListener('click', e => {

            if (e.target.matches('.model__exit-report')) {
                modalReport.style.display = 'none'
            }

            if (e.target.matches("[data-model='js_report']")) {
                modalReport.removeAttribute('style');
            }
        });


    </script>


    <div class="model model__delete-user" style="display: none">
        <form action="<?php echo $header_break; ?>transactions/1" method="post" class="model__form">
            <input type="hidden" name="tipo">
            <input type="hidden" name="id_transaccion">
            <div class="model__header">
                <span class="model_title">
                    Confirmar Anulación de Transacción
                </span>
            </div>
            <div class="model__body">
                <p class="model__p">
                    Advertencia: Está a punto de anular esta transacción de monto. Esta acción revertirá su efecto
                    financiero, por lo que el monto dejará de verse reflejado en sus movimientos y saldos. La
                    transacción se mantendrá en el historial como registro de anulación.
                </p>
            </div>
            <div class="model__buttons">
                <button class="model_exit button__exit btn-exit button--cancel" type="button">
                    No, Mantener la Transacción
                </button>
                <button class="model__submit button--delete ">
                    Sí, Anular y Revertir
                </button>
            </div>
        </form>
    </div>
    <script>

        let buttonExitModal = document.querySelector('.button__exit');
        let modal = document.querySelector(".model__delete-user");
        let inputIdPerson = document.querySelector('[name="id_transaccion"]');
        let inputType = document.querySelector('[name="tipo"]')
        let inputIdUser = document.querySelector('[name="id_usuario"]');


        document.addEventListener('click', e => {


            if (e.target.matches("[data-model='js_delete_guest']")) {
                console.info('hos')
                console.info(e.target.getAttribute('data-id-transaccion'))
                modal.removeAttribute('style');
                inputIdPerson.value = e.target.getAttribute('data-id-transaccion');
                inputType.value = e.target.getAttribute('data-type');
            }

            if (e.target.matches('.button__exit')) {
                modal.style.display = 'none'
            }
        })





        buttonExitModal.addEventListener("click", e => {
            modal.style.display = 'none'
        })

    </script>
    <script src="../../js/cdn.js" type="module"></script>
    <script src="../../js/components/location_user.js" type="module"></script>

</body>

</html>