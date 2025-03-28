<section class="flex-center-full py-3 sidebar">
    <nav class="w-100 sidebar__nav">
        <ul class="sidebar__menu">
            <li class="sidebar__menu-item">
                <a href="<?php echo $main_jump ?? './'?>guest/dashboard" id="start" class="text-decoration-none">Inicio</a>
            </li>
            <li class="sidebar__menu-item">
                <a href="<?php echo $main_jump ?? './'?>guest/data" id="data" class="text-decoration-none">Datos</a>
            </li>
            <li class="sidebar__menu-item">
                <a href="<?php echo $main_jump ?? './'?>guest/about" id="about" class="text-decoration-none"> Acerca de </a>
            </li>
        </ul>
    </nav>
</section>