<div class="container" style="min-height: 873px;">
    <div class="row g-3 py-5">
        <div class="col-md-4 col-lg-3 order-md-last">
            <!-- 01 - Вертикальное меню - Open -->
            <? require_once 'verical_menu/verticalMenu.php'?>
            <!-- 02 - Вертикальное меню - Close -->
        </div>
        <div class="col-md-8 col-lg-9">
            <h4 class="mb-3">Регистрация клиента</h4>
            <form action="../customersController.php" method="post" class="needs-validation">

                <div class="row g-3 mb-2">

                    <div class="col-12">
                        <select name="gender" class="form-select form-control" aria-label=".form-select-sm example">
                            <?php
                            if ($_SESSION['REGISTER']['CUSTOMER']['gender'] == NULL) {$_SESSION['REGISTER']['CUSTOMER']['gender'] = "select_gender";}
                            //выбор гендера
                            if ($_SESSION['REGISTER']['CUSTOMER']['gender'] == "select_gender") {
                                echo '<option selected value="select_gender">Укажите пол</option>';
                                echo '<option value="Мужчина">Мужчина</option>';
                                echo '<option value="Женщина">Женщина</option>';
                            } elseif ($_SESSION['REGISTER']['CUSTOMER']['gender'] == 'male') {
                                echo '<option value="select_gender">Выберите роль сотрудника</option>';
                                echo '<option selected value="Мужчина">Мужчина</option>';
                                echo '<option value="Женщина">Женщина</option>';
                            } elseif ($_SESSION['REGISTER']['CUSTOMER']['gender'] == 'female') {
                                echo '<option value="select_gender">Выберите роль сотрудника</option>';
                                echo '<option value="Мужчина">Мужчина</option>';
                                echo '<option selected value="Женщина">Женщина</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="surname" class="visually-hidden">Фамилия</label>
                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Фамилия"
                               value="<?php echo $_SESSION['REGISTER']['CUSTOMER']['surname'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="name" class="visually-hidden">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Имя"
                               value="<?php echo $_SESSION['REGISTER']['CUSTOMER']['name'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="middleName" class="visually-hidden">Отчество</label>
                        <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Отчество"
                               value="<?php echo $_SESSION['REGISTER']['CUSTOMER']['middleName'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="dateBirth" class="">Дата рождения</label>
                        <input type="date" class="form-control" id="dateBirth" name="dateBirth" placeholder="Дата рождения: 0000 00 00"
                               value="<?php echo $_SESSION['REGISTER']['CUSTOMER']['dateBirth'] ?>"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="address" class="visually-hidden">Адрес</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Адрес"
                               value="<?php echo $_SESSION['REGISTER']['CUSTOMER']['address'] ?>" minlength="2"
                               maxlength="33"
                               required="">
                    </div>
                    <div class="col-12">
                        <label for="phoneNumber" class="visually-hidden">Номер телефона</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber"
                               placeholder="8 495 123-45-67"
                               value="<?php echo $_SESSION['REGISTER']['CUSTOMER']['phoneNumber'] ?>" minlength="10"
                               maxlength="15"
                               required="">
                    </div>
                    <div class="col-12">
                        <?
                        //вывод ошибок
                        if ($_SESSION['REGISTER']['CUSTOMER']['reg'] == false & !empty($_SESSION['REGISTER']['CUSTOMER']['ERRORS']))
                        {
                            foreach ($_SESSION['REGISTER']['CUSTOMER']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-1 text-center" role="alert">' . $error . '</div>';
                            }
                        }

                        //вывод успешный действий
                        if ($_SESSION['REGISTER']['CUSTOMER']['reg'] == true & !empty($_SESSION['REGISTER']['CUSTOMER']['SUCCESS']))
                        {
                            foreach ($_SESSION['REGISTER']['CUSTOMER']['SUCCESS'] as $success)
                            {
                                echo '<div class="alert alert alert-success mb-1 p-1 text-center" role="alert">' . $success . '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>

                <button class="w-100 btn btn-primary btn-lg" type="submit">Зарегистрировать Клиента</button>
            </form>
        </div>
    </div>
</div>
