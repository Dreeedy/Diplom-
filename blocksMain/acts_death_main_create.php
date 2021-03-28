<div class="container" style="min-height: 873px;">
    <div class="row g-3 py-5">
        <div class="col-md-4 col-lg-3 order-md-last">
            <!-- 01 - Вертикальное меню - Open -->
            <? require_once 'verical_menu/verticalMenu.php'?>
            <!-- 02 - Вертикальное меню - Close -->

        </div>
        <div class="col-md-8 col-lg-9">
            <h4 class="mb-3">Регистрация акта о смерти</h4>
            <form action="../controllers/actsDeathController.php" method="post" class="needs-validation">

                <div class="row g-3 mb-2">

                    <!--01 - Customer - Open -->
                    <div class="col-12">
                        <label for="customer_surname" class="visually-hidden">Фамилия</label>
                        <input type="text" class="form-control" id="customer_surname" name="customer_surname"
                               placeholder="Фамилия"
                               value="<?php echo $_SESSION['DEATHH']['customer_surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="customer_name" class="visually-hidden">Имя</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name"
                               placeholder="Имя"
                               value="<?php echo $_SESSION['DEATHH']['customer_name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="customer_middleName" class="visually-hidden">Отчество</label>
                        <input type="text" class="form-control" id="customer_middle_name" name="customer_middle_name"
                               placeholder="Отчество"
                               value="<?php echo $_SESSION['DEATHH']['customer_middle_name'] ?>"
                               minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-auto">
                        <label for="date_death" class="">Дата наступления смерти</label>
                        <input type="date" class="form-control" id="date_death" name="date_death"
                               placeholder="Дата расторжения брака 0000 00 00"
                               value="<?php echo $_SESSION['DEATHH']['date_death'] ?>" required="">
                    </div>
                    <!--02 - Customer - Close -->

                    <div class="col-12 my-1">
                        <?
                        //вывод ошибок
                        if (!empty($_SESSION['DEATHH']['ERRORS']))
                        {
                            foreach ($_SESSION['DEATHH']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['DEATHH']['ERRORS'] = [];
                        }

                        //вывод успешный действий
                        if (!empty($_SESSION['DEATHH']['SUCCESS']))
                        {
                            {
                                foreach ($_SESSION['DEATHH']['SUCCESS'] as $success)
                                {
                                    echo '<div class="alert alert alert-success mb-1 p-1 text-center" role="alert">' . $success . '</div>';
                                }
                            }
                            $_SESSION['DEATHH']['SUCCESS'] = [];
                        }
                        ?>
                    </div>

                </div>
                <button class="w-100 btn btn-primary btn-lg" type="submit">Регистрация</button>
            </form>
        </div>
    </div>
</div>
