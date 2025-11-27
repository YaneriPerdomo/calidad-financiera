<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar Cuenta | Calidad Financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../public/css/components/_modal.css">
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
                        <a href="./dashboard/<?php echo date('m/Y') ?>" class="text-decoration-none text-black"> 
                                <i class="bi bi-arrow-left-square"></i> Regresar</a>
                    </button>
                    <legend class="functionality__title functionality__title--account-delete"><b>Eliminar Cuenta</b>
                    </legend>
                    <p class="functionality__description functionality__description--account-delete "> Controla tu
                        información protegiendo tu privacidad y recuerda que puedes actualizar tu perfil en cualquier
                        momento. </p>
                         <button class="functionality__description-button button--delete"data-model='js'>
                         <i class="bi bi-trash "></i>
                         Eliminar Cuenta</button>
    
                </div>
            </div>
        </div>
    </main>

      <div class="model" style="display:none">
    <form action="../user/account-delete" method="post" class="model__form">
        <input type="hidden" name="id_usuario">
        <input type="hidden" name="id_persona">
        <div class="model__header">
            <span class="model_title">
                    ¿Seguro quiere eliminar la cuenta?
            </span>
        </div>
        <div class="model__body">
            <p class="model__p">
                ¡Atención! Está a punto de eliminar su cuenta de manera permanente. Esta acción es irreversible. Después de la eliminación, no podrá volver a iniciar sesión.
            </p>
        </div>
        <div class="model__buttons">
            <button class="model_exit button__exit btn-exit button--cancel" type="button">
                <i class="bi bi-arrow-left-square"></i>
                No, Cancelar
            </button>
            <button class="model__submit button--delete ">
                <i class="bi bi-trash "></i>
                Sí, Eliminar Permanentemente
            </button>
        </div>
    </form>
</div>
                      <script>
                        let buttonExitModal = document.querySelector('.button__exit');
        let modal = document.querySelector(".model");
        let dataModelJs = document.querySelector("[data-model='js']");
   

        document.addEventListener('click', e => {
            if (e.target.matches("[data-model='js']")) {

                modal.removeAttribute('style');
             
            }
        })

        buttonExitModal.addEventListener("click", e => {
            modal.style.display = 'none'
        })
                    </script>
    <?php
    include '../resources/views/components/footer.php';
?>
     

  

    <script src="../js/components/location_user.js" type="module"></script>
    <script src="../js/cdn.js" type="module"></script>
 
</body>

</html>