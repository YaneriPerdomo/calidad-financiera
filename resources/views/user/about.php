<?php // Vista del panel de control del usuario 
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acerca de | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/css/pages/_about.css">
    <link rel="stylesheet" href="../../public/css/utilities.css">
    <link rel="stylesheet" href="../../public/css/layouts/_base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        

      

       
    </style>

</head>

<body>
    <?php
    include '../resources/views/components/user/header.php';
    ?>
    <main class="main">
        <?php
        include '../resources/views/components/user/sidebar.php';
        ?>
        <div class="w-100 h-100-p content--user-about">
            <article class="about">
                <div class="row about__row">
                    <div class="col-6 about__col--left">
                        <div class="about-us">
                            <h1 class="about-us__title"><strong>Acerca de nosotros</strong></h1>
                            <p class="about-us__description">En primera instancia con la aplicacion web llamada <i class="font-bold">calidad financiera</i> está diseñado
                                para ayudar a los usuarios a registrar, categorizar y analizar sus ingresos y gastos,
                                <b> permitiéndoles tomar decisiones
                                    financieras informadas </b>
                                y, al mismo tiempo, brindando a los huéspedes la oportunidad de ver su progreso con un seguimiento seguro.
                            </p>
                        </div>
                        <div class="available-services">
                            <h2 class="available-services__title"><b>Ofrecemos servicios tales como:</b></h2>
                            <ol class="available-services__list">
                                <li class="available-services__item">Definir el objetivo de ahorro deseado.
                                </li>
                                <li class="available-services__item">Controlar su progreso financiero, como saldo, ahorros, ingresos y gastos, mensual y anualmente, y consulte presupuestos mensuales y más.</li>
                                <li class="available-services__item">
                                    Gestionar a los invitados que desee para que puedan ver su progreso financiero de forma segura, estableciendo restricciones.
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-6 about__col--right">
                        <div class="mission">
                            <h3 class="mission__title"><b>Mision</b></h3>
                            <p class="mission__description">Nuestra visión es empoderar a los usuarios para que tomen el control de sus finanzas personales de manera segura, intuitiva y eficiente, ofreciendo una plataforma flexible que se adapte a sus necesidades y les permita alcanzar sus metas financieras con confianza y tranquilidad.</p>
                        </div>
                        <div class="vision">
                            <h3 class="vision"><b>Vision</b></h3>
                            <p class="vision__description">Nuestra misión es crear una comunidad activa y comprometida que aproveche al máximo las funcionalidades del sistema, fomentando la mejora continua y adaptándonos a las necesidades individuales de cada usuario para ofrecer herramientas de control financiero cada vez más completas y personalizadas</p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>


    <script src="../js/components/location_user.js" type="module"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>