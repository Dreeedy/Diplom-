<?
/*01-Подключение к базе данных*/
require_once "rb/rb-mysql.php";
require_once "dbConnection.php";

R::setup(get_db_dns(), get_db_username(), get_db_password());

if (!R::testConnection())
{
    exit('Нет подключения к базе данных');
}
/*02-Подключение к базе данных*/
//Беру из базы всех сотрудников
$customers_arr = R::findall('customers');
?>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Фамилия</th>
        <th scope="col">Имя</th>
        <th scope="col">Отчество</th>
        <th scope="col">Телефон</th>
        <th scope="col">Адрес</th>
    </tr>
    </thead>
    <tbody>
    <?
    $i = 1;
    $badge_bg = "";

    foreach ($customers_arr as $customer)
    {
        echo
            '
    <tr>
        <th scope="row">'.$i.'</th>
        <td>'.$customer->surname.'</td>
        <td>'.$customer->name.'</td>
        <td>'.$customer->middle_name.'</td>
        <td>'.$customer->phone_number.'</td>
        <td>'.$customer->address.'</td>
    </tr>
    ';
        $i++;
    }
    ?>
    </tbody>
</table>