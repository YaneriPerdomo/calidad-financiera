
<?php
                session_start();

?>
<!doctype html>
<html lang="es" class="full-heigh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear una Cuenta | Calidad Financiera</title>
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
    <style>
          .logo{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>
<body>
  
    <main class="main main--content-create">
      <div>
           <section class="logo">
           <a href="./index">
            <figure class="m-0">
            <img src="./img/logo.png" alt="" style="  width: 238px;" draggable="false" >
        </figure>
           </a>
                    <p class="title-green p-0  " style="  margin: 0.5rem 1rem 0.5rem 1rem;">
                        Regístrate en minutos y comienza a alcanzar tus objetivos
                    </p>

    </section>  
          <form action="create-account " method='POST' class="form-create m-3" style="  margin-top: 0.5rem !important;">
            <legend class="form-create__title font-bold m-0">Crea una Cuenta</legend>
              <?php
                 if (isset($_SESSION['alert-danger'])) {
                    echo '
                    <div class="alert alert-danger m-0" role="alert">
                        '.$_SESSION['alert-danger'].'
                    </div>';
                    unset($_SESSION['alert-danger']);
                }
            ?>
             <?php
                 if (isset($_SESSION['alert-success'])) {
                    echo '
                    <div class="alert alert-success m-0" role="alert">
                        '.$_SESSION['alert-success'].'
                    </div>';
                    unset($_SESSION['alert-success']);
                }
            ?>
           
            <div class="form-create__content">
                <div class="form__data">
                    <div class="row form__row">
                        <div class="col-12 col-lg-4 form__col form__col--title">
                            <span class="form__subtitle">Datos Personales: </span>
                        </div>
                        <div class="col-12 col-lg-8 form__col form__col--inputs">
                            <label for="name" class="form__label form__label--required">Nombre</label><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i
                                        class="bi bi-person-circle"></i></span>
                                <input type="text" name="name" class="form__input form__input--item form-control"
                                    placeholder="Ingresa tu nombre" aria-label="Tu nombre"
                                    aria-describedby="basic-addon1" value="">
                            </div>
                            <label for="lastname" class="form__label form__label--required">Apellido</label><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i
                                        class="bi bi-person-badge"></i></span>
                                <input type="text" name="lastname" class="form__input form__input--item form-control"
                                    placeholder="Ingresa tu apellido" aria-label="Tu apellido"
                                    aria-describedby="basic-addon1" value="">
                            </div>
                            <label for="email" class="form__label form__label--required">Correo Electrónico</label><br>
                            <div class="input-group mb-3">
                                <span class="form__icon input-group-text" id="basic-addon1"><i
                                        class="bi bi-envelope"></i></span>
                                <input type="text" name="email" class="form__input form__input--item form-control"
                                    placeholder="ejemplo@dominio.com" aria-label="Correo electrónico"
                                    aria-describedby="basic-addon1" value="">
                            </div>
                            <label for="actividad" class="form__label form__label--required">Actividad</label><br>
                            <div class="input-group">
                                <span class="input-group-text form__icon"><i class="bi bi-person-workspace"></i></span>
                                <select id="actividad" name="actividad"
                                    class="form-control form__input form__input--select"  >
                                    <option value="" disabled selected> Selecciona una actividad</option>
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
                                <span class="form__subtitle">Datos de la Cuenta: </span>
                            </div>
                            <div class="col-12 col-lg-8 form__col form__col--inputs">
                                <label for="user" class="form__label form__label--required">Nombre de
                                    Usuario</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-person-fill"></i></span>
                                    <input type="text" name="user" class="form__input form__input--item form-control"
                                        placeholder="Crea tu nombre de usuario" aria-label="Nombre de usuario"
                                        aria-describedby="basic-addon1" value="">
                                </div>
                                <label for="password" class="form__label form__label--required">Contraseña</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password"
                                        class="form__input form__input--item form-control"
                                        placeholder="Crea una contraseña segura" aria-label="Contraseña"
                                        aria-describedby="basic-addon1" value="">
                                </div>
                                <label for="confirm-password" class="form__label form__label--required">Confirmar
                                    Contraseña</label><br>
                                <div class="input-group mb-3">
                                    <span class="form__icon input-group-text" id="basic-addon1"><i
                                            class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="confirm_password"
                                        class="form__input form__input--item form-control"
                                        placeholder="Confirma tu contraseña" aria-label="Confirmar contraseña"
                                        aria-describedby="basic-addon1" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="form-create__button-send button-r">
                        <i class="bi bi-person-plus-fill form-create__icon"></i>
                        <span class="form--login__text">Registrarme</span>
                    </button>
                    <div class="form-create__link p-2 text-center ">
                        ¿Ya tienes una cuenta?
                        <a href="./login" class="form--create__link-text">¡Accede ahora!</a>
                    </div>
                </div>
            </div>
            <div class="ornament"></div>
        </form>
      </div>
    </main>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>