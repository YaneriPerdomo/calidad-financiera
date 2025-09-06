<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perfil | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/css/pages/_profile.css">
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
    include '../resources/views/components/guest/header.php';
    ?>
    <main class="main">
        <?php
        include '../resources/views/components/guest/sidebar.php';
        ?>
        <div class="row p-2 m-0">
            <div class="col-12 col-lg-3 configuration-profile h-100">
                <?php
                include '../resources/views/components/guest/profile-nav.php';
                ?>
            </div>
            <div class="col-12 col-lg-9">
                <section class="form form--profile">
                    
                    <legend class="form__title form__title--profile"><b>Perfil</b></legend>
                    <p class="form__description form__description--profile"> Controla tu información protegiendo tu
                        privacidad y recuerda que puedes actualizar tu perfil en cualquier momento. </p>
                    <hr class="form__separator">
                    <div class="form__data form__data--profile">
                        <div class="form__row form__row--personal-data row">
                            <div class="form__col form__col--title col-lg-4 col-12">
                                <span class="form__subtitle">Datos personales: </span>
                            </div>
                            <div class="form__col form__col--inputs col-lg-8 col-12">
                                <label for="name" class="form__label form__label--required">Nombre</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon"><i class="bi bi-person-circle"></i></span>
                                    <input type="text" name="name" class="form-control form__input form__input--item"
                                        aria-label="Nombre" disabled value="<?php echo $data['nombre'] ?? '' ?>">
                                </div>
                                <label for="lastname" class="form__label form__label--required">Apellido</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon"><i class="bi bi-person-badge"></i></span>
                                    <input type="text" name="lastname"
                                        class="form-control form__input form__input--item" aria-label="Apellido"
                                        disabled value="<?php echo $data['apellido'] ?? '' ?>">
                                </div>
                                <label for="email" class="form__label form__label--required">Correo
                                    electrónico</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="text" name="email" class="form-control form__input form__input--item"
                                        aria-label="Correo electrónico" disabled
                                        value="<?php echo $data['correo_electronico'] ?? '' ?>">
                                </div>

                            </div>

                        </div>
                        <hr class="form__separator">
                        <div class="form__row form__row--account-data row ">
                            <div class="form__col form__col--title col-lg-4 col-12">
                                <span class="form__subtitle">Datos de la cuenta: </span>
                            </div>
                            <div class="form__col form__col--inputs col-lg-8 col-12">
                                <label for="username" class="form__label form__label--required ">Usuario</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" name="user" class="form-control form__input form__input--item"
                                        aria-label="Usuario" disabled value="<?php echo $_SESSION['usuario'] ?? '' ?>">
                                </div>
                                <label for="account-type" class="form__label ">Tipo de
                                    cuenta</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon"><i
                                            class="bi bi-person-lines-fill"></i></span>
                                    <input type="text" name="lastname"
                                        class="form-control form__input form__input--item" aria-label="Tipo de cuenta"
                                        value="Invitado(a)" disabled>
                                </div>
                                <div>
                                    <small>Para actualizar tu información, por favor comunícate con el administrador de
                                        la cuenta.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="form__separator">

                </section>
            </div>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>
    <?php
    include '../resources/views/components/presentation.php';
    ?>

    <script src="../js/components/presentation_system_web.js" type="module"></script>
    <script src="../js/components/location_guest.js" type="module"></script>
    <script src="../js/cdn.js" type="module"></script>

</body>

</html>