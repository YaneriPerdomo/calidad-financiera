 
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo empty(!$data) ? 'Modificar' : 'Agregar' ?> Persona Invitada | Calidad Financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/components/_buttons.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/components/_footer.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/components/_header.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/components/_body.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/components/_form.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/components/_sidebar.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/pages/_about.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/pages/_guest.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/utilities.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/layouts/_base.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/components/_presentation-system-web.css">
    <link rel="stylesheet" href="<?php echo $style_jump ?>css/layouts/_ico.css">
    <link rel="icon" type="image/x-icon" href="<?php echo $style_jump ?>/img/logo.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        [name="status"], [for="1"], [for="0"]{
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    include '../resources/views/components/user/header.php';
    ?>
    <main class="main main--content-login">
        <?php
        include '../resources/views/components/user/sidebar.php';
        ?>
        <div class="flex-center-full w-100">
            <form action="<?php
            echo $title == "Modificar" ? '../../guest' : '../guest'
                ?>" method="post" class="form form--guest">
                <input type="hidden" name="operation" value="<?php echo $operation ?>">
                <?php
                if ($title == 'Modificar') {
                    echo '<input type="hidden" name="id_user" value="' . $data['id_usuario'] . '">';
                }
                ?>
                <?php
                echo $title == 'Modificar' ? '<input type="hidden" name="id_person"value="' . $data['id_persona'] . '">' : '' ?>
                <legend class="form__title m-0">
                    <b> <?php
                    echo $title ?> Persona Invitada</b>
                </legend>
                <p class="form__description"> Al <?php echo $title == 'Modificar' ? 'modificar':'registrar';?> un usuario invitado, usted autoriza la visualización de su información financiera y transacciones. 
                    Ejerza el control total sobre la privacidad y recuerde que puede actualizar o revocar este acceso desde su perfil en cualquier momento. </p>
                           <?php
                    if (isset($_SESSION['alert-danger'])) {
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
                <hr class="form__separator">
               <div class="form__data">
    <div class="row form__row">
        <div class="col-12 col-lg-4 form__col form__col--title">
            <span class="form__subtitle">Datos Personales: </span>
        </div>
        <div class="col-12 col-lg-8 form__col form__col--inputs">
            <label for="name" class="form__label form__label--required">Nombre</label><br>
            <div class="input-group mb-3">
                <span class="form__icon input-group-text"><i class="bi bi-person-circle"></i></span>
                <input type="text" name="name" class="form__input form__input--item form-control"
                    placeholder="Su nombre" aria-label="Nombre" value="<?php echo $data['nombre'] ?? '' ?>">
            </div>
            <label for="lastname" class="form__label form__label--required">Apellido</label><br>
            <div class="input-group mb-3">
                <span class="form__icon input-group-text"><i class="bi bi-person-badge"></i></span>
                <input type="text" name="lastname" class="form__input form__input--item form-control"
                    placeholder="Su apellido" aria-label="Apellido" value="<?php echo $data['apellido'] ?? ''?>">
            </div>
            <label for="email" class="form__label form__label--required">Correo Electrónico</label><br>
            <div class="input-group mb-3">
                <span class="form__icon input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input type="text" name="email" class="form__input form__input--item form-control"
                    placeholder="Su correo electrónico" aria-label="Correo electrónico"
                    value="<?php echo $data['correo_electronico'] ?? '' ?>">
            </div>
        </div>

    </div>
    <hr class="form__separator">
    <div class="row form__row">
        <div class="col-12 col-lg-4 form__col form__col--title">
            <span class="form__subtitle">Datos de la Cuenta: </span>
        </div>
        <div class="col-12 col-lg-8 form__col form__col--inputs">
            <label for="user" class="form__label form__label--required">Usuario</label><br>
            <div class="input-group mb-3">
                <span class="form__icon input-group-text"><i class="bi bi-person-fill"></i></span>
                <input type="text" name="user" class="form__input form__input--item form-control"
                    placeholder="Su nombre de usuario" aria-label="Nombre de usuario"
                    value="<?php echo $data['usuario'] ?? '' ?>">
            </div>
            <?php
            echo $title != 'Agregar' ? "<small>Para cambiar su contraseña, ingresa una nueva. De lo contrario, deja los campos vacíos.</small> <br>" : '';
            ?>
            <label for="password"
                class="form__label <?php echo $title == 'Agregar' ? " form__label--required" : ''; ?> ">Contraseña</label><br>
            <div class="input-group mb-3">
                <span class="form__icon input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" name="password"
                    class="form__input form__input--item form-control" placeholder="Crea una contraseña"
                    aria-label="Contraseña" value="">
            </div>
            <label for="confirm-password" class="form__label 
                <?php echo $title == 'Agregar' ? " form__label--required" : ''; ?> ">Confirmar
                Contraseña</label><br>
            <div class="input-group mb-3">
                <span class="form__icon input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" name="confirm_password"
                    class="form__input form__input--item form-control" placeholder="Confirma su contraseña"
                    aria-label="Confirmar contraseña" value="">
            </div>
                <label for="status">Estado de la Cuenta</label>
                <div style="display:flex; gap:0.5rem"> 
                <div>
                    <label for="1">Activo/a</label>
                    <input type="radio" name="status" checked value="1" id="1"
                    <?php
                    if ($title != 'Agregar') {
                        echo $data['estado'] == 1 ? 'checked' : '';
                    }
                    ?>
                    >
                </div>
                <div>
                    <label for="0">Inactivo/a</label>
                    <input type="radio" name="status" value="0" id="0"
                    <?php
                    if ($title != 'Agregar') {
                        echo $data['estado'] == 0 ? 'checked' : '';
                    }
                    ?>
                    >
                </div>
  
            </div>
        </div>
    </div>
</div>
                <hr class="form__separator">
                <div class="flex-center-full form__actions gap-3">
                    <button class="form__button button--back" type="button">

                        <a href="<?php echo $button_back ?>guests/1" class="text-black text-decoration-none"> 
                            <i class="bi bi-arrow-left-square"></i> Regresar</a>
                    </button>
                    <button class="form__button form__button--submit" type="submit">
                        
                        <i class="<?php echo $title == 'Agregar' ? 'bi bi-person-plus' : 'bi bi-person-lines-fill'?>"></i> <?php echo $title;?> Persona Invitada</button>
                </div>
            </form>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>
  

     <script src="<?php echo $js_jump ?>js/cdn.js" type="module"></script>
    <script src="<?php echo $js_jump ?>js/components/location_user.js" type="module"></script>
  
</body>

</html>