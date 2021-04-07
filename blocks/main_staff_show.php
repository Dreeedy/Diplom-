<div class="container" style="min-height: 873px;">
    <!--01 Горизонтальное меню-->
    <? require_once './blocksMain/horizontal_menu/horizontalMenu.php' ?>
    <? if (isset($_SESSION['filter_staff_not_works']) && $_SESSION['filter_staff_not_works'] != 1){$_SESSION['filter_staff_not_works'] = 0;} ?>
    <!--02 Горизонтальное меню-->
    <!--01 Кусок таблицы-->
    <form method="POST" action="../controllers/staffTableFilterController.php">
        <div class="pt-2 pb-1 row">
            <h2 class="col-auto">Персонал</h2>
            <!--<div class="col btn-outline-primary btn text-start my-auto">
            Выбран: <? /* echo $_GET['customer_surname'].' '.
                $_GET['customer_name'].' '.
                $_GET['customer_middle_name'].' '.
                $_GET['customer_phone_number'].' '.
                $_GET['customer_address'];*/ ?>
        </div>-->
            <div class="col-auto my-auto">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="filter_staff_not_works" id="filter_staff_not_works" <? if ($_SESSION['filter_staff_not_works'] == 0){ echo '';}else{ echo 'checked';} ?> >
                    <label class="form-check-label" for="check_is_works">
                        Уволен
                    </label>
                </div>
            </div>
            <div class="col-auto">
                <button class="w-100 btn btn-md btn-primary text-start" type="submit">
                    Применить фильтр
                </button>
            </div>
        </div>
    </form>

    <div class="overflow-auto" style="max-height: 663px">
        <? require_once "tables/main_staff_show_table.php" ?>
    </div>
    <!--02 Кусок таблицы-->
</div>
