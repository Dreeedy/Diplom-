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
if ($_SESSION['filter_staff_not_works'] == 0)
{
    $works_staff_arr = R::findall('staff', 'WHERE it_works > 0');//работающие
}
elseif ($_SESSION['filter_staff_not_works'] == 1)
{
    $works_staff_arr = R::findall('staff', 'WHERE it_works < 1');//не работающие
}



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
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
<?
$i = 1;
$badge_bg = "";

foreach ($works_staff_arr as $staff)
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
    ';
    if ($staff->it_works == 1)
    {
        echo
            '<td>
            <form method="POST" action="../controllers/staffSwitchWorksValueController.php">
            <input type="hidden" name="staff_id" value='.$staff->id.'>
            <input type="hidden" name="switch_it_works" value="0">
            <button type="submit" class="btn btn-outline-primary btn-sm">Уволить</button>
            </form>
            </td>
    </tr>
';
    }
    elseif ($staff->it_works == 0)
    {
        echo
            '<td>
            <form method="POST" action="../controllers/staffSwitchWorksValueController.php">
            <input type="hidden" name="staff_id" value='.$staff->id.'>
            <input type="hidden" name="switch_it_works" value="1">
            <button type="submit" class="btn btn-outline-primary btn-sm">Восстановить</button>
            </form>
            </td>
    </tr>
';
    }

    $i++;
    $badge_bg = "";
}
?>
    </tbody>
</table>


