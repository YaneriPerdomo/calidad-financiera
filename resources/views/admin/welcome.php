<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido/a | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/css/components/_presentation-system-web.css">
    <link rel="stylesheet" href="../../public/css/components/_pagination.css">
    <link rel="stylesheet" href="../../public/css/components/_table.css">
    <link rel="stylesheet" href="../../public/css/pages/_about.css">
    <link rel="stylesheet" href="../../public/css/pages/_welcome.css">
    <link rel="stylesheet" href="../../public/css/utilities.css">
    <link rel="stylesheet" href="../../public/css/layouts/_base.css">
    <link rel="stylesheet" href="../../public/css/layouts/_ico.css">
    <link rel="icon" type="image/x-icon" href="../../public/img/logo.ico">
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
        <div class="flex-center-full">
            <article class="style-border w-ajustable">
                <div class="row ">
                    <div class="col-lg-6 col-12 flex-center-full pb-0 ">
                        <div class=" welcome">
                            <h1 class="welcome__greetings text-center fs-2 ">
                                ¡<span></span>
                                <?php echo $_SESSION['usuario'] ?>!
                            </h1>
                            <script>
                                let welcomeGreetings = document.querySelector('.welcome__greetings > span');
                                let date = new Date();
                                const msgGender = ' estimado/a';
                                if (date.getHours() >= 0 && date.getHours() <= 12) {
                                    welcomeGreetings.innerHTML = 'Buenos dias, ' + msgGender
                                }
                                if (date.getHours() >= 12 && date.getHours() <= 18) {
                                    welcomeGreetings.innerHTML = 'Buenas tardes,' + msgGender
                                }
                                if (date.getHours() >= 18 && date.getHours() <= 24) {
                                    welcomeGreetings.innerHTML = 'Buenas noches, ' + msgGender;
                                }
                            </script>
                            <span class="">
                                Bienvenido/a
                                Con Soluciones de Control de Ventas
                                a Medida, nuestro sistema
                                web StockYP te ayuda a tomar el <b class="text-orange">control total de tus ventas y
                                    stock
                                    de
                                    forma
                                    simplificada.</b>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 ">
                        <figure class="img-welcome  flex-center-full">
                            <img src="../img/welcome.jpg" alt="" class="img-fluid">
                        </figure>
                    </div>
                </div>
                <br>
                <div class="card">
                    <h2 class="card__title fs-5">Acciones Rápidas</h2>
                    <div class="card__content">
                        <div class="card__block card_categorys">
                            <i class="bi bi-cart-plus fs-4 card__icon"></i>
                            <a href="./users/data-report" class="text-decoration-none text-color-black">
                                <div class="card__quantity-content">
                                    <span class="card__sub-title">Generar reporte PDF de usuarios</span>
                                </div>
                            </a>
                        </div>
                        <div class="card__block card_categorys">
                            <i class="bi bi-inboxes fs-4  card__icon"></i>
                            <a href="./indicator/add" class="text-decoration-none text-color-black">
                                <div class="card__quantity-content">
                                    <span class="card__sub-title"> Agregar indicador</span>
                                </div>
                            </a>
                        </div>
                        <div class="card__block card_categorys">
                            <i class="bi bi-inboxes fs-4  card__icon"></i>
                            <a href="./profile" class="text-decoration-none text-color-black">
                                <div class="card__quantity-content">
                                    <span class="card__sub-title">Administrar tu cuenta</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <h2 class="card__title fs-5"> Resumen General</h2>
                    <br>
                    <div class="card__content b-0">
                        <div class="card__block card_categorys">
                            <i class="bi bi-tags fs-4 card__icon"></i>
                            <a href="./users/1" class="text-decoration-none text-color-black">
                                <div class="card__quantity-content">
                                    <span class="card__sub-title">Usuario<?php echo $data[1] == 0 ? '' : 's'; ?>: <b
                                            class="">
                                            <?php
                                            echo $data[1];
                                            ?>
                                        </b></span>
                                </div>
                            </a>
                        </div>
                        <div class="card__block card__products">
                            <i class="bi bi-box-seam fs-4 card__icon"></i>
                            <a href="indicators/1/1" class="text-decoration-none text-color-black">
                                <div class="card__quantity-content">
                                    <span
                                        class="card__sub-title">Indicador<?php echo $data[2] == 0 ? '' : 'es'; ?>:</span>
                                    <b class="">
                                        <?php
                                        echo $data[2];
                                        ?>
                                    </b>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>

    <?php 
    include '../resources/views/components/admin/presentation.php';
    ?>

    <script src="../js/components/presentation_system_web.js" type="module"></script>
    <script src="../js/components/location_admin.js" type="module"></script>
    <script src="../js/cdn.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>