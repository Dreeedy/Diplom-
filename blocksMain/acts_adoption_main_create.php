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
            <h4 class="mb-3">Регистрация о усыновлении ( удочерении ) ребенка</h4>
            <form action="../controllers/actsAdoptionCreateController.php" method="post" class="needs-validation">

                <div class="row g-3 mb-2">

                    <!--01 - Муж - Open -->
                    <div class="col-12">
                        <label for="husband_surname" class="visually-hidden">Фамилия мужа</label>
                        <input type="text" class="form-control" id="husband_surname" name="husband_surname"
                               placeholder="Фамилия мужа"
                               value="<?php echo $_SESSION['ADOPTION']['HUSBAND']['husband_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="husband_name" class="visually-hidden">Имя мужа</label>
                        <input type="text" class="form-control" id="husband_name" name="husband_name"
                               placeholder="Имя мужа"
                               value="<?php echo $_SESSION['ADOPTION']['HUSBAND']['husband_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="husband_middle_name" class="visually-hidden">Отчество мужа</label>
                        <input type="text" class="form-control" id="husband_middle_name" name="husband_middle_name"
                               placeholder="Отчество мужа"
                               value="<?php echo $_SESSION['ADOPTION']['HUSBAND']['husband_middle_name'] ?>"
                               minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12 <? if ($_SESSION['ADOPTION']['HUSBAND']['visually_hidden'] == false) {
                        echo 'visually-hidden';
                    } else {
                        echo '';
                    } ?>">
                        <?
                        //вывод ошибок
                        if (!empty($_SESSION['ADOPTION']['HUSBAND']['ERRORS']))
                        {
                            foreach ($_SESSION['ADOPTION']['HUSBAND']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['ADOPTION']['HUSBAND']['ERRORS'] = [];
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
                               value="<?php echo $_SESSION['ADOPTION']['WIFE']['wife_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="wife_name" class="visually-hidden">Имя жены</label>
                        <input type="text" class="form-control" id="wife_name" name="wife_name"
                               placeholder="Имя жены"
                               value="<?php echo $_SESSION['ADOPTION']['WIFE']['wife_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="wife_middle_name" class="visually-hidden">Отчество жены</label>
                        <input type="text" class="form-control" id="wife_middle_name" name="wife_middle_name"
                               placeholder="Отчество жены"
                               value="<?php echo $_SESSION['ADOPTION']['WIFE']['wife_middle_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12 <? if ($_SESSION['ADOPTION']['WIFE']['visually_hidden'] == false) {
                        echo 'visually-hidden';
                    } else {
                        echo '';
                    } ?>">
                        <?
                        //вывод ошибок
                        if (!empty($_SESSION['ADOPTION']['WIFE']['ERRORS']))
                        {
                            foreach ($_SESSION['ADOPTION']['WIFE']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['ADOPTION']['WIFE']['ERRORS'] = [];
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
                               value="<?php echo $_SESSION['ADOPTION']['CHILD']['child_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="child_name" class="visually-hidden">Имя ребенка</label>
                        <input type="text" class="form-control" id="child_name" name="child_name"
                               placeholder="Имя ребенка"
                               value="<?php echo $_SESSION['ADOPTION']['CHILD']['child_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="child_middle_name" class="visually-hidden">Отчество ребенка</label>
                        <input type="text" class="form-control" id="child_middle_name" name="child_middle_name"
                               placeholder="Отчество ребенка"
                               value="<?php echo $_SESSION['ADOPTION']['CHILD']['child_middle_name'] ?>"
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
                                   value="<?php echo $_SESSION['ADOPTION']['date_birth'] ?>" required="">
                        </div>
                        <div class="col-auto"><!--дата заключения брака-->
                            <label for="date_adoption" class="">Дата усыновления (удочерения) ребенка</label>
                            <input type="date" class="form-control" id="date_adoption" name="date_adoption"
                                   placeholder="Дата рождения"
                                   value="<?php echo $_SESSION['ADOPTION']['date_adoption'] ?>" required="">
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

                    <div class="col-12 <? if ($_SESSION['ADOPTION']['CHILD']['visually_hidden'] == false) {
                        echo 'visually-hidden';
                    } else {
                        echo '';
                    } ?>">
                        <?
                        //вывод ошибок
                        if (!empty($_SESSION['ADOPTION']['CHILD']['ERRORS']))
                        {
                            foreach ($_SESSION['ADOPTION']['CHILD']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['ADOPTION']['CHILD']['ERRORS'] = [];
                        }
                        ?>
                    </div><!--ошибки-->
                    <!--02 - Ребенок - Close -->

                    <!--01 - Сообщения - Open -->
                    <div class="col-12 my-1">
                        <?
                        if (!empty($_SESSION['ADOPTION']['ERRORS']))
                        {
                            foreach ($_SESSION['ADOPTION']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['ADOPTION']['ERRORS'] = [];
                        }

                        if (!empty($_SESSION['ADOPTION']['SUCCESS']))
                        {
                            {
                                foreach ($_SESSION['ADOPTION']['SUCCESS'] as $success)
                                {
                                    echo '<div class="alert alert alert-success mb-1 p-1 text-center" role="alert">' . $success . '</div>';
                                }
                            }
                            $_SESSION['ADOPTION']['SUCCESS'] = [];
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
