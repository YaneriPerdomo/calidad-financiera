<?php // Vista del panel de control del usuario 
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar cuenta | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/css/pages/_profile.css">
    <link rel="stylesheet" href="../../public/css/utilities.css">
    <link rel="stylesheet" href="../../public/css/components/_presentation-system-web.css">

    <link rel="stylesheet" href="../../public/css/layouts/_ico.css">
    <link rel="stylesheet" href="../../public/css/layouts/_base.css">
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
                <div class="functionality functionality--account-delete">
                    <button class="button--back" type="button">
                        <a href="./dashboard/<?php echo Date('m/Y') ?>" class="text-decoration-none text-black"> 
                                <i class="bi bi-arrow-left-square-fill"></i> Regresar</a>
                    </button>
                    <legend class="functionality__title functionality__title--account-delete"><b>Eliminar cuenta</b>
                    </legend>
                    <p class="functionality__description functionality__description--account-delete "> Controla tu
                        información protegiendo tu privacidad y recuerda que puedes actualizar tu perfil en cualquier
                        momento. </p>
                    <form action="../user/account-delete" class="functionality__description-form" method="post">
                        <button class="functionality__description-button button--delete">Eliminar cuenta</button>
                    </form>
                    <script>
                        let formDeleteAccount = document.querySelector('.functionality__description-form');
                        formDeleteAccount.addEventListener('submit', e => {
                            e.preventDefault();
                            let resp = confirm('¿Esta seguro que quiere eliminar tu cuenta de calidad financiera por completo?');
                            if (resp) {
                                e.target.submit();
                            }

                        })
                    </script>
                </div>
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