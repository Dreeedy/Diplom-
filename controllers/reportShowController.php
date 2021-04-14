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

get_report();

function get_report()
{
    fill_session();

    if ($_SESSION['REPORT']['switch_all_staff'] == 1)
    {//если все челы
        get_all_report();
    }
    else
    {//если соло чел
        get_single_report();
    }

    header('location: ../reportPage.php');

    clear_session();
}

function get_all_report()
{
    $startDate = $_SESSION['REPORT']['beginning_period'];
    $finishDate = $_SESSION['REPORT']['end_period'];

    /* 01 - generate single exel - Open */
    $spreadsheet = new Spreadsheet();//создание самого exel файла
    $spreadsheet->removeSheetByIndex(0);//удаляю стандартный лист

    if ($_SESSION['REPORT']['check_is_birthacts'] == 1)//если поставлена галочка
    {
        $sheet1 = $spreadsheet->createSheet();//создание листов
        $sheet1->setTitle('Акты о рождении');

        $allCountBirthacts = R::findAll('birthacts', ' date >= ? and date <= ?', [$startDate, $finishDate]);

        $i = 2;
        $sheet1->setCellValue('A1', 'ФИО ребенка')->getColumnDimension('A')->setAutoSize(true);
        $sheet1->setCellValue('B1', 'ФИО мужа')->getColumnDimension('B')->setAutoSize(true);
        $sheet1->setCellValue('C1', 'ФИО жены')->getColumnDimension('C')->setAutoSize(true);
        $sheet1->setCellValue('D1', 'Дата рождения')->getColumnDimension('D')->setAutoSize(true);
        $sheet1->setCellValue('E1', 'Дата регистрации')->getColumnDimension('E')->setAutoSize(true);
        $sheet1->setCellValue('F1', 'ФИО сотрудника')->getColumnDimension('F')->setAutoSize(true);
        foreach ($allCountBirthacts as $item)
        {
            $child = $item->fetchAs('customers')->child;
            $childFIO = $child->surname. " ".$child->name." ".$child->middle_name;
            $husband = $item->fetchAs('customers')->husband;
            $husbandFIO = $husband->surname. " ".$husband->name." ".$husband->middle_name;
            $wife = $item->fetchAs('customers')->wife;
            $wifeFIO = $wife->surname. " ".$wife->name." ".$wife->middle_name;
            $staff = $item->fetchAs('staff')->staff;
            $staffFIO = $staff->surname. " ".$staff->name." ".$staff->middle_name;

            $birthDate = $item->date_birth;
            $regDate = $item->date;

            $sheet1->setCellValue('A'.$i, $childFIO);
            $sheet1->setCellValue('B'.$i, $husbandFIO);
            $sheet1->setCellValue('C'.$i, $wifeFIO);
            $sheet1->setCellValue('D'.$i, $birthDate);
            $sheet1->setCellValue('E'.$i, $regDate);
            $sheet1->setCellValue('F'.$i, $staffFIO);

            $i++;
        }
    }
    if ($_SESSION['REPORT']['check_is_marriageacts'] == 1)
    {
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Акты о заключении брака');

        $allCountMarriageacts = R::findAll('marriageacts', ' date >= ? and date <= ?', [$startDate, $finishDate]);

        $i = 2;
        $sheet2->setCellValue('A1', 'ФИО мужа')->getColumnDimension('A')->setAutoSize(true);
        $sheet2->setCellValue('B1', 'ФИО жены')->getColumnDimension('B')->setAutoSize(true);
        $sheet2->setCellValue('C1', 'Дата заключения брака')->getColumnDimension('C')->setAutoSize(true);
        $sheet2->setCellValue('D1', 'Дата регистрации')->getColumnDimension('D')->setAutoSize(true);
        $sheet2->setCellValue('E1', 'ФИО сотрудника')->getColumnDimension('E')->setAutoSize(true);
        foreach ($allCountMarriageacts as $item)
        {
            $husband = $item->fetchAs('customers')->husband;
            $husbandFIO = $husband->surname. " ".$husband->name." ".$husband->middle_name;
            $wife = $item->fetchAs('customers')->wife;
            $wifeFIO = $wife->surname. " ".$wife->name." ".$wife->middle_name;
            $staff = $item->fetchAs('staff')->staff;
            $staffFIO = $staff->surname. " ".$staff->name." ".$staff->middle_name;

            $marriageDate = $item->date_marriage;
            $regDate = $item->date;

            $sheet2->setCellValue('A'.$i, $husbandFIO);
            $sheet2->setCellValue('B'.$i, $wifeFIO);
            $sheet2->setCellValue('C'.$i, $marriageDate);
            $sheet2->setCellValue('D'.$i, $regDate);
            $sheet2->setCellValue('E'.$i, $staffFIO);

            $i++;
        }
    }
    if ($_SESSION['REPORT']['check_is_adoptionacts'] == 1)
    {
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Акты о усыновлении');

        $allCountAdoptionacts = R::findAll('adoptionacts', ' date >= ? and date <= ?', [$startDate, $finishDate]);

        $i = 2;
        $sheet3->setCellValue('A1', 'ФИО ребенка')->getColumnDimension('A')->setAutoSize(true);
        $sheet3->setCellValue('B1', 'ФИО мужа')->getColumnDimension('B')->setAutoSize(true);
        $sheet3->setCellValue('C1', 'ФИО жены')->getColumnDimension('C')->setAutoSize(true);
        $sheet3->setCellValue('D1', 'Дата усыновления (удочерения)')->getColumnDimension('D')->setAutoSize(true);
        $sheet3->setCellValue('E1', 'Дата регистрации')->getColumnDimension('E')->setAutoSize(true);
        $sheet3->setCellValue('F1', 'ФИО сотрудника')->getColumnDimension('F')->setAutoSize(true);
        foreach ($allCountAdoptionacts as $item)
        {
            $child = $item->fetchAs('customers')->child;
            $childFIO = $child->surname. " ".$child->name." ".$child->middle_name;
            $husband = $item->fetchAs('customers')->husband;
            $husbandFIO = $husband->surname. " ".$husband->name." ".$husband->middle_name;
            $wife = $item->fetchAs('customers')->wife;
            $wifeFIO = $wife->surname. " ".$wife->name." ".$wife->middle_name;
            $staff = $item->fetchAs('staff')->staff;
            $staffFIO = $staff->surname. " ".$staff->name." ".$staff->middle_name;

            $adoptionDate = $item->date_birth;
            $regDate = $item->date;

            $sheet3->setCellValue('A'.$i, $childFIO);
            $sheet3->setCellValue('B'.$i, $husbandFIO);
            $sheet3->setCellValue('C'.$i, $wifeFIO);
            $sheet3->setCellValue('D'.$i, $adoptionDate);
            $sheet3->setCellValue('E'.$i, $regDate);
            $sheet3->setCellValue('F'.$i, $staffFIO);

            $i++;
        }
    }
    if ($_SESSION['REPORT']['check_is_deathacts'] == 1)
    {
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Акты о смерти');

        $allCountDeathacts = R::findAll('deathacts', ' date >= ? and date <= ?', [$startDate, $finishDate]);

        $i = 2;
        $sheet4->setCellValue('A1', 'ФИО')->getColumnDimension('A')->setAutoSize(true);
        $sheet4->setCellValue('B1', 'Дата наступления смерти')->getColumnDimension('B')->setAutoSize(true);
        $sheet4->setCellValue('C1', 'Дата регистрации')->getColumnDimension('C')->setAutoSize(true);
        $sheet4->setCellValue('D1', 'ФИО сотрудника')->getColumnDimension('D')->setAutoSize(true);
        foreach ($allCountDeathacts as $item)
        {
            $customer = $item->fetchAs('customers')->customer;
            $customerFIO = $customer->surname. " ".$customer->name." ".$customer->middle_name;
            $staff = $item->fetchAs('staff')->staff;
            $staffFIO = $staff->surname. " ".$staff->name." ".$staff->middle_name;

            $deathDate = $item->date_death;
            $regDate = $item->date;

            $sheet4->setCellValue('A'.$i, $customerFIO);
            $sheet4->setCellValue('B'.$i, $deathDate);
            $sheet4->setCellValue('C'.$i, $regDate);
            $sheet4->setCellValue('D'.$i, $staffFIO);

            $i++;
        }
    }
    if ($_SESSION['REPORT']['check_is_divorceacts'] == 1)
    {
        $sheet5 = $spreadsheet->createSheet();
        $sheet5->setTitle('Акты о расторжении брака');

        $allCountDivorceacts = R::findAll('divorceacts', ' date >= ? and date <= ?', [$startDate, $finishDate]);

        $i = 2;
        $sheet5->setCellValue('A1', 'ФИО мужа')->getColumnDimension('A')->setAutoSize(true);
        $sheet5->setCellValue('B1', 'ФИО жены')->getColumnDimension('B')->setAutoSize(true);
        $sheet5->setCellValue('C1', 'Дата расторжения брака')->getColumnDimension('C')->setAutoSize(true);
        $sheet5->setCellValue('D1', 'Дата регистрации')->getColumnDimension('D')->setAutoSize(true);
        $sheet5->setCellValue('E1', 'ФИО сотрудника')->getColumnDimension('E')->setAutoSize(true);
        foreach ($allCountDivorceacts as $item)
        {
            $husband = $item->fetchAs('customers')->husband;
            $husbandFIO = $husband->surname." ".$husband->name." ".$husband->middle_name;
            $wife = $item->fetchAs('customers')->wife;
            $wifeFIO = $wife->surname." ".$wife->name." ".$wife->middle_name;
            $staff = $item->fetchAs('staff')->staff;
            $staffFIO = $staff->surname. " ".$staff->name." ".$staff->middle_name;

            $divorceDate = $item->date_divorce;
            $regDate = $item->date;

            $sheet5->setCellValue('A'.$i, $husbandFIO);
            $sheet5->setCellValue('B'.$i, $wifeFIO);
            $sheet5->setCellValue('C'.$i, $divorceDate);
            $sheet5->setCellValue('D'.$i, $regDate);
            $sheet5->setCellValue('E'.$i, $staffFIO);

            $i++;
        }
    }

    $reportName = "Отчет о работе сотрудников; В период с " . $startDate . " по " . $finishDate . ".xlsx";

    $writer = new Xlsx($spreadsheet);
    $writer->save("../export/" . $reportName);
    /* 02 - generate single exel - Close */
}

