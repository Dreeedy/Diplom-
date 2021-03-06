<div class="container" style="min-height: 873px;">
    <div class="row g-3 py-5">
        <div class="col-md-4 col-lg-3 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Меню</span>
            </h4>

            <div class="list-group mb-3">
                <div class="mb-1">
                    <a href="../index.php">
                        <button class="w-100 btn btn-md btn-outline-danger text-start">Назад</button>
                    </a>
                </div>
                <div class="mb-1">
                    <a href="">
                        <button class="w-100 btn btn-md btn-primary text-start">Добавить акт о бракосочетании</button>
                    </a>
                </div>
                <div class="mb-1">
                    <a href="">
                        <button class="w-100 btn btn-md btn-primary text-start">Добавить акт о усыновлении</button>
                    </a>
                </div>
                <div class="mb-1">
                    <a href="">
                        <button class="w-100 btn btn-md btn-primary text-start">Добавить акт о рождении</button>
                    </a>
                </div>
                <div class="mb-1">
                    <a href="">
                        <button class="w-100 btn btn-md btn-primary text-start">Добавить акт о смерти</button>
                    </a>
                </div>
            </div>

        </div>
        <div class="col-md-8 col-lg-9">
            <h4 class="mb-3">Регистрация акта о расторжении брака</h4>
            <form action="../controllers/actsMarriageController.php" method="post" class="needs-validation">

                <div class="row g-3 mb-2">

                    <!-- 01 - Супруг - Open -->
                    <div class="col-12">
                        <label for="spouse_surname" class="visually-hidden">Фамилия</label>
                        <input type="text" class="form-control" id="spouse_surname" name="spouse_surname"
                               placeholder="Фамилия"
                               value="<?php echo $_SESSION['DIVORCE']['spouse_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="spouse_name" class="visually-hidden">Имя</label>
                        <input type="text" class="form-control" id="spouse_name" name="spouse_name"
                               placeholder="Имя"
                               value="<?php echo $_SESSION['DIVORCE']['spouse_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="spouse_middleName" class="visually-hidden">Отчество</label>
                        <input type="text" class="form-control" id="spouse_middleName" name="spouse_middleName"
                               placeholder="Отчество"
                               value="<?php echo $_SESSION['DIVORCE']['spouse_middleName'] ?>"
                               minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <!-- 02 - Супруг - Close -->

                    <!-- 01 - Сообщения - Open -->
                    <div class="col-12 my-1">
                        <?
                        //вывод ошибок
                        if ($_SESSION['DIVORCE']['is_divorced'] == false & !empty($_SESSION['DIVORCE']['ERRORS']))
                        {
                            foreach ($_SESSION['DIVORCE']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                        }

                        //вывод успешный действий
                        if ($_SESSION['DIVORCE']['is_divorced'] == true & !empty($_SESSION['DIVORCE']['SUCCESS']))
                        {

                            foreach ($_SESSION['DIVORCE']['SUCCESS'] as $success)
                            {
                                echo '<div class="alert alert alert-success mb-1 p-1 text-center" role="alert">' . $success . '</div>';
                            }

                            $_SESSION['DIVORCE']['is_divorced'] = false;
                        }
                        ?>
                    </div>
                    <!-- 02 - Сообщения - Close -->

                </div>
                <button class="w-100 btn btn-primary btn-lg" type="submit">Расторгнуть</button>
            </form>
        </div>
    </div>
</div>
