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

get_statistic();



function get_statistic()
{
    fill_session();

    get_all_statistic();
    get_single_statistic();

    header('location: ../statisticPage.php');
}

function get_all_statistic()
{
    $startDate = $_SESSION['STATISTIC']['beginning_period'];
    $finishDate = $_SESSION['STATISTIC']['end_period'];

    $allCountBirthacts = R::count( 'birthacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );
    $allCountMarriageacts = R::count( 'marriageacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );
    $allCountAdoptionacts = R::count( 'adoptionacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );
    $allCountDeathacts = R::count( 'deathacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );
    $allCountDivorceacts = R::count( 'divorceacts', ' date >= ? and date <= ?', [ $startDate, $finishDate] );

    $_SESSION['STATISTIC']['all_count_birthacts'] = $allCountBirthacts;
    $_SESSION['STATISTIC']['all_count_marriageacts'] = $allCountMarriageacts;
    $_SESSION['STATISTIC']['all_count_adoptionacts'] = $allCountAdoptionacts;
    $_SESSION['STATISTIC']['all_count_deathacts'] = $allCountDeathacts;
    $_SESSION['STATISTIC']['all_count_divorceacts'] = $allCountDivorceacts;
}

function get_single_statistic()
{
    $surname = $_SESSION['STATISTIC']['surname'];
    $name = $_SESSION['STATISTIC']['name'];
    $middlename = $_SESSION['STATISTIC']['middlename'];

    if ($surname != "" && $name != "" && $middlename != "")
    {
        $staff = R::findOne('staff', 'surname = ? and name = ? and middle_name = ?', [$surname, $name, $middlename]);
        $staffId = $staff->id;
    }

    $startDate = $_SESSION['STATISTIC']['beginning_period'];
    $finishDate = $_SESSION['STATISTIC']['end_period'];

    $singleCountBirthacts = R::count( 'birthacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );
    $singleCountMarriageacts = R::count( 'marriageacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );
    $singleCountAdoptionacts = R::count( 'adoptionacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );
    $singleCountDeathacts = R::count( 'deathacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );
    $singleCountDivorceacts = R::count( 'divorceacts', ' date >= ? and date <= ? and staff_id = ?', [ $startDate, $finishDate, $staffId] );

    $_SESSION['STATISTIC']['single_count_birthacts'] = $singleCountBirthacts;
    $_SESSION['STATISTIC']['single_count_marriageacts'] = $singleCountMarriageacts;
    $_SESSION['STATISTIC']['single_count_adoptionacts'] = $singleCountAdoptionacts;
    $_SESSION['STATISTIC']['single_count_deathacts'] = $singleCountDeathacts;
    $_SESSION['STATISTIC']['single_count_divorceacts'] = $singleCountDivorceacts;
}

function fill_session()
{
    $_SESSION['STATISTIC']['beginning_period'] = $_POST['beginning_period'];
    $_SESSION['STATISTIC']['end_period'] = $_POST['end_period']; //date("Y-m-d");

    $_SESSION['STATISTIC']['all_count_birthacts'] = null;
    $_SESSION['STATISTIC']['all_count_marriageacts'] = null;
    $_SESSION['STATISTIC']['all_count_adoptionacts'] = null;
    $_SESSION['STATISTIC']['all_count_deathacts'] = null;
    $_SESSION['STATISTIC']['all_count_divorceacts'] = null;

    $_SESSION['STATISTIC']['surname'] = $_POST['surname'];
    $_SESSION['STATISTIC']['name'] = $_POST['name'];
    $_SESSION['STATISTIC']['middlename'] = $_POST['middlename'];

    $_SESSION['STATISTIC']['single_count_birthacts'] = null;
    $_SESSION['STATISTIC']['single_count_marriageacts'] = null;
    $_SESSION['STATISTIC']['single_count_adoptionacts'] = null;
    $_SESSION['STATISTIC']['single_count_deathacts'] = null;
    $_SESSION['STATISTIC']['single_count_divorceacts'] = null;
}