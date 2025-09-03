<?php // Vista del panel de control del usuario 
?>
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
    <link rel="stylesheet" href="../../public/css/components/_presentation-system-web.css">
    <link rel="stylesheet" href="../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/css/utilities.css">
    <link rel="stylesheet" href="../../public/css/layouts/_base.css">
    <link rel="stylesheet" href="../../public/css/pages/_profile.css">
    <link rel="stylesheet" href="../../public/css/layouts/_ico.css">
    <link rel="icon" type="image/x-icon" href="../../public/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">



</head>

<body>
    <?php
    include '../resources/views/components/user/header.php';
    ?>
    <main class="main">
        <?php
        include '../resources/views/components/user/sidebar.php';
        ?>
        <div class="row p-2 m-0">
            <div class="col-12 col-lg-3 configuration-profile h-100">
                <?php
                include '../resources/views/components/user/profile-nav.php';
                ?>
            </div>
            <div class="col-12 col-lg-9">
                <form action="./profile" method="post" class="form form--profile">

                    <legend class="form__title form__title--profile"><b>Perfil</b></legend>
                    <p class="form__description form__description--profile"> Controla tu información protegiendo tu
                        privacidad y puedes actualizar tu perfil en cualquier momento. </p>
                    <hr class="form__separator">
                    <div class="form__data form__data--profile">
                        <div class="form__row form__row--personal-data row">
                            <div class="form__col form__col--title col-lg-4 col-12">
                                <span class="form__subtitle">Datos personales: </span>
                            </div>
                            <div class="form__col form__col--inputs col-lg-8 col-12">
                                <label for="name" class="form__label form__label--required">Nombre</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon" id="basic-addon1"><i
                                            class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control form__input form__input--item "
                                        placeholder="Tu nombre" aria-label="Nombre" aria-describedby="basic-addon1"
                                        value="<?php echo $data['nombre'] ?? '' ?>">
                                </div>
                                <label for="lastname" class="form__label form__label--required">Apellido</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon" id="basic-addon1"><i
                                            class="bi bi-person-fill"></i></span>
                                    <input type="text" name="lastname"
                                        class="form-control form__input form__input--item " placeholder="Tu apellido"
                                        aria-label="Apellido" aria-describedby="basic-addon1"
                                        value="<?php echo $data['apellido'] ?? '' ?>">
                                </div>
                                <label for="email" class="form__label form__label--required">Correo
                                    electrónico</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon" id="basic-addon1"><i
                                            class="bi bi-envelope"></i></span>
                                    <input type="text" name="email" class="form-control form__input form__input--item "
                                        placeholder="Tu correo electrónico" aria-label="Correo electrónico"
                                        aria-describedby="basic-addon1"
                                        value="<?php echo $data['correo_electronico'] ?? '' ?>">
                                </div>
                                <label for="actividad" class="form__label form__label--required">Actividad</label><br>
                                <div class="input-group">
                                    <span class="input-group-text form__icon"><i class="bi bi-briefcase"></i></span>
                                    <select id="actividad" name="id_actividad"
                                        class=" form-control form__input form__input--select" required>
                                        <option value="" disabled>
                                            Seleccione una opcion
                                        </option>
                                        <?php


                                        foreach ($todas_actividades as $value) {
                                            $selected = ($value['id_actividad'] == $data['id_actividad']) ? 'selected' : '';
                                            echo '<option value ="' . $value['id_actividad'] . '" ' . $selected . ' > ' . $value['actividad'] . ' </option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="form__separator">
                        <div class="form__row form__row--account-data row ">
                            <div class="form__col form__col--title  col-lg-4 col-12">
                                <span class="form__subtitle">Datos de la cuenta: </span>
                            </div>
                            <div class="form__col form__col--inputs col-lg-8 col-12">
                                <label for="username" class="form__label form__label--required ">Usuario</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon" id="basic-addon1"><i
                                            class="bi bi-person-circle"></i></span>
                                    <input type="text" name="user" class="form-control form__input form__input--item "
                                        placeholder="Tu usuario" aria-label="Usuario"
                                        aria-describedby="basic-addon1" value="<?php echo $data['usuario'] ?? '' ?>">
                                </div>
                                <label for="account-type" class="form__label ">Tipo de
                                    cuenta</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon" id="basic-addon1"><i class="bi bi-person-lines-fill"></i></span>
                                    <input type="text" name="account-type"
                                        class="form-control form__input form__input--item " placeholder="Tipo de cuenta"
                                        aria-label="Tipo de cuenta" aria-describedby="basic-addon1" value="Usuario"
                                        disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="form__separator">
                    <div class="form__actions flex-center-full gap-3">
                        <button class="form__button button--back" type="button">
                            <a href="./dashboard/<?php echo Date('m/Y') ?>" class="text-decoration-none text-black"> 
                                   <i class="bi bi-arrow-left-square-fill"></i> Regresar</a>
                        </button>
                        <button class="form__button form__button--submit" type="submit">
                            <i class="bi bi-check-circle-fill"></i>
                            Actualizar datos</button>
                    </div>
                </form>
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

    <script src="../js/components/location_user.js" type="module"></script>
    <script src="../js/cdn.js" type="module"></script>
 
</body>

</html>