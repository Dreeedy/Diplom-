<?php
/*01-Подключение к базе данных*/
require_once "../../rb/rb-mysql.php";
require_once "../../dbConnection.php";
require_once "../../my_help.php";
require_once "../../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

R::setup(get_db_dns(), get_db_username(), get_db_password());

if (!R::testConnection())
{
    exit('Нет подключения к базе данных');
}
/*02-Подключение к базе данных*/

get_staff();

function get_staff()
{
    fill_session();
    find_staff();

    $arr = get_errors();
    $json_arr = json_encode($arr);
    echo($json_arr);
}

function fill_session()
{
    $_SESSION['REPORT']['surname'] = $_POST['surname'];
    $_SESSION['REPORT']['name'] = $_POST['name'];
    $_SESSION['REPORT']['middlename'] = $_POST['middlename'];

    $_SESSION['REPORT']['ERRORS'] = [];
}

function find_staff()
{
    $surname = $_SESSION['REPORT']['surname'];
    $name = $_SESSION['REPORT']['name'];
    $middlename = $_SESSION['REPORT']['middlename'];

    if (preg_match('/[^,\p{Cyrillic}]/ui', $surname))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['REPORT']['ERRORS'], "Фамилия может содержать только кириллицу");
    }
    if (preg_match('/[^,\p{Cyrillic}]/ui', $name))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['REPORT']['ERRORS'], "Имя может содержать только кириллицу");
    }
    if (preg_match('/[^,\p{Cyrillic}]/ui', $middlename))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['REPORT']['ERRORS'], "Отчество может содержать только кириллицу");
    }

    if ($surname != "" && $name != "" && $middlename != "")
    {
        $staff = R::findOne('staff', 'surname = ? and name = ? and middle_name = ?', [$surname, $name, $middlename]);
        $staffId = $staff->id;
    }
    if ($staff->id == null && empty($_SESSION['REPORT']['ERRORS']))
    {
        array_push($_SESSION['REPORT']['ERRORS'], "Сотрудник не найден");
    }
}

function get_errors()
{
    $arr = [];
    if (!empty($_SESSION['REPORT']['ERRORS']))
    {
        foreach ($_SESSION['REPORT']['ERRORS'] as $error)
        {
            array_push($arr, $error);
        }
    }
    return $arr;
}
