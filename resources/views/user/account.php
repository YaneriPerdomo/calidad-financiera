<?php // Vista del panel de control del usuario 
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cuenta | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/css/pages/_profile.css">
    <link rel="stylesheet" href="../../public/css/utilities.css">
    <link rel="stylesheet" href="../../public/css/layouts/_base.css">
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
                <div class="functionality functionality--account-delete">
                    <button class="button--back" type="button">
                        <a href="./dashboard/<?php echo Date('m/Y') ?>" class="text-decoration-none text-black"> <i
                                class="bi bi-arrow-left-square"></i> Regresar</a>
                    </button>
                    <legend class="functionality__title functionality__title--account-delete"><b>Eliminar cuenta</b>
                    </legend>
                    <p class="functionality__description functionality__description--account-delete "> Controla tu
                        información protegiendo tu privacidad y recuerda que puedes actualizar tu perfil en cualquier
                        momento. </p>

                </div>
            </div>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>


    <script src="../js/components/location_user.js" type="module"></script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>