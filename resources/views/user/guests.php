<?php // Vista del panel de control del usuario 
?>
<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel de control | Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/../css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/../css/components/_footer.css">
    <link rel="stylesheet" href="../../public/../css/components/_header.css">
    <link rel="stylesheet" href="../../public/../css/components/_body.css">
    <link rel="stylesheet" href="../../public/../css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/../css/pages/_about.css">
    <link rel="stylesheet" href="../../public/../css/utilities.css">
    <link rel="stylesheet" href="../../public/../css/layouts/_base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        .dataTable {
            display: block;
            width: 100%;
            margin: 1em 0;
        }

        .dataTable thead,
        .dataTable tbody,
        .dataTable thead tr,
        .dataTable th {
            display: block;
        }

        .contentTableC {
            display: flex;
            padding: 0.5rem;
            justify-content: space-between;
            align-items: center;
        }

        .dataTable thead {
            float: left;
        }

        .dataTable tbody {
            width: auto;
            position: relative;
            overflow-x: auto;
        }

        .dataTable td,
        .dataTable th {
            padding: .625em;
            line-height: 1.5em;
            border-bottom: 1px dashed #ccc;
            box-sizing: border-box;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .dataTable th {
            text-align: left;
            background: rgba(0, 0, 0, 0.14);
            border-bottom: 1px dashed #aaa;
        }

        .dataTable tbody tr {
            display: table-cell;

        }


        thead>tr {
            background: var(--color-azul) !important;
            color: white !important;
        }

        .dataTable tbody td {
            display: block;
        }

        .dataTable tr:nth-child(odd) {
            background: rgba(0, 0, 0, 0.07);
        }

        @media screen and (min-width: 992px) {

            .dataTable {
                display: table;
            }

            .dataTable thead {
                display: table-header-group;
                float: none;
            }

            .dataTable tbody {
                display: table-row-group;
            }

            .dataTable thead tr,
            .dataTable tbody tr {
                display: table-row;
            }

            .dataTable th,
            .dataTable tbody td {
                display: table-cell;
            }

            .dataTable td,
            .dataTable th {
                width: auto;
            }


        }

        .style-border {
            background: white;
            padding: 1rem;
            border-radius: 1rem;
            border: solid 1px #e8d8ff;
            margin: 1rem;
        }

        .flex-space-between {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: center;

        }

        .button--azul {
            background: var(--color-azul);
            padding: 0.5rem 1.5rem;
            color: white;
            border: 0rem;
        }

        .button--orange {

            background: #A58F47;
            padding: 0.5rem 1.5rem;
            color: white;
            border: 0rem;
        }

        .operation-pagitation>a {
            text-decoration: none;
            color: black;
        }

        .operation-pagitation>a>b {
            background: var(--color-azul);
            padding: 0.3rem;
            color: white;
        }

        .button--delete {
            background: #ff4b4b;
            color: white;
            border: none;
            padding: 0.5rem;
        }

        .button--modify {
            background: #4aa448;
            color: white;
            border: none;
            padding: 0.5rem;
        }


        .modal {
            width: 100vw;
            height: 100vh;
            position: absolute;
            display: flex;
            justify-content: center;
            background: green;
            align-items: center;
            background: rgb(0, 0, 0, 0.5);
        }

        .modal__content {
            max-width: 500px;
            background: white;
            min-width: 200px;

        }

        .modal__title {
            padding: 1rem;
            color: white;
        }

        .modal__title--delete {
            background: #ff4b4b;

        }

        .modal__text {
            padding: 0.5rem;
            margin: 0rem;
        }

        .modal__form {
            padding: 1rem;
        }

        .button--cancel {
            background: #565d62;
            color: white;
            border: none;
            padding: 0.5rem;
        }

        .flex-end-full{
            display: flex;
            justify-content: end;
        }
    </style>
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
                <h1><strong>Gestion de invitados</strong></h1>
                <div class="">
                    <button type="button" class="button--orange m-2" title="Descargar un reporte en PDF">
                        <a href="" class="text-decoration-none text-white">Reporte en <b>PDF</b></a>
                    </button>
                    <button type="button" class="button--azul" title="Agregar persona invitada">
                        <a href="../guest/add" class="text-decoration-none text-white">+Agregar</a>
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
                            <th>Ultimo acceso</th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <?php
                    echo $HTML;
                    ?>
        </div>
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
        let $MODAL_DELETE =document.querySelector('.modal--delete');
        let $DATA_JS_FORM = document.querySelector("[data-js-form]")
       
        document.addEventListener('click' , e => {
            if(e.target.matches('.js-open-modal-delete')){
                 $id_guest = e.target.getAttribute('data-id_guest');
                 open_modal('delete', $MODAL_DELETE, $id_guest);
            }

            if(e.target.matches('[data-js-cancel="delete"]')){
                close_modal($MODAL_DELETE); 
                    
            }
        })

        function open_modal($modal_type, $modal_element, $item_id = null){
                $item_id != null ? $modal_input_id_user.value = $item_id : null;
                switch ($modal_type) {
                    case 'delete':
                        $modal_element.removeAttribute('style')                        
                    break;
                
                    default:
                        break;
                }
        }

        function close_modal($modal_element){
            $modal_element.style.display = 'none';
        }
    </script>
    <script src="../../js/components/location.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>