<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear una cuenta | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../<?php echo $style ?? '' ?>public/css/components/_buttons.css">
    <link rel="stylesheet" href="../<?php echo $style ?? '' ?>public/css/components/_footer.css">
    <link rel="stylesheet" href="../<?php echo $style ?? '' ?>public/css/components/_header.css">
    <link rel="stylesheet" href="../<?php echo $style ?? '' ?>public/css/components/_form.css">
    <link rel="stylesheet" href="../<?php echo $style ?? '' ?>public/css/pages/_login-createAccount.css">
    <link rel="stylesheet" href="../<?php echo $style ?? '' ?>public/css/utilities.css">
    <link rel="stylesheet" href="../<?php echo $style ?? '' ?>public/css/layouts/_base.css">
    <link rel="stylesheet" href="../<?php echo $style ?? '' ?>public/css/layouts/_ico.css">
    <link rel="icon" type="image/x-icon" href="../public/img/logo.ico">
</head>
<body>
    <?php
    include '../resources/views/components/header.php';
    ?>
    <main class="main main--content-create">
        <form action="create-account " method='POST' class="form-create m-3">
            <legend class="form-create__title font-bold m-0">Crea una cuenta</legend>
            <p class="title-green p-0 m-2 text-center">Regístrate en minutos y comienza a alcanzar tus objetivos</p>
            <div class="form-create__content">
                <div class="form__data">
                    <div class="row form__row">
                        <div class="col-12 col-lg-4 form__col form__col--title">
                            <span class="form__subtitle">Datos personales: </span>
                        </div>
                        <div class="col-12 col-lg-8 form__col form__col--inputs">
                            <label for="name" class="form__label form__label--required">Nombre</label><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i
                                        class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form__input form__input--item form-control"
                                    placeholder="¿Como se llama tu niño/a? 🤔" aria-label="Username"
                                    aria-describedby="basic-addon1" value="">
                            </div>
                            <label for="lastname" class="form__label form__label--required">Apellido</label><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i
                                        class="bi bi-person"></i></span>
                                <input type="text" name="lastname" class="form__input form__input--item form-control"
                                    placeholder="¿Como se llama tu niño/a? 🤔" aria-label="Username"
                                    aria-describedby="basic-addon1" value="">
                            </div>
                            <label for="email" class="form__label form__label--required">Correo electrónico</label><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i
                                        class="bi bi-person"></i></span>
                                <input type="text" name="email" class="form__input form__input--item form-control"
                                    placeholder="¿Como se llama tu niño/a? 🤔" aria-label="Username"
                                    aria-describedby="basic-addon1" value="">
                            </div>
                            <label for="actividad" class="form__label form__label--required">Actividad</label><br>
                            <div class="input-group">
                                <span class="input-group-text form__icon"><i class="bi bi-person"></i></span>
                                <select id="actividad" name="actividad"
                                    class=" form-control form__input form__input--select" required>
                                    <option value="" disabled selected> Seleccione una opcion</option>
                                    <?php
                                    echo $actividades
                                        ?>
                                </select>
                            </div>
                            <br>
                        </div>
                        <hr class="form__separator">
                        <div class="row form__row">
                            <div class="col-12 col-lg-4 form__col form__col--title">
                                <span class="form__subtitle">Datos de la cuenta: </span>
                            </div>
                            <div class="col-12 col-lg-8 form__col form__col--inputs">
                                <label for="user" class="form__label form__label--required">Usuario</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-person"></i></span>
                                    <input type="text" name="user" class="form__input form__input--item form-control"
                                        placeholder="¿Como se llama tu niño/a? 🤔" aria-label="Username"
                                        aria-describedby="basic-addon1" value="">
                                </div>
                                <label for="password" class="form__label form__label--required">Contraseña</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-person"></i></span>
                                    <input type="password" name="password"
                                        class="form__input form__input--item form-control" placeholder="****"
                                        aria-label="Username" aria-describedby="basic-addon1" value="">
                                </div>
                                <label for="confirm-password" class="form__label form__label--required">Confirmar
                                    contraseña</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-person"></i></span>
                                    <input type="password" name="confirm-password"
                                        class="form__input form__input--item form-control" placeholder="****"
                                        aria-label="Username" aria-describedby="basic-addon1" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="form-create__button-send button-r">
                        <i class="fas fa-sign-in-alt form-create__icon"></i>
                        <span class="form--login__text">Registrarte</span>
                    </button>
                    <div class="form-create__link p-2 text-center ">
                        ¿Ya tienes una cuenta?
                        <a href="./login" class="form--create__link-text">¡Accede ahora!</a>
                    </div>
                </div>
                <!--  <div class="form-create__item">
                    <label for="name" class="form-create__label">Nombre</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" id="name" class="form-control form--login__input"
                            placeholder="Introduzca el usuario" aria-label="Username" aria-describedby="basic-addon1"
                            autofocus="true">
                    </div>
                </div>
                <div class="form-create__item">
                    <label for="lastname" class="form-create__label">Apellido</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="text" name="lastname" id="lastname" class="form-control form--login__input"
                            placeholder="Introduzca el usuario" aria-label="Username" aria-describedby="basic-addon1"
                            autofocus="true">
                    </div>
                </div>
                <div class="form-create__item">
                    <label for="user" class="form-create__label">Usuario</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="text" name="user" id="user" class="form-control form--login__input"
                            placeholder="Introduzca el usuario" aria-label="Username" aria-describedby="basic-addon1"
                            autofocus="true">
                    </div>
                </div>

                <div class="form-create__item">
                    <label for="email" class="form-create__label">Correo electrónico</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="email" name="email" id="email" class="form-control form--login__input"
                            placeholder="Introduzca el usuario" aria-label="Username" aria-describedby="basic-addon1"
                            autofocus="true">
                    </div>
                </div>
                <div class="form-create__item">
                    <label for="" class="form-create__label">Actividad</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <select id="actividad" name="actividad" class="form-control" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <?php
                            echo $actividades
                                ?>

                        </select>
                    </div>

                </div>
                <div class="form-create__item">
                    <label for="password" class="form-create__label">Contraseña</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="password" name="password" id="password" class="form-control form--login__input"
                            placeholder="Introduzca el usuario" aria-label="Username" aria-describedby="basic-addon1"
                            autofocus="true">
                    </div>
                </div>
                
                <button type="submit" class="form-create__button-send button-r">
                    <i class="fas fa-sign-in-alt form-create__icon"></i>
                    <span class="form--login__text">Registrarte</span>
                </button>
                <div class="form-create__link p-2 text-center ">
                    ¿Ya tienes una cuenta?
                    <a href="./login" class="form--create__link-text">¡Accede ahora!</a>
                </div>-->
            </div>
            <div class="ornament">

            </div>
        </form>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>