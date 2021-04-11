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

/*myDump($_POST);*/

myDump($_POST);

get_statistic();



function get_statistic()
{
    fill_session();

    get_all_statistic();
    get_single_statistic();

    header('location: ../reportPage.php');

    //clear_session();
}

function get_all_statistic()
{
    $startDate = $_SESSION['REPORT']['beginning_period'];
    $finishDate = $_SESSION['REPORT']['end_period'];

    $allCountBirthacts = R::count( 'birthacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );
    $allCountMarriageacts = R::count( 'marriageacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );
    $allCountAdoptionacts = R::count( 'adoptionacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );
    $allCountDeathacts = R::count( 'deathacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );
    $allCountDivorceacts = R::count( 'divorceacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );

    $_SESSION['REPORT']['all_count_birthacts'] = $allCountBirthacts;
    $_SESSION['REPORT']['all_count_marriageacts'] = $allCountMarriageacts;
    $_SESSION['REPORT']['all_count_adoptionacts'] = $allCountAdoptionacts;
    $_SESSION['REPORT']['all_count_deathacts'] = $allCountDeathacts;
    $_SESSION['REPORT']['all_count_divorceacts'] = $allCountDivorceacts;
}

function get_single_statistic()
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

    $startDate = $_SESSION['REPORT']['beginning_period'];
    $finishDate = $_SESSION['REPORT']['end_period'];

    $singleCountBirthacts = R::count( 'birthacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );
    $singleCountMarriageacts = R::count( 'marriageacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );
    $singleCountAdoptionacts = R::count( 'adoptionacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );
    $singleCountDeathacts = R::count( 'deathacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );
    $singleCountDivorceacts = R::count( 'divorceacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );

    $_SESSION['REPORT']['single_count_birthacts'] = $singleCountBirthacts;
    $_SESSION['REPORT']['single_count_marriageacts'] = $singleCountMarriageacts;
    $_SESSION['REPORT']['single_count_adoptionacts'] = $singleCountAdoptionacts;
    $_SESSION['REPORT']['single_count_deathacts'] = $singleCountDeathacts;
    $_SESSION['REPORT']['single_count_divorceacts'] = $singleCountDivorceacts;
}

function fill_session()
{
    $_SESSION['REPORT']['beginning_period'] = $_POST['beginning_period'];
    $_SESSION['REPORT']['end_period'] = $_POST['end_period']; //date("Y-m-d");

    $_SESSION['REPORT']['check_is_birthacts'] = $_POST['check_is_birthacts'];
    $_SESSION['REPORT']['check_is_marriageacts'] = $_POST['check_is_marriageacts'];
    $_SESSION['REPORT']['check_is_adoptionacts'] = $_POST['check_is_adoptionacts'];
    $_SESSION['REPORT']['check_is_deathacts'] = $_POST['check_is_deathacts'];
    $_SESSION['REPORT']['check_is_divorceacts'] = $_POST['check_is_divorceacts'];

    $_SESSION['REPORT']['surname'] = $_POST['surname'];
    $_SESSION['REPORT']['name'] = $_POST['name'];
    $_SESSION['REPORT']['middlename'] = $_POST['middlename'];

    $_SESSION['REPORT']['ERRORS'] = [];
}

function clear_session()
{
    $_SESSION['REPORT']['ERRORS'] = [];
}