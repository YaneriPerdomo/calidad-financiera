<!doctype html>
<html lang="es" class="full-heigh">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datos| Calidad financiera</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../public/css/components/_buttons.css">
    <link rel="stylesheet" href="../../public/css/components/_footer.css">
    <link rel="stylesheet" href="../../public/css/components/_table.css">
    <link rel="stylesheet" href="../../public/css/components/_header.css">
    <link rel="stylesheet" href="../../public/css/components/_form.css">
    <link rel="stylesheet" href="../../public/css/components/_body.css">
    <link rel="stylesheet" href="../../public/css/components/_sidebar.css">
    <link rel="stylesheet" href="../../public/css/pages/_about.css">
    <link rel="stylesheet" href="../../public/css/utilities.css">
    <link rel="stylesheet" href="../../public/css/layouts/_base.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    include '../resources/views/components/user/header.php';
    ?>
    <main class="main ">
        <?php
        include '../resources/views/components/user/sidebar.php';
        ?>
        <div>
            <article class="main__transaction flex-center-full w-100 ">
                <form action="./data" method="POST" class="form form--transaction just-one-form">
                    <legend class="form__title">
                        <h1><b>Agregar transacción</b></h1>
                    </legend>
                    <p class="form__description"> Controla tu información protegiendo tu privacidad y recuerda que puedes actualizar tu perfil en cualquier momento. </p>
                    <hr class="form__separator">
                    <div class="form__data">
                        <div class="row form__row">
                            <div class="col-12 col-lg-4 form__col form__col--title">
                                <span class="form__subtitle">Indicador </span>
                            </div>
                            <div class="col-12 col-lg-8 form__col form__col--inputs">
                                <label for="name" class="form__label form__label--required">Tipo de indicador</label><br>
                                <div class="input-group mb-3">
                                    <span class="input-group-text form__icon" id="basic-addon1"><i class="bi bi-person"></i></span>
                                    <select id="type-indicator" name="type-indicator" class="form-control form__select" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1">Ingreso</option>
                                        <option value="2">Egreso</option>

                                    </select>
                                </div>
                                <div class="graduation-group hidden">
                                    <label for="id_graduation-category" class="form__label form__label--required">Categoria de egreso</label><br>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text form__icon" id="basic-addon1"><i class="bi bi-person"></i></span>
                                        <select id="id_graduation-category" name="id_graduation_category" class="form-control form__select" required>
                                            <?php



                                            foreach ($data as $value) { //Ahora voy a hacer bucle
                                                $categoryId = $value['id_categoria_egreso']; //Almacenar la variable
                                                $categoryName = $value['categoria'];


                                                echo '<option value="' . $categoryId . '" > ' . $categoryName . '</option>';
                                            }


                                            ?>
                                        </select>
                                    </div>

                                    <label for="id_graduation" class="form__label form__label--required">Egreso</label><br>
                                    <div class="input-group mb-3">
                                        <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                        <select id="id_graduation" name="id_graduation" class="form-control form__select">
                                            <?php
                                            echo '<option value="" required > Seleccione una opcion</option>';

                                            foreach ($accommodation as  $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '" > ' . $value['egreso'] . '</option>';
                                            }

                                            foreach ($services as  $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '" > ' . $value['egreso'] . '</option>';
                                            }
                                            foreach ($meal as  $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '" > ' . $value['egreso'] . '</option>';
                                            }
                                            foreach ($others as  $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '" > ' . $value['egreso'] . '</option>';
                                            }
                                            foreach ($entertainment as  $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '" > ' . $value['egreso'] . '</option>';
                                            }
                                            foreach ($debts as  $value) {
                                                echo '<option value="' . $value['id_egreso'] . '" data-graduation-category="' . $value['id_categoria_egreso'] . '" > ' . $value['egreso'] . '</option>';
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="income hidden">
                                    <label for="insome" class="form__label form__label--required">Ingreso</label><br>
                                    <div class="input-group mb-3">
                                        <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                        <select id="id_insome" name="id_insome" class="form-control form__select" required>
                                            <?php
                                            foreach ($all_insome as $value) { //Ahora voy a hacer bucle
                                                $id_insome = $value['id_ingreso']; //Almacenar la variable
                                                $insome = $value['ingreso'];
                                                echo '<option value="' . $id_insome . '" > ' . $insome . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="value hidden">
                                    <label for="value" class="form__label form__label--required">Valor</label><br>
                                    <div class="input-group mb-3">
                                        <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                        <input type="text" name="value" class="form__input form__input--item form-control"
                                            placeholder="Ingresa tu valor" aria-label="Username"
                                            aria-describedby="basic-addon1"
                                            value="">
                                    </div>
                                </div>

                                <div class="observations ">
                                    <label for="observations" class="form__label form__label--required">Observaciones</label><br>
                                    <div class="input-group mb-3">
                                        <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                                        <textarea type="text" name="observations" class="form__input form__input--item form-control"
                                            placeholder="Ingresa tu valor" aria-label="Username"
                                            aria-describedby="basic-addon1"
                                            value=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="form__separator">
                    <div class="flex-center-full form__actions gap-3">
                        <button class="form__button button--back" type="button">
                            <a href="./data/1" class="text-black text-decoration-none"> <i class="bi bi-arrow-left-square"></i> Regresar</a>
                        </button>
                        <button class="form__button form__button--submit" type="submit">Actualizar datos</button>
                    </div>
                </form>
            </article>
        </div>

        </div>
    </main>
    <?php
    include '../resources/views/components/footer.php';
    ?>

    <script>
        let $TYPE_INDICATOR_SELECT = document.querySelector('#type-indicator');
        let $GRADUATION_GROUP = document.querySelector('.graduation-group');
        let $INCOME = document.querySelector(".income");
        const $VALUE = document.querySelector(".value")

        function type_indicator(value) {

            if (value === '1') {
                $GRADUATION_GROUP.classList.add('hidden');
                $INCOME.classList.remove('hidden');
                $VALUE.classList.remove('hidden')
            } else if (value == 2) {
                $GRADUATION_GROUP.classList.remove('hidden');
                $INCOME.classList.add('hidden');
                $VALUE.classList.remove('hidden')
            } else {
                return
            }
        }


        const $TYPE_GRADUATION = document.querySelector('#id_graduation-category');
        let $data_graduation_category = document.querySelectorAll('[data-graduation-category]');
        $TYPE_INDICATOR_SELECT.addEventListener('change', (e) => {
            let VALUE = e.target.value;
            type_indicator(VALUE);
        })

        $TYPE_GRADUATION.addEventListener('change', e => {
            console.info($data_graduation_category);
            let selected_value = e.target.value;

            $data_graduation_category.forEach(element => {
                element.style.display = 'none';
            });

            $data_graduation_category.forEach(element => {
                if (element.getAttribute('data-graduation-category') == selected_value) {
                    element.removeAttribute('style');
                }
            });


        })


        document.addEventListener('DOMContentLoaded', e => {
            type_indicator($TYPE_INDICATOR_SELECT.value);
        })
    </script>

    <script src="../js/components/location.js" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>