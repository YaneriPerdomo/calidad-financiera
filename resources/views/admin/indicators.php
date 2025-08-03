<?php // Vista del panel de control del usuario ?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Indicadores | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../../../public/css/components/_table.css">
    <link rel="stylesheet" href="../../../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../../../public/css/components/_pagination.css">
    <link rel="stylesheet" href="../../../../public/css/pages/_about.css">
    <link rel="stylesheet" href="../../../../public/css/utilities.css">
    <link rel="stylesheet" href="../../../../public/css/layouts/_base.css">
    <link rel="icon" type="image/x-icon" href="../../../../public/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    include '../resources/views/components/admin/header.php';
    ?>
    <main class="main main--content-login">
        <?php
        include '../resources/views/components/admin/sidebar.php';
        ?>
        <div class="style-border">
            <section class="flex-space-between ">
                <h1><strong>Gestion de Indicadores</strong></h1>
                <div class="">
                    <button type="button" class="button--black" title="Agregar indicador">
                        <a href="../../indicator/add" class="text-decoration-none text-white">+ Agregar indicador</a>
                    </button>
                </div>
            </section>
            <div class="row">
                <div class="col-6">
                    <div class="flex-space-between">
                        <h2><b>Egreso</b></h2>
                        <button class="button--azul">Agregar categoria</button>
                    </div>
                    <hr>
                    <section class='table'>
                        <table class='dataTable'>
                            <thead>
                                <tr>
                                    <th>Egreso</th>
                                    <th>Categoria</th>
                                    <th>Operaciones</th>
                                </tr>
                            </thead>
                            <?php
                            echo $HTML_graduantion;
                            ?>
                </div>
                <div class="col-6">
                    <div>
                        <h2><b>Ingreso</b></h2>
                    </div>
                    <hr>
                    <section class='table'>
                        <table class='dataTable'>
                            <thead>
                                <tr>
                                    <th>Ingreso</th>
                                    <th>Operaciones</th>
                                </tr>
                            </thead>
                            <?php
                            echo $HTML_insome;
                            ?>
                </div>
            </div>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>


    <script>
        $page_insome_links = document.querySelectorAll('.page__link--graduantion');

        let URL = window.location.href;
        let ADD_PAGE_GRADUANTION = URL.split('/').at(-1)
        $page_insome_links.forEach(element => {
            console.info(element.getAttribute('href'));
            element.setAttribute('href', element.getAttribute('href') + '/' + ADD_PAGE_GRADUANTION)
        });
    </script>

    <script src="../../../js/components/location.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>