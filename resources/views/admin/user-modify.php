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
    <link rel="stylesheet" href="../../css/layouts/_base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
            <form action="../<?php echo  $data['id_usuario']?>-user/modify" method="post" class="form">
                <?php

            
                    echo '<input type="hidden" name="id_user" value="' . $data['id_usuario'] . '">';
                
                ?>
                <?php
                echo !is_array($data) ? '<input type="hidden" name="id_person"value="' . $data['id_persona'] . '">' : '' ?>
                <legend class="form__title">
                    <h1><b> Modificar usuario </b></h1>
                </legend>
                <p class="form__description"> Controla tu información protegiendo tu privacidad y recuerda que puedes actualizar tu perfil en cualquier momento. </p>
                <hr class="form__separator">
                <div class="form__data">
                    <div class="row form__row">
                        <div class="col-12 col-lg-4 form__col form__col--title">
                            <span class="form__subtitle">Datos personales: </span>
                        </div>
                        <div class="col-12 col-lg-8 form__col form__col--inputs">
                            <label for="name" class="form__label form__label--required">Nombre</label><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form__input form__input--item form-control"
                                    placeholder="¿Como se llama tu niño/a? 🤔" aria-label="Username"
                                    aria-describedby="basic-addon1"
                                    value="<?php echo $data['nombre'] ?? '' ?> ">
                            </div>
                            <label for="lastname" class="form__label form__label--required">Apellido</label><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                <input type="text" name="lastname" class="form__input form__input--item form-control"
                                    placeholder="¿Como se llama tu niño/a? 🤔" aria-label="Username"
                                    aria-describedby="basic-addon1"
                                    value="<?php echo $data['apellido'] ?? '' ?>">
                            </div>
                            <label for="email" class="form__label form__label--required">Correo electrónico</label><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                <input type="text" name="email" class="form__input form__input--item form-control"
                                    placeholder="¿Como se llama tu niño/a? 🤔" aria-label="Username"
                                    aria-describedby="basic-addon1"
                                    value="<?php echo $data['correo_electronico'] ?? '' ?> ">
                            </div>
                            <label for="actividad" class="form__label form__label--required">Actividad</label><br>
                            <div class="input-group">
                                <span class="input-group-text form__icon"><i class="bi bi-person"></i></span>
                                <select id="actividad" name="id_actividad" class=" form-control form__input form__input--select" required>
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
                                <label for="user" class="form__label form__label--required">Usuario</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                    <input
                                        type="text"
                                        name="user"
                                        class="form__input form__input--item form-control"
                                        placeholder="¿Como se llama tu niño/a? 🤔"
                                        aria-label="Username"
                                        aria-describedby="basic-addon1"
                                        value="<?php echo $data['usuario'] ?? '' ?> ">
                                </div>
                                <label for="password" class="form__label form__label--required">Contraseña</label><br>
                                <?php

                                echo empty(!$data) ? "<small>Si no desea cambiar su contraseña, deja los campos de 'Contraseña' y 'Confirma contraseña' vacíos.</small>" : '';

                                ?>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                    <input
                                        type="text"
                                        name="new-password"
                                        class="form__input form__input--item form-control"
                                        placeholder="Usuario"
                                        aria-label="Username"
                                        aria-describedby="basic-addon1"
                                        value="">
                                </div>
                                <label for="confirm-password" class="form__label form__label--required">Confirmar contraseña</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                    <input
                                        type="text"
                                        name="confirm-password"
                                        class="form__input form__input--item form-control"
                                        placeholder="Usuario"
                                        aria-label="Username"
                                        aria-describedby="basic-addon1"
                                        value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="form__separator">
                    <div class="flex-center-full form__actions gap-3">
                        <button class="form__button button--back" type="button">

                            <a href="../dashboard/1" class="text-black text-decoration-none"> <i class="bi bi-arrow-left-square"></i> Regresar</a>
                        </button>
                        <button class="form__button form__button--submit" type="submit">Actualizar datos</button>
                    </div>
            </form>
        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>




    <script src="<?php echo empty(!$data) ? '../../../' : '../../' ?>js/components/location.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>