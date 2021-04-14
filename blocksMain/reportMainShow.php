<div class="container" style="min-height: 873px;">
    <!--01 Горизонтальное меню-->
    <? require_once 'horizontal_menu/horizontalMenu.php' ?>
    <!--02 Горизонтальное меню-->

    <div class="py-3">
        <form method="POST" action="../controllers/reportShowController.php" id="form1" name="form1">

            <!-- 01 - Даты - Open -->
            <div class="row">
                <div class="col-md">
                    <label for="startDate" class="form-label">Начало периода</label>
                    <input type="date" class="form-control" id="beginning_period" name="beginning_period"
                           value="<? echo $_SESSION['REPORT']['beginning_period'] ?>">
                </div>
                <div class="col-md">
                    <label for="finishDate" class="form-label">Конец периода</label>
                    <input type="date" class="form-control" id="end_period" name="end_period"
                           value="<? echo $_SESSION['REPORT']['end_period'] ?>">
                </div>
            </div>
            <!-- 02 - Даты - Close -->

            <!-- 01 - Общая статистика - Open -->
            <div>
                <h2>Свидетельства</h2>
                <div class="row">

                    <!-- 01 - Левая сторона - Open -->
                    <div class="col-md">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="check_is_birthacts"
                                   id="check_is_birthacts">
                            <label class="form-check-label" for="check_is_birthacts">
                                Свидетельства о рождении
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="check_is_marriageacts"
                                   id="check_is_marriageacts">
                            <label class="form-check-label" for="check_is_marriageacts">
                                Свидетельства о заключении брака
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="check_is_adoptionacts"
                                   id="check_is_adoptionacts">
                            <label class="form-check-label" for="check_is_adoptionacts">
                                Свидетельства о усыновлении
                            </label>
                        </div>
                    </div>
                    <!-- 02 - Левая сторона - Close -->

                    <!-- 01 - Правая сторона - Open -->
                    <div class="col-md">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="check_is_deathacts"
                                   id="check_is_deathacts">
                            <label class="form-check-label" for="check_is_deathacts">
                                Свидетельства о смерти
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="check_is_divorceacts"
                                   id="check_is_divorceacts">
                            <label class="form-check-label" for="check_is_divorceacts">
                                Свидетельства о расторжении брака
                            </label>
                        </div>
                    </div>
                    <!-- 02 - Правая сторона - Close -->

                </div>
            </div>
            <!-- 02 - Общая статистика - Close -->

            <!-- 01 - Поиск сотрудника - Open -->
            <div>
                <div class="row">
                    <h2 class="col-md-auto">Поиск сотрудника</h2>
                    <div class="col-md-auto">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" value="1" name="switch_all_staff"
                                   id="switch_is_all_staff">
                            <label class="form-check-label" for="switch_all_staff">Отчет по всем сотрудникам</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <form>
                        <div class="col-md">
                            <label for="" class="form-label">Фамилия</label>
                            <input type="text" class="form-control" id="surname" name="surname"
                                   value="<? echo $_SESSION['REPORT']['surname'] ?>">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="<? echo $_SESSION['REPORT']['name'] ?>">
                        </div>
                        <div class="col-md">
                            <label for="" class="form-label">Отчество</label>
                            <input type="text" class="form-control" id="middlename" name="middlename"
                                   value="<? echo $_SESSION['REPORT']['middlename'] ?>">
                        </div>
                        <div class="col-md-auto">
                            <div style="height: 27px; margin-bottom: 9px"></div>
                            <button type="button" id="sendStaffBut" class="btn btn-primary">Поиск</button>
                        </div>
                    </form>
                    <!-- 02 - Поиск сотрудника - Close -->
                    <!-- 01 - Вывод ошибок - Open -->
                    <div id="errors_div">
                        <?
                        if (!empty($_SESSION['REPORT']['ERRORS']))
                        {
                            foreach ($_SESSION['REPORT']['ERRORS'] as $error)
                            {
                                echo '<div class="alert alert-danger mb-1 p-2 text-center" role="alert">' . $error . '</div>';
                            }
                            $_SESSION['REPORT']['ERRORS'] = [];
                        }
                        ?>
                    </div>
                    <?
                    if (!empty($_SESSION['REPORT']['ERRORS']))
                    {
                        foreach ($_SESSION['REPORT']['ERRORS'] as $error)
                        {
                            echo '<div class="alert alert-danger mb-1 p-2 text-center" role="alert">' . $error . '</div>';
                        }
                        $_SESSION['REPORT']['ERRORS'] = [];
                    }
                    ?>
                    <!-- 02 - Вывод ошибок - Close -->
                    <!-- 01 - Список отчетов - Open -->
                    <div class="py-3 overflow-auto" style="max-height: 200px">
                        <h2 class="col-md-auto">Скачать готовые отчеты</h2>
                        <?
                        $a = scandir('export');
                        unset($a[0]);
                        unset($a[1]);
                        $a = array_values($a);
                        ?>

                        <?php foreach ($a as $key => $value): ?>
                            <a href="../export/<? echo $value ?>" download> <? echo $value ?> </a>
                            <br>
                        <?php endforeach; ?>
                    </div>
                    <!-- 02 - Список отчетов - Close -->


                    <!-- 01 - Экспортировать отчет - Open -->
                    <div class="py-3">
                        <button type="submit" class="w-100 btn btn-primary">Сформировать отчет</button>
                    </div>
                    <!-- 02 - Экспортировать отчет - Close -->
        </form>
    </div>
</div>

<script src="../js/reportMainShowStaffSearch.js"></script>