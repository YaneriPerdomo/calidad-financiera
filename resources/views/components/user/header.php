<header class="header-index">
    <div class="logo">
    <a href="<?php echo $sidebar_jump.'dashboard/'. date('m/Y')?>">
            <figure class="m-0">
            <img src="<?php echo $header_break ?>../img/logo.png" draggable="false" 
            alt="" 
            style="  width: 88px;">
        </figure>
        </a>
    </div>
    <div class="profile">
        <span class=""><?php echo '¡Hola, '.$_SESSION['nombre'].'!' ?? '' ?></span>
        <div class="btn-group dropstart">

            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static"
                aria-expanded="false">
                <img src=" " class="header-img img-fluid" alt="">
            </button>
            <ul class="dropdown-menu p-3">
                <li class="flex-center-full flex-column dropdown-menu__information">
                    <span class="dropdown-menu__information-email"> <?php echo $_SESSION['correo_electronico'] ?? '' ?>
                    </span>
                    <img src=" " class="dropdown-menu__img" alt="">
                    <h2 style="  text-align: center;"> <?php echo '¡Hola, '.$_SESSION['nombre'].'!' ?? '' ?></h2>
                </li>
                <li class="text-center">
                    <a href="<?php echo $header_break ?? './' ?>profile" class="text-decoration-none text__blue"><button
                            class="dropdown-item" type="button">Administrar tu Cuenta</button></a>
                </li>
                <li clasS="text-center">
                    <a href="<?php echo $header_break_login ?>signOut" class="text-decoration-none">
                        <button class="dropdown-item text--red"" type=" button">
                            Cerrar
                            Sesión
                        </button>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</header>