function get_single_report()
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

    /* 01 - generate single exel - Open */
    $spreadsheet = new Spreadsheet();//создание самого exel файла
    $spreadsheet->removeSheetByIndex(0);//удаляю стандартный лист

    if ($_SESSION['REPORT']['check_is_birthacts'] == 1)//если поставлена галочка
    {
        $sheet1 = $spreadsheet->createSheet();//создание листов
        $sheet1->setTitle('Акты о рождении');

        $singleBirthactsArr = R::findAll('birthacts', ' date >= ? and date <= ? and staff_id = ?', [$startDate, $finishDate, $staffId]);

        $i = 2;
        $sheet1->setCellValue('A1', 'ФИО ребенка')->getColumnDimension('A')->setAutoSize(true);
        $sheet1->setCellValue('B1', 'ФИО мужа')->getColumnDimension('B')->setAutoSize(true);
        $sheet1->setCellValue('C1', 'ФИО жены')->getColumnDimension('C')->setAutoSize(true);
        $sheet1->setCellValue('D1', 'Дата рождения')->getColumnDimension('D')->setAutoSize(true);
        $sheet1->setCellValue('E1', 'Дата регистрации')->getColumnDimension('E')->setAutoSize(true);
        foreach ($singleBirthactsArr as $item)
        {
            $child = $item->fetchAs('customers')->child;
            $childFIO = $child->surname. " ".$child->name." ".$child->middle_name;
            $husband = $item->fetchAs('customers')->husband;
            $husbandFIO = $husband->surname. " ".$husband->name." ".$husband->middle_name;
            $wife = $item->fetchAs('customers')->wife;
            $wifeFIO = $wife->surname. " ".$wife->name." ".$wife->middle_name;

            $birthDate = $item->date_birth;
            $regDate = $item->date;

            $sheet1->setCellValue('A'.$i, $childFIO);
            $sheet1->setCellValue('B'.$i, $husbandFIO);
            $sheet1->setCellValue('C'.$i, $wifeFIO);
            $sheet1->setCellValue('D'.$i, $birthDate);
            $sheet1->setCellValue('E'.$i, $regDate);

            $i++;
        }
    }
    if ($_SESSION['REPORT']['check_is_marriageacts'] == 1)
    {
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Акты о заключении брака');

        $singleCountMarriageactsArr = R::findAll('marriageacts', ' date >= ? and date <= ? and staff_id = ?', [$startDate, $finishDate, $staffId]);

        $i = 2;
        $sheet2->setCellValue('A1', 'ФИО мужа')->getColumnDimension('A')->setAutoSize(true);
        $sheet2->setCellValue('B1', 'ФИО жены')->getColumnDimension('B')->setAutoSize(true);
        $sheet2->setCellValue('C1', 'Дата заключения брака')->getColumnDimension('C')->setAutoSize(true);
        $sheet2->setCellValue('D1', 'Дата регистрации')->getColumnDimension('D')->setAutoSize(true);
        foreach ($singleCountMarriageactsArr as $item)
        {
            $husband = $item->fetchAs('customers')->husband;
            $husbandFIO = $husband->surname. " ".$husband->name." ".$husband->middle_name;
            $wife = $item->fetchAs('customers')->wife;
            $wifeFIO = $wife->surname. " ".$wife->name." ".$wife->middle_name;

            $marriageDate = $item->date_marriage;
            $regDate = $item->date;

            $sheet2->setCellValue('A'.$i, $husbandFIO);
            $sheet2->setCellValue('B'.$i, $wifeFIO);
            $sheet2->setCellValue('C'.$i, $marriageDate);
            $sheet2->setCellValue('D'.$i, $regDate);

            $i++;
        }
    }
    if ($_SESSION['REPORT']['check_is_adoptionacts'] == 1)
    {
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Акты о усыновлении');

        $singleCountAdoptionactsArr = R::findAll('adoptionacts', ' date >= ? and date <= ? and staff_id = ?', [$startDate, $finishDate, $staffId]);

        $i = 2;
        $sheet3->setCellValue('A1', 'ФИО ребенка')->getColumnDimension('A')->setAutoSize(true);
        $sheet3->setCellValue('B1', 'ФИО мужа')->getColumnDimension('B')->setAutoSize(true);
        $sheet3->setCellValue('C1', 'ФИО жены')->getColumnDimension('C')->setAutoSize(true);
        $sheet3->setCellValue('D1', 'Дата усыновления (удочерения)')->getColumnDimension('D')->setAutoSize(true);
        $sheet3->setCellValue('E1', 'Дата регистрации')->getColumnDimension('E')->setAutoSize(true);
        foreach ($singleCountAdoptionactsArr as $item)
        {
            $child = $item->fetchAs('customers')->child;
            $childFIO = $child->surname. " ".$child->name." ".$child->middle_name;
            $husband = $item->fetchAs('customers')->husband;
            $husbandFIO = $husband->surname. " ".$husband->name." ".$husband->middle_name;
            $wife = $item->fetchAs('customers')->wife;
            $wifeFIO = $wife->surname. " ".$wife->name." ".$wife->middle_name;

            $adoptionDate = $item->date_birth;
            $regDate = $item->date;

            $sheet3->setCellValue('A'.$i, $childFIO);
            $sheet3->setCellValue('B'.$i, $husbandFIO);
            $sheet3->setCellValue('C'.$i, $wifeFIO);
            $sheet3->setCellValue('D'.$i, $adoptionDate);
            $sheet3->setCellValue('E'.$i, $regDate);

            $i++;
        }
    }
    if ($_SESSION['REPORT']['check_is_deathacts'] == 1)
    {
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Акты о смерти');

        $singleCountDeathactsArr = R::findAll('deathacts', ' date >= ? and date <= ? and staff_id = ?', [$startDate, $finishDate, $staffId]);

        $i = 2;
        $sheet4->setCellValue('A1', 'ФИО')->getColumnDimension('A')->setAutoSize(true);
        $sheet4->setCellValue('B1', 'Дата наступления смерти')->getColumnDimension('B')->setAutoSize(true);
        $sheet4->setCellValue('C1', 'Дата регистрации')->getColumnDimension('C')->setAutoSize(true);
        foreach ($singleCountDeathactsArr as $item)
        {
            $customer = $item->fetchAs('customers')->customer;
            $customerFIO = $customer->surname. " ".$customer->name." ".$customer->middle_name;

            $deathDate = $item->date_death;
            $regDate = $item->date;

            $sheet4->setCellValue('A'.$i, $customerFIO);
            $sheet4->setCellValue('B'.$i, $deathDate);
            $sheet4->setCellValue('C'.$i, $regDate);

            $i++;
        }
    }
    if ($_SESSION['REPORT']['check_is_divorceacts'] == 1)
    {
        $sheet5 = $spreadsheet->createSheet();
        $sheet5->setTitle('Акты о расторжении брака');

        $singleCountDivorceactsArr = R::findAll('divorceacts', ' date >= ? and date <= ? and staff_id = ?', [$startDate, $finishDate, $staffId]);

        $i = 2;
        $sheet5->setCellValue('A1', 'ФИО мужа')->getColumnDimension('A')->setAutoSize(true);
        $sheet5->setCellValue('B1', 'ФИО жены')->getColumnDimension('B')->setAutoSize(true);
        $sheet5->setCellValue('C1', 'Дата расторжения брака')->getColumnDimension('C')->setAutoSize(true);
        $sheet5->setCellValue('D1', 'Дата регистрации')->getColumnDimension('D')->setAutoSize(true);
        foreach ($singleCountDivorceactsArr as $item)
        {
            $husband = $item->fetchAs('customers')->husband;
            $husbandFIO = $husband->surname." ".$husband->name." ".$husband->middle_name;
            $wife = $item->fetchAs('customers')->wife;
            $wifeFIO = $wife->surname." ".$wife->name." ".$wife->middle_name;

            $divorceDate = $item->date_divorce;
            $regDate = $item->date;

            $sheet5->setCellValue('A'.$i, $husbandFIO);
            $sheet5->setCellValue('B'.$i, $wifeFIO);
            $sheet5->setCellValue('C'.$i, $divorceDate);
            $sheet5->setCellValue('D'.$i, $regDate);

            $i++;
        }
    }

    //где то тут нужно будет вбивать инфу в ячейки листов вооот ,а или внури if

    $staff_fio = $staff->surname . " " . $staff->name . " " . $staff->middle_name;
    $reportName = "Отчет о работе сотрудника; " . $staff_fio . "; В период с " . $startDate . " по " . $finishDate . ".xlsx";
    //myDump($reportName);

    $writer = new Xlsx($spreadsheet);
    $writer->save("../export/" . $reportName);
    /* 02 - generate single exel - Close */
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

    $_SESSION['REPORT']['switch_all_staff'] = $_POST['switch_all_staff'];

    $_SESSION['REPORT']['surname'] = $_POST['surname'];
    $_SESSION['REPORT']['name'] = $_POST['name'];
    $_SESSION['REPORT']['middlename'] = $_POST['middlename'];

    $_SESSION['REPORT']['ERRORS'] = [];
}

function clear_session()
{
    //$_SESSION['REPORT']['ERRORS'] = [];

    $_SESSION['REPORT']['surname'] = "";
    $_SESSION['REPORT']['name'] = "";
    $_SESSION['REPORT']['middlename'] = "";
}