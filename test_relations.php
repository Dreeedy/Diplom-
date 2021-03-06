<?php
session_start();

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

$teacher = R::dispense('person');
$teacher->is_teacher = 1;
$teacher->name = 'Дебил Препод';

$student = R::dispense('person');
$student->is_teacher = 0;
$student->name = 'Умный студик';

$hui22 = R::dispense('hui');
$hui22->name = 'работник года';

$course = R::dispense('course');
$course->teacher = $teacher;
$course->student = $student;
$course->hui22 = $hui22;

R::store($course);