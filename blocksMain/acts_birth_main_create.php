<div class="container" style="min-height: 873px;">
    <div class="row g-3 py-5">
        <div class="col-md-4 col-lg-3 order-md-last">
            <!-- 01 - Вертикальное меню - Open -->
            <? require_once 'verical_menu/verticalMenu.php'?>
            <!-- 02 - Вертикальное меню - Close -->

        </div>
        <div class="col-md-8 col-lg-9">
            <h4 class="mb-3">Регистрация акта о рождении ребенка</h4>
            <form action="../controllers/actsBirthCreateController.php" method="post" class="needs-validation">

                <div class="row g-3 mb-2">

                    <!--01 - Муж - Open -->
                    <div class="col-12">
                        <label for="husband_surname" class="visually-hidden">Фамилия мужа</label>
                        <input type="text" class="form-control" id="husband_surname" name="husband_surname"
                               placeholder="Фамилия мужа"
                               value="<?php echo $_SESSION['BIRTH']['HUSBAND']['husband_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="husband_name" class="visually-hidden">Имя мужа</label>
                        <input type="text" class="form-control" id="husband_name" name="husband_name"
                               placeholder="Имя мужа"
                               value="<?php echo $_SESSION['BIRTH']['HUSBAND']['husband_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="husband_middle_name" class="visually-hidden">Отчество мужа</label>
                        <input type="text" class="form-control" id="husband_middle_name" name="husband_middle_name"
                               placeholder="Отчество мужа"
                               value="<?php echo $_SESSION['BIRTH']['HUSBAND']['husband_middle_name'] ?>"
                               minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12 <? if ($_SESSION['BIRTH']['HUSBAND']['visually_hidden'] == false) {
                        echo 'visually-hidden';
                    } else {
                        echo '';
                    } ?>">
                        <?
                        //вывод ошибок
                        if (!empty($_SESSION['BIRTH']['HUSBAND']['ERRORS']))
                        {
                            foreach ($_SESSION['BIRTH']['HUSBAND']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['BIRTH']['HUSBAND']['ERRORS'] = [];
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
                               value="<?php echo $_SESSION['BIRTH']['WIFE']['wife_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="wife_name" class="visually-hidden">Имя жены</label>
                        <input type="text" class="form-control" id="wife_name" name="wife_name"
                               placeholder="Имя жены"
                               value="<?php echo $_SESSION['BIRTH']['WIFE']['wife_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="wife_middle_name" class="visually-hidden">Отчество жены</label>
                        <input type="text" class="form-control" id="wife_middle_name" name="wife_middle_name"
                               placeholder="Отчество жены"
                               value="<?php echo $_SESSION['BIRTH']['WIFE']['wife_middle_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12 <? if ($_SESSION['BIRTH']['WIFE']['visually_hidden'] == false) {
                        echo 'visually-hidden';
                    } else {
                        echo '';
                    } ?>">
                        <?
                        //вывод ошибок
                        if (!empty($_SESSION['BIRTH']['WIFE']['ERRORS']))
                        {
                            foreach ($_SESSION['BIRTH']['WIFE']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['BIRTH']['WIFE']['ERRORS'] = [];
                        }
                        ?>
                    </div><!--ошибки-->
                    <!--02 - Жена - Close -->

                    <hr>

                    <!--01 - Ребенок - Open -->
                    <div class="col-12 mt-0">
                        <label for="child_surname" class="visually-hidden">Фамилия ребенка</label>
                        <input type="text" class="form-control" id="child_surname" name="child_surname"
                               placeholder="Фамилия ребенка"
                               value="<?php echo $_SESSION['BIRTH']['CHILD']['child_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="child_name" class="visually-hidden">Имя ребенка</label>
                        <input type="text" class="form-control" id="child_name" name="child_name"
                               placeholder="Имя ребенка"
                               value="<?php echo $_SESSION['BIRTH']['CHILD']['child_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="child_middle_name" class="visually-hidden">Отчество ребенка</label>
                        <input type="text" class="form-control" id="child_middle_name" name="child_middle_name"
                               placeholder="Отчество ребенка"
                               value="<?php echo $_SESSION['BIRTH']['CHILD']['child_middle_name'] ?>"
                               minlength="2"
                               maxlength="33"
                               required="">
                    </div>

                    <!-- 01 - дата и радио - Open -->
                    <div class="col-12 mb-2 mt-1 row">
                        <div class="col-auto"><!--дата заключения брака-->
                            <label for="date_birth" class="">Дата рождения ребенка</label>
                            <input type="date" class="form-control" id="date_birth" name="date_birth"
                                   placeholder="Дата рождения"
                                   value="<?php echo $_SESSION['BIRTH']['date_birth'] ?>" required="">
                        </div>
                        <div class="form-check col-auto">
                            <input class="form-check-input" type="radio" name="radio_gender" id="flexRadioDefault2"
                                   checked value="Мужчина">
                            <label class="form-check-label" for="flexRadioDefault2">
                                Мальчик
                            </label>
                        </div>
                        <div class="form-check col-auto">
                            <input class="form-check-input" type="radio" name="radio_gender" id="flexRadioDefault1"
                                   value="Женщина">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Девочка
                            </label>
                        </div>
                    </div>
                    <!-- 01 - дата и радио - Close -->

                    <div class="col-12 <? if ($_SESSION['BIRTH']['CHILD']['visually_hidden'] == false) {
                        echo 'visually-hidden';
                    } else {
                        echo '';
                    } ?>">
                        <?
                        //вывод ошибок
                        if (!empty($_SESSION['BIRTH']['CHILD']['ERRORS']))
                        {
                            foreach ($_SESSION['BIRTH']['CHILD']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['BIRTH']['CHILD']['ERRORS'] = [];
                        }
                        ?>
                    </div><!--ошибки-->
                    <!--02 - Ребенок - Close -->

                    <!--01 - Сообщения - Open -->
                    <div class="col-12 my-1">
                        <?
                        if (!empty($_SESSION['BIRTH']['ERRORS']))
                        {
                            foreach ($_SESSION['BIRTH']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['BIRTH']['ERRORS'] = [];
                        }

                        if (!empty($_SESSION['BIRTH']['SUCCESS']))
                        {
                            {
                                foreach ($_SESSION['BIRTH']['SUCCESS'] as $success)
                                {
                                    echo '<div class="alert alert alert-success mb-1 p-1 text-center" role="alert">' . $success . '</div>';
                                }
                            }
                            $_SESSION['BIRTH']['SUCCESS'] = [];
                        }
                        ?>
                    </div>
                    <!--02 - Сообщения - Close -->
                </div>
                <button class="w-100 btn btn-primary btn-lg" type="submit">Зарегистрировать</button>
            </form>
        </div>
    </div>
</div>
