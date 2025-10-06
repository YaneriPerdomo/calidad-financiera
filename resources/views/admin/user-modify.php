<?php // Vista del panel de control del usuario 
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Modificar usuario | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../css/components/_buttons.css">
    <link rel="stylesheet" href="../../css/components/_footer.css">
    <link rel="stylesheet" href="../../css/components/_header.css">
    <link rel="stylesheet" href="../../css/components/_form.css">
    <link rel="stylesheet" href="../../css/components/_body.css">
    <link rel="stylesheet" href="../../css/components/_sidebar.css">
    <link rel="stylesheet" href="../../css/pages/_about.css">
    <link rel="stylesheet" href="../../css/pages/_guest.css">
    <link rel="stylesheet" href="../../css/utilities.css">
    <link rel="stylesheet" href="../../css/components/_presentation-system-web.css">
    <link rel="stylesheet" href="../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../css/layouts/_ico.css">
    <link rel="icon" type="image/x-icon" href="../../../public/img/logo.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    include '../resources/views/components/admin/header.php';
    ?>
    <main class="main main--content-login">
        <?php
        include '../resources/views/components/admin/sidebar.php';
        ?>
        <div class="flex-center-full w-100">
            <form action="../<?php echo $data['id_usuario'] ?>-user/modify" method="post" class="form">
                <?php
                echo '<input type="hidden" name="id_user" value="' . trim($data['id_usuario']) . '">';
                ?>
                <?php
                echo !is_array($data) ? '<input type="hidden" name="id_person"value="' . $data['id_persona'] . '">' : '' ?>
                <legend class="form__title">
                     <b> Modificar usuario </b> 
                </legend>
                <input type="hidden" name="rol" value="admin">
                <p class="form__description"> Controla tu información protegiendo tu privacidad y recuerda que puedes
                    actualizar tu perfil en cualquier momento. </p>
                <hr class="form__separator">
               <div class="form__data">
    <div class="row form__row">
        <div class="col-12 col-lg-4 form__col form__col--title">
            <span class="form__subtitle">Datos personales: </span>
        </div>
        <div class="col-12 col-lg-8 form__col form__col--inputs">
            <label for="name" class="form__label form__label--required">Nombre</label><br>
            <div class="input-group mb-3">
                <span class="form__icon input-group-text"><i class="bi bi-person-circle"></i></span>
                <input type="text" name="name" class="form__input form__input--item form-control"
                    placeholder="Tu nombre" aria-label="Nombre" value="<?php echo trim($data['nombre']) ?? '' ?>">
            </div>
            <label for="lastname" class="form__label form__label--required">Apellido</label><br>
            <div class="input-group mb-3">
                <span class="form__icon input-group-text"><i class="bi bi-person-badge"></i></span>
                <input type="text" name="lastname" class="form__input form__input--item form-control"
                    placeholder="Tu apellido" aria-label="Apellido" value="<?php echo trim($data['apellido']) ?? '' ?>">
            </div>
            <label for="email" class="form__label form__label--required">Correo electrónico</label><br>
            <div class="input-group mb-3">
                <span class="form__icon input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input type="text" name="email" class="form__input form__input--item form-control"
                    placeholder="ejemplo@correo.com" aria-label="Correo electrónico"
                    value="<?php echo trim($data['correo_electronico']) ?? '' ?>">
            </div>
            <label for="actividad" class="form__label form__label--required">Actividad</label><br>
            <div class="input-group">
                <span class="input-group-text form__icon"><i class="bi bi-person-workspace"></i></span>
                <select id="actividad" name="id_actividad" class="form-control form__input form__input--select" required>
                    <?php
                    $todas_actividades = array(
                        0 => 'Seleccione una opción',
                        1 => 'Propietario o Socio',
                        2 => 'Gerente o Supervisor',
                        3 => 'Empleado',
                        4 => 'Profesional',
                        5 => 'Docente',
                        6 => 'Estudiante',
                        7 => 'Otro'
                    );

                    foreach ($todas_actividades as $key => $value) {
                        $disabled = ($key == 0) ? 'disabled' : '';
                        $selected = ($key == $data['id_actividad']) ? 'selected' : '';
                        echo '<option value ="' . $key . '" ' . $disabled . ' ' . $selected . ' > ' . $value . ' </option>';
                    }
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
                <label for="user" class="form__label form__label--required">Nombre de usuario</label><br>
                <div class="input-group mb-3">
                    <span class="form__icon input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="user" class="form__input form__input--item form-control"
                        placeholder="Tu nombre de usuario" aria-label="Nombre de usuario"
                        value="<?php echo trim($data['usuario']) ?? '' ?>">
                </div>
                <?php
                echo empty(!$data) ? "<small>Para cambiar tu contraseña, ingresa una nueva. De lo contrario, deja estos campos vacíos.</small><br>" : '';
                ?>
                <label for="password" class="form__label">Contraseña</label><br>
                <div class="input-group mb-3">
                    <span class="form__icon input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="new-password"
                        class="form__input form__input--item form-control" placeholder="Nueva contraseña"
                        aria-label="Nueva contraseña" value="">
                </div>
                <label for="confirm-password" class="form__label">Confirmar contraseña</label><br>
                <div class="input-group mb-3">
                    <span class="form__icon input-group-text"><i class="bi bi-shield-lock"></i></span>
                    <input type="password" name="confirm-password"
                        class="form__input form__input--item form-control" placeholder="Confirma tu nueva contraseña"
                        aria-label="Confirmar contraseña" value="">
                </div>
                <div>
                    <label for="status">Estado de la cuenta </label>
                    <input type="checkbox" name="status" <?php echo $data['estado'] == 1 ? 'checked' : '' ?>
                        value="1" id="status">
                </div>
            </div>
        </div>
    </div>
    <hr class="form__separator">
    <div class="flex-center-full form__actions gap-3">
        <button class="form__button button--back" type="button">
            <a href="../users/1" class="text-black text-decoration-none"> <i class="bi bi-arrow-left-square-fill"></i> Regresar</a>
        </button>
        <button class="form__button form__button--submit" type="submit"> <i class="bi bi-check-circle-fill"></i> Guardar cambios</button>
    </div>
</div>
            </form>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>

                                    
    <?php 
    include '../resources/views/components/admin/presentation.php';
    ?>

    <script src="<?php echo empty(!$data) ? '../../../' : '../../' ?>public/js/components/presentation_system_web.js" type="module"></script>


    <script src="<?php echo empty(!$data) ? '../../../' : '../../' ?>public/js/components/location_admin.js"
        type="module"></script>
    <script src="<?php echo empty(!$data) ? '../../../' : '../../' ?>public/js/cdn.js" type="module"></script>

    
</body>

</html>