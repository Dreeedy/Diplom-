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
            <h4 class="mb-3">Создание акта о бракосочетании</h4>
            <form action="../controllers/actsMarriageController.php" method="post" class="needs-validation">

                <div class="row g-3 mb-2">

                    <!--01 - Муж - Open -->
                    <div class="col-12">
                        <label for="husband_surname" class="visually-hidden">Фамилия мужа</label>
                        <input type="text" class="form-control" id="husband_surname" name="husband_surname"
                               placeholder="Фамилия мужа"
                               value="<?php echo $_SESSION['MARRIAGE']['HUSBAND']['husband_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="husband_name" class="visually-hidden">Имя мужа</label>
                        <input type="text" class="form-control" id="husband_name" name="husband_name"
                               placeholder="Имя мужа"
                               value="<?php echo $_SESSION['MARRIAGE']['HUSBAND']['husband_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="husband_middleName" class="visually-hidden">Отчество мужа</label>
                        <input type="text" class="form-control" id="husband_middleName" name="husband_middleName"
                               placeholder="Отчество мужа"
                               value="<?php echo $_SESSION['MARRIAGE']['HUSBAND']['husband_middleName'] ?>"
                               minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12 <? if ($_SESSION['MARRIAGE']['HUSBAND']['visually_hidden'] == false) {
                        echo 'visually-hidden';
                    } else {
                        echo '';
                    } ?>">
                        <?
                        //вывод ошибок
                        if ($_SESSION['MARRIAGE']['reg'] == false & !empty($_SESSION['MARRIAGE']['HUSBAND']['ERRORS']))
                        {
                            foreach ($_SESSION['MARRIAGE']['HUSBAND']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                        }
                        ?>
                    </div><!--ошибки-->
                    <!--02 - Муж - Close -->
                    <hr>
                    <!--01 - Жена - Open -->
                    <div class="col-12 mt-0">
                        <label for="wife_surname" class="visually-hidden">Фамилия жены</label>
                        <input type="text" class="form-control" id="wife_surname" name="wife_surname"
                               placeholder="Фамилия жены"
                               value="<?php echo $_SESSION['MARRIAGE']['WIFE']['wife_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="wife_name" class="visually-hidden">Имя жены</label>
                        <input type="text" class="form-control" id="wife_name" name="wife_name"
                               placeholder="Имя жены"
                               value="<?php echo $_SESSION['MARRIAGE']['WIFE']['wife_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="wife_middleName" class="visually-hidden">Отчество жены</label>
                        <input type="text" class="form-control" id="wife_middleName" name="wife_middleName"
                               placeholder="Отчество жены"
                               value="<?php echo $_SESSION['MARRIAGE']['WIFE']['wife_middleName'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12 <? if ($_SESSION['MARRIAGE']['WIFE']['visually_hidden'] == false) {
                        echo 'visually-hidden';
                    } else {
                        echo '';
                    } ?>">
                        <?
                        //вывод ошибок
                        if ($_SESSION['MARRIAGE']['reg'] == false & !empty($_SESSION['MARRIAGE']['WIFE']['ERRORS']))
                        {
                            foreach ($_SESSION['MARRIAGE']['WIFE']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                        }
                        ?>
                    </div><!--ошибки-->
                    <!--02 - Жена - Close -->
                    <hr>
                    <!-- 01 - дата и радио - Open -->
                    <div class="col-12 mb-2 mt-0 row">
                        <div class="col-auto"><!--дата заключения брака-->
                            <label for="marriage_date" class="visually-hidden">Дата заключения брака</label>
                            <input type="date" class="form-control" id="marriage_date" name="marriage_date"
                                   placeholder="Дата заключения брака 0000 00 00"
                                   value="<?php echo $_SESSION['MARRIAGE']['marriage_date'] ?>" required="">
                        </div>
                        <div class="form-check col-auto">
                            <input class="form-check-input" type="radio" name="radio_main_surname" id="flexRadioDefault2"
                                   checked value="husband_surname">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Фамилия мужа
                            </label>
                        </div>
                        <div class="form-check col-auto">
                            <input class="form-check-input" type="radio" name="radio_main_surname" id="flexRadioDefault1"
                            value="wife_surname">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Фамилия жены
                            </label>
                        </div>
                    </div>
                    <!-- 01 - дата и радио - Close -->
                    <div class="col-12 my-1">
                        <?
                        //вывод ошибок
                        if ($_SESSION['MARRIAGE']['reg'] == false & !empty($_SESSION['MARRIAGE']['ERRORS']))
                        {
                            foreach ($_SESSION['MARRIAGE']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                        }

                        //вывод успешный действий
                        if ($_SESSION['MARRIAGE']['reg'] == true & !empty($_SESSION['MARRIAGE']['SUCCESS']))
                        {
                            {
                                foreach ($_SESSION['MARRIAGE']['SUCCESS'] as $success)
                                {
                                    echo '<div class="alert alert alert-success mb-1 p-1 text-center" role="alert">' . $success . '</div>';
                                }
                            }

                            $_SESSION['MARRIAGE']['reg'] = false;
                        }
                        ?>
                    </div><!--ошибки-->
                </div>
                <button class="w-100 btn btn-primary btn-lg" type="submit">Создать</button>
            </form>
        </div>
    </div>
</div>
