<div class="container" style="min-height: 873px;">
    <div class="row g-3 py-5">
        <div class="col-md-4 col-lg-3 order-md-last">
            <!-- 01 - Вертикальное меню - Open -->
            <? require_once 'verical_menu/verticalMenu.php'?>
            <!-- 02 - Вертикальное меню - Close -->

        </div>
        <div class="col-md-8 col-lg-9">
            <h4 class="mb-3">Регистрация акта о расторжении брака</h4>
            <form action="../controllers/actsMarriageController.php" method="post" class="needs-validation">

                <div class="row g-3 mb-2">

                    <div class="col-12 visually-hidden">
                        <label for="post_selector" class="visually-hidden"></label>
                        <input type="text" class="form-control" id="post_selector" name="post_selector"
                               value="post_divorce"
                               >
                    </div>

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
                    <div class="col-auto"><!--дата заключения брака-->
                        <label for="date_divorce" class="">Дата расторжения брака</label>
                        <input type="date" class="form-control" id="date_divorce" name="date_divorce"
                               placeholder="Дата расторжения брака 0000 00 00"
                               value="<?php echo $_SESSION['DIVORCE']['date_divorce'] ?>" required="">
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
                            $_SESSION['DIVORCE']['ERRORS'] = [];
                        }

                        //вывод успешный действий
                        if ($_SESSION['DIVORCE']['is_divorced'] == false /*true*/ & !empty($_SESSION['DIVORCE']['SUCCESS']))
                        {

                            foreach ($_SESSION['DIVORCE']['SUCCESS'] as $success)
                            {
                                echo '<div class="alert alert alert-success mb-1 p-1 text-center" role="alert">' . $success . '</div>';
                            }
                            $_SESSION['DIVORCE']['SUCCESS'] = [];
                            $_SESSION['DIVORCE']['is_divorced'] = false;
                        }
                        ?>
                    </div>
                    <!-- 02 - Сообщения - Close -->

                </div>
                <button class="w-100 btn btn-primary btn-lg" type="submit">Поиск</button>
            </form>

            <form action="../controllers/actsMarriageController.php" method="post" class="needs-validation mt-1">

                <div class="row g-3 mb-2 visually-hidden">

                    <div class="col-12 visually-hidden">
                        <label for="post_selector" class="visually-hidden"></label>
                        <input type="text" class="form-control" id="post_selector" name="post_selector"
                               value="post_divorce"
                        >
                    </div>

                    <div class="col-12 visually-hidden">
                        <label for="is_divorce" class="visually-hidden"></label>
                        <input type="text" class="form-control" id="is_divorce" name="is_divorce"
                               value="is_divorce_true"
                        >
                    </div>

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
                    <div class="col-auto"><!--дата заключения брака-->
                        <label for="date_divorce" class="visually-hidden">Дата расторжения брака</label>
                        <input type="date" class="form-control" id="date_divorce" name="date_divorce"
                               placeholder="Дата расторжения брака 0000 00 00"
                               value="<?php echo $_SESSION['DIVORCE']['date_divorce'] ?>" required="">
                    </div>
                    <!-- 02 - Супруг - Close -->

                </div>
                <button class="w-100 btn btn-primary btn-lg" type="submit">Расторгнуть</button>
            </form>


        </div>
    </div>
</div>
