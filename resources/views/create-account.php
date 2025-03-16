<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear una cuenta | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../public/css/components/_footer.css">
    <link rel="stylesheet" href="../public/css/components/_header.css">
    <link rel="stylesheet" href="../public/css/pages/_login-createAccount.css">
    <link rel="stylesheet" href="../public/css/utilities.css">
    <link rel="stylesheet" href="../public/css/layouts/_base.css">

</head>

<body>
    <header class="header-index">
        <div class="logo">
            Logo
        </div>
        <div>
            <nav>
                <button class="btn button-r font-bold">
                    <a href="" class="text-decoration-none">COMENZAR</a>
                </button>
            </nav>
        </div>
    </header>
    <main class="main main--content-create">
        <form action="create-account" method='POST' class="form-create">

            <legend class="form-create__title font-bold fs-1 m-0">Crea una cuenta</legend>

            <p class="title-green p-0 m-2">Regístrate en minutos y comienza a alcanzar tus objetivos</p>
            <div class="form-create__content">
                <div class="form-create__item">
                    <label for="user" class="form-create__label">Usuario</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="text" name="user" id="user" class="form-control form--login__input" placeholder="Introduzca el usuario"
                            aria-label="Username" aria-describedby="basic-addon1" autofocus="true">
                    </div>
                </div>
                
                <div class="form-create__item">
                    <label for="email" class="form-create__label">Correo electrónico</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="email" name="email" id="email" class="form-control form--login__input" placeholder="Introduzca el usuario"
                            aria-label="Username" aria-describedby="basic-addon1" autofocus="true">
                    </div>
                </div>
                <div class="form-create__item">
                    <label for="" class="form-create__label">Actividad</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <select id="actividad" name="actividad" class="form-control" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="1">Propietario o Socio</option>
                            <option value="2">Gerente o Supervisor</option>
                            <option value="3">Empleado</option>
                            <option value="4">Profesional</option>
                            <option value="5">Docente</option>
                            <option value="6">Estudiante</option>
                        </select>
                    </div>

                </div>
                <div class="form-create__item">
                    <label for="password" class="form-create__label">Contraseña</label><br>
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                        <input type="password" name="password" id="password" class="form-control form--login__input" placeholder="Introduzca el usuario"
                            aria-label="Username" aria-describedby="basic-addon1" autofocus="true">
                    </div>
                </div>
                <!--
                <div class="form-create__item">
                    <input type="checkbox" name="" id="">
                    <span>Acepto Términos y Condiciones de Uso</span>
                </div>
                !-->
                <button type="submit" class="form-create__button-send button-r">
                    <i class="fas fa-sign-in-alt form-create__icon"></i>
                    <span class="form--login__text">Registrarte</span>
                </button>
                <div class="form-create__link p-2 text-center ">
                    ¿Ya tienes una cuenta?
                    <a href="./login" class="form--create__link-text">¡Accede ahora!</a>
                </div>
            </div>
            <div class="ornament">

            </div>
        </form>
    </main>
    <footer class="py-2">
        <div>
            <div class="mt-3 text-center">
                <p class="text-white">© 2025 Sonidos de habla | Todos los derechos reservados | Política de privacidad | Aviso
                    legal | Política de cookies | Contacto</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>