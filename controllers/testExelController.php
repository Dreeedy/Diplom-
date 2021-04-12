<?php
session_start();

/*01-Подключение к базе данных*/
require_once "../rb/rb-mysql.php";
require_once "../dbConnection.php";
require_once "../my_help.php";
require_once "../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

R::setup(get_db_dns(), get_db_username(), get_db_password());

if (!R::testConnection())
{
    exit('Нет подключения к базе данных');
}
/*02-Подключение к базе данных*/

fill_session();
//clear_session();

//создается exel файл его название формирует галочка, соло чел или все + периуд с какого по какой
//в зависемости от галок создает в exel файле листы по каждому на тип акта
//если там все челы, то инфа по акту + какой работник
//елли там соло чел, то инфа по акту

$spreadsheet = new Spreadsheet();

$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle('лист1');

$sheet2 = $spreadsheet->createSheet();
$sheet2->setTitle('лист2');

$sheet3 = $spreadsheet->createSheet();
$sheet3->setTitle('лист3');

$sheet4 = $spreadsheet->createSheet();
$sheet4->setTitle('лист4');

$sheet5 = $spreadsheet->createSheet();
$sheet5->setTitle('лист5');

$sheet1->setCellValue('A1', 'Hello World !');

if ($_SESSION['REPORT']['switch_all_staff'] == 1)
{//если все челы
    $writer = new Xlsx($spreadsheet);
    $writer->save('all name.xlsx');
}
else
{//если соло чел
    $writer = new Xlsx($spreadsheet);
    $writer->save('single name.xlsx');
}

function fill_session()
{
    $_SESSION['REPORT']['switch_all_staff'] = $_POST['switch_all_staff'];
}

function clear_session()
{
    $_SESSION['REPORT']['switch_all_staff'] = 0;
}

myDump($_POST);
myDump($_SESSION['REPORT']['switch_all_staff']);
