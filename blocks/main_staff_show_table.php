<?
/*01-Подключение к базе данных*/
require "rb/rb-mysql.php";
require_once "dbConnection.php";

R::setup(get_db_dns(), get_db_username(), get_db_password());

if (!R::testConnection())
{
    exit('Нет подключения к базе данных');
}
/*02-Подключение к базе данных*/
//Беру из базы всех сотрудников
$staff_arr = R::findall('staff');
?>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Фамилия</th>
        <th scope="col">Имя</th>
        <th scope="col">Отчество</th>
        <th scope="col">Телефон</th>
        <th scope="col">Роль</th>
    </tr>
    </thead>
    <tbody>
<?
$i = 1;
$badge_bg = "";

foreach ($staff_arr as $staff)
{
    if ($staff->roles_id == 3)
    {
        $badge_bg = 'class="badge bg-danger"';
    }
    if ($staff->roles_id == 2)
    {
        $badge_bg = 'class="badge bg-warning text-dark"';
    }
    echo
    '
    <tr>
        <th scope="row">'.$i.'</th>
        <td>'.$staff->surname.'</td>
        <td>'.$staff->name.'</td>
        <td>'.$staff->middle_name.'</td>
        <td>'.$staff->phone_number.'</td>
        <td><span '.$badge_bg.'>'.$staff->roles->role_name.'</span></td>
    </tr>
    ';

    $i++;
    $badge_bg = "";
}
?>
    </tbody>
</table>