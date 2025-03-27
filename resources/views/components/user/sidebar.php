<section class="flex-center-full py-3 sidebar">
    <nav class="w-100 sidebar__nav">
        <ul class="sidebar__menu">
            <li class="sidebar__menu-item">
                <a href="<?php echo $main_jump ?? './'?>dashboard" id="start" class="text-decoration-none">Inicio</a>
            </li>
            <li class="sidebar__menu-item">
                <a href="<?php echo $main_jump ?? './'?>data" id="data" class="text-decoration-none">Datos</a>
            </li>
            <li class="sidebar__menu-item">
                <a href="<?php echo $main_jump ?? './'?>guests/1" id="guest" class="text-decoration-none">Invitados</a>
            </li>
            <!---
            <li class="sidebar__menu-item">
                <a href="./indicators" id="indicators" class="text-decoration-none">Indicadores</a>
            </li> --->
            <li class="sidebar__menu-item">
                <a href="<?php echo $main_jump ?? './'?>about" id="about" class="text-decoration-none"> Acerca de </a>
            </li>
        </ul>
    </nav>
</section>