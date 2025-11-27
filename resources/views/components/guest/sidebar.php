<section class="flex-center-full py-3 sidebar">
    <nav class="w-100 sidebar__nav">
        <ul class="sidebar__menu">
            <li class="sidebar__menu-item">
                <a href="<?php echo $sidebar_jump ?? '../' ?>dashboard/<?php echo Date('m/Y') ?>" id="start"
                    class="text-decoration-none">Inicio</a>
            </li>
            <li class="sidebar__menu-item">
                <a href="<?php echo $sidebar_jump ?? './' ?>transactions/1" id="transactions"
                    class="text-decoration-none">Transacciones</a>
            </li>
            <li class="sidebar__menu-item">
                <a href="<?php echo $sidebar_jump ?? './' ?>sudgeting-and-savings" id="sudgeting-and-savings"
                    class="text-decoration-none">Presupuesto y Ahorro</a>
            </li>
            <li class="sidebar__menu-item">
                <a href="<?php echo $sidebar_jump ?? '' ?>about" id="about" class="text-decoration-none"> Acerca de </a>
            </li>
        </ul>
    </nav>
</section>