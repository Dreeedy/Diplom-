<div class="container" style="min-height: 873px;">
<!--01 Горизонтальное меню-->
<? require_once 'horizontal_menu/horizontalMenu.php'?>
<!--02 Горизонтальное меню-->
<!--01 Кусок таблицы-->
    <div class="pt-2 pb-1 row">
        <h2 class="col-auto">Клиенты</h2>
        <!--<div class="col btn-outline-primary btn text-start my-auto">
            Выбран: <?/* echo $_GET['customer_surname'].' '.
                $_GET['customer_name'].' '.
                $_GET['customer_middle_name'].' '.
                $_GET['customer_phone_number'].' '.
                $_GET['customer_address'];*/?>
        </div>-->
    </div>

    <div class="overflow-auto" style="max-height: 663px">
        <? require_once "./tables/customers_main_show_table.php" ?>
    </div>
<!--02 Кусок таблицы-->
</div>
