<div class="container" style="min-height: 873px;">
    <!--01 Горизонтальное меню-->
    <? require_once 'horizontal_menu/horizontalMenu.php' ?>
    <!--02 Горизонтальное меню-->

    <div class="py-3">
        <form method="POST" action="../controllers/statisticShowController.php" id="form1" name="form1">

            <!-- 01 - Даты - Open -->
            <div class="row">
                <div class="col-md">
                    <label for="startDate" class="form-label">Начало периода</label>
                    <input type="date" class="form-control" id="beginning_period" name="beginning_period"
                           value="<? echo $_SESSION['STATISTIC']['beginning_period'] ?>">
                </div>
                <div class="col-md">
                    <label for="finishDate" class="form-label">Конец периода</label>
                    <input type="date" class="form-control" id="end_period" name="end_period"
                           value="<? echo $_SESSION['STATISTIC']['end_period'] ?>">
                </div>
            </div>
            <!-- 02 - Даты - Close -->

            <!-- 01 - Общая статистика - Open -->
            <div>
                <h2>Общая статистика</h2>
                <div class="row">

                    <!-- 01 - Левая сторона - Open -->
                    <div class="col-md">
                        <div>
                            <label for="" class="form-label">Свидетельств о рождении</label>
                            <input type="text" class="form-control" id="all_count_birthacts" name="all_count_birthacts" value="<? echo $_SESSION['STATISTIC']['all_count_birthacts']?>">
                        </div>
                        <div>
                            <label for="" class="form-label">Свидетельств о заключении брака</label>
                            <input type="text" class="form-control" id="all_count_marriageacts" name="all_count_marriageacts" value="<? echo $_SESSION['STATISTIC']['all_count_marriageacts']?>">
                        </div>
                        <div>
                            <label for="" class="form-label">Свидетельств о усыновлении</label>
                            <input type="text" class="form-control" id="all_count_adoptionacts" name="all_count_adoptionacts" value="<? echo $_SESSION['STATISTIC']['all_count_adoptionacts']?>">
                        </div>
                    </div>
                    <!-- 02 - Левая сторона - Close -->

                    <!-- 01 - Правая сторона - Open -->
                    <div class="col-md">
                        <div>
                            <label for="" class="form-label">Свидетельств о смерти</label>
                            <input type="text" class="form-control" id="all_count_deathacts" name="all_count_deathacts" value="<? echo $_SESSION['STATISTIC']['all_count_deathacts']?>">
                        </div>
                        <div>
                            <label for="" class="form-label">Свидетельств о расторжении брака</label>
                            <input type="text" class="form-control" id="all_count_divorceacts" name="all_count_divorceacts" value="<? echo $_SESSION['STATISTIC']['all_count_divorceacts']?>">
                        </div>
                    </div>
                    <!-- 02 - Правая сторона - Close -->

                </div>
            </div>
            <!-- 02 - Общая статистика - Close -->

            <!-- 01 - Поиск сотрудника - Open -->
            <div>
                <h2>Поиск сотрудника</h2>
                <!--                <form method="POST" action="../controllers/statisticShowController.php" id="form2" name="form2">-->
                <div class="row">
                    <div class="col-md">
                        <label for="" class="form-label">Фамилия</label>
                        <input type="text" class="form-control" name="surname" value="<? echo $_SESSION['STATISTIC']['surname']?>">
                    </div>
                    <div class="col-md">
                        <label for="" class="form-label">Имя</label>
                        <input type="text" class="form-control" name="name" value="<? echo $_SESSION['STATISTIC']['name']?>">
                    </div>
                    <div class="col-md">
                        <label for="" class="form-label">Отчество</label>
                        <input type="text" class="form-control" name="middlename" value="<? echo $_SESSION['STATISTIC']['middlename']?>">
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary">Поиск</button>
                    </div>
                </div>
                <!--                </form>-->
                <div style="background-color: red">
                    ERRORS
                </div>
            </div>
            <!-- 02 - Поиск сотрудника - Close -->

            <!-- 01 - Статистика сотрудника - Open -->
            <div>
                <h2>Статистика сотрудника</h2>
                <div class="row">

                    <!-- 01 - Левая сторона - Open -->
                    <div class="col-md">
                        <div>
                            <label for="" class="form-label">Свидетельств о рождении</label>
                            <input type="text" class="form-control" id="single_count_birthacts" name="single_count_birthacts" value="<? echo $_SESSION['STATISTIC']['single_count_birthacts']?>">
                        </div>
                        <div>
                            <label for="" class="form-label">Свидетельств о заключении брака</label>
                            <input type="text" class="form-control" id="single_count_marriageacts" name="single_count_marriageacts" value="<? echo $_SESSION['STATISTIC']['single_count_marriageacts']?>">
                        </div>
                        <div>
                            <label for="" class="form-label">Свидетельств о усыновлении</label>
                            <input type="text" class="form-control" id="single_count_adoptionacts" name="single_count_adoptionacts" value="<? echo $_SESSION['STATISTIC']['single_count_adoptionacts']?>">
                        </div>
                    </div>
                    <!-- 02 - Левая сторона - Close -->

                    <!-- 01 - Правая сторона - Open -->
                    <div class="col-md">
                        <div>
                            <label for="" class="form-label">Свидетельств о смерти</label>
                            <input type="text" class="form-control" id="single_count_deathacts" name="single_count_deathacts" value="<? echo $_SESSION['STATISTIC']['single_count_deathacts']?>">
                        </div>
                        <div>
                            <label for="" class="form-label">Свидетельств о расторжении брака</label>
                            <input type="text" class="form-control" id="single_count_divorceacts" name="single_count_divorceacts" value="<? echo $_SESSION['STATISTIC']['single_count_divorceacts']?>">
                        </div>
                    </div>
                    <!-- 02 - Правая сторона - Close -->

                </div>
            </div>
            <!-- 02 - Статистика сотрудника - Close -->

            <!-- 01 - Обновить статистику - Open -->
            <div class="py-3">
                <button type="submit" class="w-100 btn btn-primary">Обновить статистику</button>
            </div>
            <!-- 02 - Обновить статистику - Close -->
        </form>
    </div>
</div>
