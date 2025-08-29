<?php // Vista del panel de control del usuario 
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion de invitado | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_buttons.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_footer.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_header.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/layouts/_ico.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_table.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_body.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_body.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_sidebar.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_pagination.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/pages/_about.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/utilities.css">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/layouts/_base.css">
    <link rel="icon" type="image/x-icon"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../img/logo.ico">
    <link rel="stylesheet"
        href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_searchInput.css">
    <link rel="stylesheet" href="<?php echo $searchUsers == false ? '../../' : '../../../' ?>public/../css/components/_presentation-system-web.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    include '../resources/views/components/user/header.php';
    ?>
    <main class="main main--content-login">
        <?php
        include '../resources/views/components/user/sidebar.php';
        ?>
        <div class="style-border">
            <section class="flex-space-between ">
                <div>
                    <h1 class="fs-3">
                        <strong>Gestion de invitados</strong>
                    </h1>
                    <div class="search ">
                        <div class="input-group  search__seeker">
                            <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                <i class="bi bi-search search__icon"></i>
                            </span>
                            <input type="text" name="name" id="name"
                                class="search__input search__input--text form-control"
                                placeholder="Ingrese un nombre del invitado" aria-label="Nombre del producto" autofocus
                                data-name="<?php echo trim($nameUser) ?>" value="<?php echo trim($nameUser) ?>">
                        </div>
                        <div class="search__action">
                            <button class="button search__button button--azul color-white" type="button">
                                Buscar
                            </button>
                        </div>
                    </div>
                    <script>
                        let ItemButttonSearh = document.querySelector('.search__button');
                        let ItemFomSearch = document.querySelector('form');
                        let ItemInputName = document.querySelector('#name');

                        ItemButttonSearh.addEventListener('click', async e => {
                            e.preventDefault();
                            let inputValue = ItemInputName.value;
                            if (inputValue != "") {
                                return window.location.href = '/calidad-financiera/public/user/guests/' + inputValue.trim() + '/1';
                            } else {
                                return window.location.href = '/calidad-financiera/public/user/guests/1';
                            }
                        })
                    </script>
                </div>
                <div class="button-pdf">
                    <button type="button" class="button--orange m-2" title="Descargar un reporte en PDF">
                        <a href="<?php echo $searchUsers == false ? '../' : '../../' ?>guest/data-report"
                            class="text-decoration-none text-white">Reporte en <b>PDF</b></a>
                    </button>
                    <button type="button" class="button--azul" title="Agregar persona invitada">
                        <a href="<?php echo $searchUsers == false ? '../' : '../../' ?>guest/add"
                            class="text-decoration-none text-white">+Agregar</a>
                    </button>
                </div>
            </section>
            <section class='table'>
                <table class='dataTable'>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo electronico</th>
                            <th>Estado</th>
                            <th>Fecha de creacion</th>
                            <th>Ultimo acceso</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <?php
                    echo $HTML;
                    ?>
        </div>
        <script>
            let formDeleteAccount = document.querySelector('.form-guest__delete');
            formDeleteAccount.addEventListener('submit', e => {
                e.preventDefault();
                let resp = confirm('¿Esta seguro que quiere eliminar tu cuenta de calidad financiera por completo?');
                if (resp) {
                    e.target.submit();
                }

            })
        </script>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>

    <article class="modal modal--delete" style="display:none">
        <div class="modal__content modal__content--delete">
            <div class="modal__header">
                <div class="modal__header-container">
                    <h2 class="modal__title modal__title--delete">Eliminar cuenta</h2>
                    <p class="modal__text">
                        ¿Estás seguro de que deseas eliminar tu cuenta Profesional en "Espacio N"?
                        Esta acción es irreversible y eliminará todos tus datos,
                        incluyendo a las cuentas de los usuarios que hayas creado.
                    </p>
                </div>
            </div>
            <form action="./guest/delete" class="modal__form" data-js-form="delete" method="post">
                <div class="modal__body">
                    <input type="hidden" name="id_user" value="" class="modal__input  ">
                </div>
                <div class="modal__footer flex-end-full gap-3">
                    <button type="button" class="modal__button button--cancel" data-js-cancel="delete">Cancelar</button>
                    <button type="submit" class="modal__button button--delete">Sí, eliminar</button>
                </div>
            </form>
        </div>
    </article>
    <script>

        let $DATA_ID_GUEST = document.querySelector('[data-id_guest]');
        let $modal_input_id_user = document.querySelector("[name='id_user']");
        let $MODAL_DELETE = document.querySelector('.modal--delete');
        let $DATA_JS_FORM = document.querySelector("[data-js-form]")

        document.addEventListener('click', e => {
            if (e.target.matches('.js-open-modal-delete')) {
                $id_guest = e.target.getAttribute('data-id_guest');
                open_modal('delete', $MODAL_DELETE, $id_guest);
            }

            if (e.target.matches('[data-js-cancel="delete"]')) {
                close_modal($MODAL_DELETE);

            }
        })

        function open_modal($modal_type, $modal_element, $item_id = null) {
            $item_id != null ? $modal_input_id_user.value = $item_id : null;
            switch ($modal_type) {
                case 'delete':
                    $modal_element.removeAttribute('style')
                    break;

                default:
                    break;
            }
        }

        function close_modal($modal_element) {
            $modal_element.style.display = 'none';
        }
    </script>
    <?php
    include '../resources/views/components/presentation.php';
    ?>

    <script src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/components/presentation_system_web.js" type="module"></script>
    <script src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/components/location_user.js"
        type="module"></script>
    <script src="<?php echo $searchUsers == false ? '../../' : '../../../' ?>js/cdn.js" type="module"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>