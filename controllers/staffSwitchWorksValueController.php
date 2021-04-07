<?php
session_start();

/*01-Подключение к базе данных*/
require_once "../rb/rb-mysql.php";
require_once "../dbConnection.php";
require_once "../my_help.php";

R::setup(get_db_dns(), get_db_username(), get_db_password());

if (!R::testConnection())
{
    exit('Нет подключения к базе данных');
}
/*02-Подключение к базе данных*/

$staf_id = $_POST['staff_id'];
$staf = R::load('staff', $staf_id);

if ($_POST['switch_it_works'] == 1)
{
    $staf->it_works = 1;
    R::store($staf);
    header('location: ../show_staff.php');
}
elseif ($_POST['switch_it_works'] == 0)
{
    $staf->it_works = 0;
    R::store($staf);
    header('location: ../show_staff.php');
}