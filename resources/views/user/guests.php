<?php // Vista del panel de control del usuario
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion de invitado | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_buttons.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_footer.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_header.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/layouts/_ico.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_table.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_body.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_body.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_sidebar.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_pagination.css">
         <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_modal.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/pages/_about.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/utilities.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/layouts/_base.css">
        
    <link rel="icon" type="image/x-icon"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../img/logo.ico">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_searchInput.css">
    <link rel="stylesheet" href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_presentation-system-web.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    include '../resources/views/components/user/header.php';
?>
    <main class="main main--content-login">
        <?php
    include '../resources/views/components/user/sidebar.php';
?>
        <div class="style-border">
            <section class="flex-space-between ">
                <div>
                    <h1 class="fs-3">
                        <strong>Gestion de invitados</strong>
                    </h1>
                    <div class="search ">
                        <div class="input-group  search__seeker">
                            <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                <i class="bi bi-search search__icon"></i>
                            </span>
                            <input type="text" name="name" id="name"
                                class="search__input search__input--text form-control"
                                placeholder="Ingresa el nombre del invitado para buscar" 
                                aria-label="Ingresa el nombre del invitado para buscar" 
                                autofocus
                                data-name="<?php echo trim($nameUser) ?>" 
                                data-url = "/calidad-financiera/public/user/guests"
                                value="<?php echo trim($nameUser) ?>">
                        </div>
                        <div class="search__action">
                            <button class="button search__button button--azul color-white" type="button">
                                Buscar
                            </button>
                        </div>
                    </div>
                    <script type="module"
                        src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/components/button_search.js"></script>
                </div>
                <div class="button-pdf">
                    <button type="button" class="button--orange m-2" title="Descargar un reporte en PDF" data-model='js_report'>
                                           Generar Reporte 

                    </button>
                    <button type="button" class="button--azul" title="Agregar persona invitada">
                        <a href="<?php echo $searchUsers == false ? '../' : '../../' ?>guest/add"
                            class="text-decoration-none text-white">+Agregar</a>
                    </button>
                </div>
            </section>
            <?php if (isset($_SESSION['alert-danger'])) {
                echo '
                        <div class="alert alert-danger" role="alert">
                            '.$_SESSION['alert-danger'].'
                        </div>';
                unset($_SESSION['alert-danger']);
            }
?>
            <?php
    if (isset($_SESSION['alert-success'])) {
        echo '
                                    <div class="alert alert-success" role="alert">
                                        '.$_SESSION['alert-success'].' </div>';
        unset($_SESSION['alert-success']);
    }
?>
            <section class='table'>
                <table class='dataTable'>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo electronico</th>
                            <th>Estado</th>
                            <th>Fecha de creacion</th>
                            <th>Ultimo acceso</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <?php
        echo $HTML;
?>
        </div>
        <!-- #region -->
    </main>
    <?php
    include '../resources/views/components/footer.php';
?>

 <div class="model model--selection-report" style="display:none">
    <form action="<?php echo $searchUsers == false ? '../' : '../../' ?>guest/data-report" method="post" class="model__form">

        <div class="model__header  bg-dorado">
            <span class="model_title">
                Generar Reporte de Usuarios
            </span>
        </div>
        <div class="model__body">
            
            <p class="form__label">Seleccione el formato para descargar el reporte de usuarios.</p>

            <label for="report-format" class="form__label form__label--required">Formato de Salida</label><br>
            <div class="input-group w-100">
                <span class="input-group-text form__icon" id="basic-addon1"><i class="bi bi-file-earmark-spreadsheet"></i></span>
                <select id="report-format" name="report_format" class="form-control form__select" required>
                    <option value="0">-- Seleccione un formato --</option>
                    <option value="1">PDF</option>
                    <option value="2">Excel (CSV)</option>
                </select>
            </div>
            
        </div>
        <div class="model__buttons" style="margin-left: 1rem; margin-right: 1rem;">
            <button class="model__exit model__exit-report button__exit button--cancel" type="button">
                Cancelar
            </button>

            <button class="model__submit button--orange">
                Descargar Reporte
            </button>
        </div>
    </form>
</div>
   <div class="model model__delete-user" style="display:none">
<form action="<?php echo $header_break; ?>guest/delete" method="post" class="model__form">
    <input type="hidden" name="id_usuario">
    <input type="hidden" name="id_invitado">
    <div class="model__header">
        <span class="model_title">
            Confirmar Eliminación de Cuenta de Invitado
        </span>
    </div>
    <div class="model__body">
        <p class="model__p">
            Advertencia: Está a punto de eliminar esta cuenta de invitado de forma permanente. 
            
            Esta acción es irreversible y resultará en la pérdida total de los datos asociados y el acceso al sistema. Una vez eliminada, la cuenta no podrá recuperarse ni utilizarse para iniciar sesión.
        </p>
    </div>
    <div class="model__buttons">
        <button class="model_exit button__exit btn-exit button--cancel" type="button">
            No, Mantener la Cuenta
        </button>
        <button class="model__submit button--delete ">
            Sí, Eliminar Permanentemente
        </button>
    </div>
</form>
</div>
<script>
    
        let modalReport = document.querySelector(".model--selection-report");
     let buttonExitModal = document.querySelector('.button__exit');
        let modal = document.querySelector(".model__delete-user");
        let dataModelJs = document.querySelector("[data-model='js']");
        let inputIdPerson = document.querySelector('[name="id_invitado"]')
        let inputIdUser = document.querySelector('[name="id_usuario"]');
      

        document.addEventListener('click', e => {

            if(e.target.matches('.model__exit-report')){
                modalReport.style.display = 'none'
            }
          
            if (e.target.matches("[data-model='js_report']")) {
                modalReport.removeAttribute('style');
            }

             if (e.target.matches("[data-model='js_delete_guest']")) {
                modal.removeAttribute('style');
                inputIdUser.value = e.target.dataset.idUser;
                inputIdPerson.value = e.target.getAttribute('data-id-guest');
            }

            if(e.target.matches('.button__exit')){
                modal.style.display = 'none'
            }
        })
                    
       

         

        buttonExitModal.addEventListener("click", e => {
            modal.style.display = 'none'
        })

</script>
    
   
                      <script>
       
                    </script>
   
  
    <?php
include '../resources/views/components/presentation.php';
?>

    <script src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/components/presentation_system_web.js" type="module"></script>
    <script src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/components/location_user.js"
        type="module"></script>
    <script src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/cdn.js" type="module"></script>
 
</body>

</html>