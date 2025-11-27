<header class="header-index">
    <div class="logo">
         Calidad Financiera
    </div>
    <div class="profile">
        <div class="btn-group dropstart">
            <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"
                data-bs-display="static" aria-expanded="false">
                <img src=" "  draggable="false" class="header-img img-fluid" alt="">
            </button>
            <ul class="dropdown-menu p-3">
                <li class="flex-center-full flex-column dropdown-menu__information">
                    <span class="dropdown-menu__information-email"> <?php echo $_SESSION['correo_electronico'] ?? '' ?> </span>
                    <img src=" " class="dropdown-menu__img" alt="">
                    <h2> <?php echo  '¡Hola, ' . $_SESSION['usuario'] . '!' ??  '' ?></h2>
                </li>
                <li class="text-center">
                    <a href="./profile" class="text-decoration-none text__blue"><button class="dropdown-item" type="button">Administrar tu cuenta</button></a>
                </li>
                <li clasS="text-center">
                    <button class="dropdown-item" type="button">
                        <a href="../signOut" class="text-decoration-none text__grey">Cerrar Sesión</a>
                    </button>
                </li>
            </ul>
        </div>
    </div>

</header>