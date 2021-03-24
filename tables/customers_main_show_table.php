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
    $_POST = null;
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
        
        <td>'.$customer->gender. '</td>        
        <td>
        <form method="POST" action="../controllers/customersEditController.php">
            <input type="hidden" name="customerId" value='.$customer->id.'>
            
            <input type="hidden" name="surname" value='.$customer->surname.'>
            <input type="hidden" name="name" value='.$customer->name.'>
            <input type="hidden" name="middleName" value='.$customer->middle_name.'>
            
            <input type="hidden" name="dateBirth" value='.$customer->date_birth.'>            
            <input type="hidden" name="address" value='.$customer->address.'>
            <input type="hidden" name="phoneNumber" value='.$customer->phone_number.'>
            
            <input type="hidden" name="gender" value='.$customer->gender.'>
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