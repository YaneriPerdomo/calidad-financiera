<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/components/_buttons.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/components/_footer.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/components/_header.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/components/_body.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/components/_sidebar.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/components/_pagination.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/components/_table.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/components/_searchInput.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/pages/_about.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/utilities.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/layouts/_base.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/layouts/_ico.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/css/components/_presentation-system-web.css">
    <link rel="icon" type="image/x-icon"
        href="<?php echo $searchUsers == false ? '../../../' : '../../../../' ?>public/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


</head>

<body>
    <?php
    include '../resources/views/components/admin/header.php';
    ?>
    <main class="main ">
        <?php
        include '../resources/views/components/admin/sidebar.php';
        ?>
        <div class="style-border">
            <section class="flex-space-between ">
                <div>
                    <h1 class="fs-3"><strong>Gestion de usuarios</strong></h1>
                    <div class="search ">
                        <div class="input-group  search__seeker">
                            <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                <i class="bi bi-search search__icon"></i>
                            </span>
                            <input type="text" name="name" id="name"
                                class="search__input search__input--text form-control"
                                data-url="/calidad-financiera/public/admin/users"
                                placeholder="Ingresa el nombre del usuario para buscar" 
                                aria-label="Ingresa el nombre del usuario para buscar" autofocus
                                data-name="<?php echo trim($nameUser) ?>" value="<?php echo trim($nameUser) ?>">
                        </div>
                        <div class="search__action">
                            <button class="button search__button button--azul color-white" type="button">
                                Buscar
                            </button>
                        </div>
                    </div>
                    <script type="module"
                        src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/components/button_search.js"></script>

                </div>
                <div class="button-pdf">
                    <button type="button" class="button--orange m-2" title="Descargar un reporte en PDF">
                        <a href="<?php echo $searchUsers == false ? './' : '../' ?>data-report"
                            class="text-decoration-none text-white">Reporte en <b>PDF</b></a>
                    </button>
                </div>
            </section>
            <section class='table'>
                <table class='dataTable'>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo electronico</th>
                            <th>Actividad</th>
                            <th>Estado</th>
                            <th>Fecha de creacion</th>
                            <th>Ultimo acceso</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <?php
                    echo $HTML;
                    ?>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>

    <?php
    include '../resources/views/components/admin/presentation.php';
    ?>

    <script src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/components/presentation_system_web.js"
        type="module"></script>
    <script>
        document.addEventListener('DOMContentLoaded', e => {
            let formDeleteAccount = document.querySelector('.form-user__delete');
            formDeleteAccount.addEventListener('submit', e => {
                e.preventDefault();
                let resp = confirm('¡Atención! La eliminación de esta cuenta es una acción permanente e irreversible. ¿Estás seguro de que no prefieres solo desactivarla?');
                if (resp) {
                    e.target.submit();
                }
            })
        })
    </script>

    <script src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/components/location_admin.js"
        type="module"></script>
    <script src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/cdn.js" type="module"></script>
     
</body>

</html>