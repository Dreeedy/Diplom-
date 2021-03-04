<?
/*01-Подключение к базе данных*/
require_once "rb/rb-mysql.php";
require_once "dbConnection.php";
require_once "my_help.php";

R::setup(get_db_dns(), get_db_username(), get_db_password());

if (!R::testConnection())
{
    exit('Нет подключения к базе данных');
}
/*02-Подключение к базе данных*/
//Беру из базы всех сотрудников
$usersandbookacts_arr = R::findall('usersandbookacts');

$all_dates_arr = get_all_dates($usersandbookacts_arr);

function get_all_dates($usersandbookacts_arr_local)
{
    $all_dates_arr_local = [];
    $id = 0;
    foreach ($usersandbookacts_arr_local as $act)
    {
        //тут добавление даты в массив, уникальных
        if (in_array ($act->year , $all_dates_arr_local))
        {

        }else
        {//если нету в массиве такой даты, по пихаю ее туда
            $all_dates_arr_local[] = $act->year;
        }
    }
    return $all_dates_arr_local;
}

?>
<!--<table class="table table-striped table-hover">-->
<!--    <thead>-->
<!--    <tr>-->
<!--        <th scope="col">#</th>-->
<!--        <th scope="col">Фамилия</th>-->
<!--        <th scope="col">Имя</th>-->
<!--        <th scope="col">Отчество</th>-->
<!--        <th scope="col">Телефон</th>-->
<!--        <th scope="col">Адрес</th>-->
<!--        <th scope="col"></th>-->
<!--    </tr>-->
<!--    </thead>-->
<!--    <tbody>-->
    <?
//    $i = 1;
//    $badge_bg = "";
//
//    foreach ($customers_arr as $customer)
//    {
//        echo
//            '
//    <tr>
//        <th scope="row">'.$i.'</th>
//        <td>'.$customer->surname.'</td>
//        <td>'.$customer->name.'</td>
//        <td>'.$customer->middle_name.'</td>
//        <td>'.$customer->phone_number.'</td>
//        <td>'.$customer->address.'</td>
//        <td>
//        <form method="get" action="../customers_show.php">
//            <input type="hidden" name="customer_id" value='.$customer->id.'>
//            <input type="hidden" name="customer_surname" value='.$customer->surname.'>
//            <input type="hidden" name="customer_name" value='.$customer->name.'>
//            <input type="hidden" name="customer_middle_name" value='.$customer->middle_name.'>
//            <input type="hidden" name="customer_phone_number" value='.$customer->phone_number.'>
//            <input type="hidden" name="customer_address" value='.$customer->address.'>
//            <button type="submit" class="btn btn-outline-primary btn-sm">Выбрать</button>
//        </form>
//        </td>
//    </tr>
//    ';
//        $i++;
//    }
    ?>
<!--    </tbody>-->
<!--</table>-->

<!-- 01 - Года - Open -->
<? foreach ($all_dates_arr as $data): ?>
    <div class="accordion-item">
        <h2 class="accordion-header" id="flush-headingOne_<?= $data; ?>">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne_<?= $data; ?>" aria-expanded="false" aria-controls="flush-collapseOne_<?= $data; ?>">
                <?= $data; ?>
            </button>
        </h2>
        <div id="flush-collapseOne_<?= $data; ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne_<?= $data; ?>" data-bs-parent="#accordionFlushExample_<?= $data; ?>">
            <div class="accordion-body px-0">
                <!-- 01 - Четыре вида актов - Open -->
                1
                2
                3
                4
                <!-- 02 - Четыре вида актов - Close -->
            </div>
        </div>
    </div>
<? endforeach; ?>
<!-- 02 - Года - Close -->
