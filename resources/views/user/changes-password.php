<?php // Vista del panel de control del usuario 
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambiar contraseña | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/css/pages/_profile.css">
    <link rel="stylesheet" href="../../public/css/utilities.css">
    <link rel="stylesheet" href="../../public/css/layouts/_base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
                <form action="./changes-password" method="post" class="form form--profile">

                    <legend class="form__title form__title--profile"><b>Cambiar contraseña</b></legend>
                    <p class="form__description form__description--profile"> Protege tu cuenta actualizando tu
                        contraseña de forma segura. </p>
                    <hr class="form__separator">

                    <label for="old-password" class="form__label form__label--required">Contraseña actual</label><br>
                    <div class="input-group mb-3">
                        <span class="input-group-text form__icon" id="old-password-icon"><i
                                class="bi bi-lock"></i></span>
                        <input type="password" name="old-password" class="form-control form__input form__input--item"
                            placeholder="Ingresa tu contraseña actual" aria-label="Contraseña actual"
                            aria-describedby="old-password-icon" autocomplete='off' value="">
                    </div>

                    <label for="new-password" class="form__label form__label--required">Nueva contraseña</label><br>
                    <div class="input-group mb-3">
                        <span class="input-group-text form__icon" id="new-password-icon"><i
                                class="bi bi-key"></i></span>
                        <input type="password" name="new-password" class="form-control form__input form__input--item"
                            placeholder="Ingresa tu nueva contraseña" aria-label="Nueva contraseña"
                            aria-describedby="new-password-icon" autocomplete='off' value="">
                    </div>

                    <label for="confirm-password" class="form__label form__label--required">Confirmar nueva
                        contraseña</label><br>
                    <div class="input-group mb-3">
                        <span class="input-group-text form__icon" id="confirm-password-icon"><i
                                class="bi bi-shield-lock"></i></span>
                        <input type="password" name="confirm-password"
                            class="form-control form__input form__input--item"
                            placeholder="Confirma tu nueva contraseña" aria-label="Confirmar nueva contraseña"
                            aria-describedby="confirm-password-icon" autocomplete='off' value="">
                    </div>

                    <div class="form__actions flex-center-full gap-3">
                        <button class="form__button button--back" type="button">
                            <a href="./dashboard/<?php echo Date('m/Y') ?>" class="text-decoration-none text-black"><i
                                    class="bi bi-arrow-left-square"></i> Regresar</a>
                        </button>
                        <button class="form__button form__button--submit" type="submit">Cambiar contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>


    <script src="../js/components/location.js" type="module"></script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>