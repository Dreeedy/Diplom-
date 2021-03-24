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

        <th scope="col">Дата рождения</th>

        <th scope="col">Телефон</th>
        <th scope="col">Адрес</th>

        <th scope="col">Пол</th>

        <th scope="col"></th>
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
        
        <td>'.$customer->date_birth.'</td>
        
        <td>'.$customer->phone_number.'</td>
        <td>'.$customer->address.'</td>
        
        <td>'.$customer->gender.'</td>        
        <td>
        <form method="get" action="../customers_show.php">
            <input type="hidden" name="customer_id" value='.$customer->id.'>
            <input type="hidden" name="customer_surname" value='.$customer->surname.'>
            <input type="hidden" name="customer_name" value='.$customer->name.'>
            <input type="hidden" name="customer_middle_name" value='.$customer->middle_name.'>
            <input type="hidden" name="customer_phone_number" value='.$customer->phone_number.'>
            <input type="hidden" name="customer_address" value='.$customer->address.'>
            <button type="submit" class="btn btn-outline-primary btn-sm">Редактировать</button>
        </form>
        </td>
    </tr>
    ';
        $i++;
    }
    ?>
    </tbody>
</table>