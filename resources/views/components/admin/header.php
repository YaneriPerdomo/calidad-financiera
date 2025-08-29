<header class="header-index">
    <div class="logo">
        <figure class="m-0">
            <img src="<?php echo $header_jump ?>../img/logo.png" alt="" style="  width: 88px;">
        </figure>
    </div>
    <div class="profile">
        <span><?php echo '¡Hola, ' . $_SESSION['usuario'] . '!' ?? '' ?></span>
        <div class="btn-group dropstart">
            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static"
                aria-expanded="false">
                <img src=" " class="header-img img-fluid" alt="">
            </button>
            <ul class="dropdown-menu p-3">
                <li class="flex-center-full flex-column dropdown-menu__information">

                    <img src=" " class="dropdown-menu__img" alt="">
                    <h2 style="  text-align: center;"> <?php echo '¡Hola, ' . $_SESSION['usuario'] . '!' ?? '' ?></h2>
                </li>
                <li class="text-center">
                    <a href="<?php echo $header_jump ?>profile" class="text-decoration-none text__blue"><button
                            class="dropdown-item" type="button">Administrar tu cuenta</button></a>
                </li>
                <li clasS="text-center">
                    <a  href="<?php echo $header_break_login ?>signOut" 
                        class="text-decoration-none"> 
                            <button
                                class="dropdown-item text--red" 
                                type="button">  Cerrar sesion 
                            </button>
                        </a>
                </li>
            </ul>
        </div>
    </div>

</header>