<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesion | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../public/css/components/_footer.css">
    <link rel="stylesheet" href="../public/css/components/_header.css">
    <link rel="stylesheet" href="../public/css/pages/_login-createAccount.css">
    <link rel="stylesheet" href="../public/css/utilities.css">
    <link rel="stylesheet" href="../public/css/layouts/_base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>

    </style>

</head>

<body>
    <?php
    include '../resources/views/components/header.php';
    ?>
    <main class="main main--content-login">
        <form action="login" method="post" class="form-login">

            <legend class="form-login__title font-bold fs-1 m-0">Bienvenida/o</legend>

            <p class="title-green p-0 m-2">Accede a tu cuenta y toma el control de tus finanzas</p>
            <div class="form-login__content">
                <div class="form-login__item">
                    <label for="user" class="form-login__label">Usuario</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="text" name="user" id="user" class="form-control form--login__input" placeholder="Introduzca el usuario"
                            aria-label="Username" aria-describedby="basic-addon1" autofocus="true">
                    </div>
                </div>
                <div class="form--login__item">
                    <label for="password" class="form-login__label">Contraseña</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="password" name="password" id="password" class="form-control form--login__input" placeholder="Introduzca el usuario"
                            aria-label="Username" aria-describedby="basic-addon1" autofocus="true">
                    </div>
                </div>
                <button type="submit" class="form-login__button-send button-r">
                    <i class="fas fa-sign-in-alt form-login__icon"></i>
                    <span class="form--login__text">Acceder</span>
                </button>
                <div class="form-login__link p-2 text-center ">
                    ¿No tienes una cuenta?
                    <a href="./create-account" class="form--login__link-text">¡Regístrate!</a>
                </div>
            </div>
            <div class="ornament">

            </div>
        </form>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>