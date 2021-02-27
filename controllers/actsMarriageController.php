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

//var_dump($_POST);
marriage_register();

/*
 * ищу в базе мужа
 * ищу в базе жену
 * если оба есть
 * то добавляем записи в книгу записей и книгу браков
 * */

function marriage_register()
{
    $point_one = false;
    $point_two = false;

    $checkHusband = false;
    $checkWife = false;

    fill_session($_POST);
    data_validate();

    if (!empty($_SESSION['MARRIAGE']['HUSBAND']['ERRORS']))//если есть ошибки
    {
        $_SESSION['MARRIAGE']['HUSBAND']['visually_hidden'] = true;
        $point_one = true;
    }
    if (!empty($_SESSION['MARRIAGE']['WIFE']['ERRORS']))//если есть ошибки
    {
        $_SESSION['MARRIAGE']['WIFE']['visually_hidden'] = true;
        $point_two = true;
    }

    if ($point_one == false && $point_two == false)//если ошибок нет
    {
        //ищем пользователей
        $checkHusband = check_customer($_SESSION['MARRIAGE']['HUSBAND']['husband_surname'], $_SESSION['MARRIAGE']['HUSBAND']['husband_name'], $_SESSION['MARRIAGE']['HUSBAND']['husband_middleName'], 0);
        $checkWife = check_customer($_SESSION['MARRIAGE']['WIFE']['wife_surname'], $_SESSION['MARRIAGE']['WIFE']['wife_name'], $_SESSION['MARRIAGE']['WIFE']['wife_middleName'], 1);

        if ($checkHusband == true && $checkWife == true)
        {
            //если и муж и жена зареганы, то уже делаем сохранение в базе
            save($_SESSION['MARRIAGE']['HUSBAND']['id'], $_SESSION['MARRIAGE']['WIFE']['id'], $_SESSION['staff_id']);
            header('location: ../acts_marriage_create.php');
        } else//если кого то из пользователй не нашли
        {
            if (!empty($_SESSION['MARRIAGE']['HUSBAND']['ERRORS']))//если есть ошибки
            {
                $_SESSION['MARRIAGE']['HUSBAND']['visually_hidden'] = true;
            }
            if (!empty($_SESSION['MARRIAGE']['WIFE']['ERRORS']))//если есть ошибки
            {
                $_SESSION['MARRIAGE']['WIFE']['visually_hidden'] = true;
            }
            header('location: ../acts_marriage_create.php');
        }
    } else//если ошибки есть при валидации
    {
        header('location: ../acts_marriage_create.php');
    }
}

function fill_session($post)
{
    $_SESSION['MARRIAGE']['HUSBAND']['id'] = 0;
    $_SESSION['MARRIAGE']['HUSBAND']['husband_surname'] = $post['husband_surname'];//пол
    $_SESSION['MARRIAGE']['HUSBAND']['husband_name'] = $post['husband_name'];
    $_SESSION['MARRIAGE']['HUSBAND']['husband_middleName'] = $post['husband_middleName'];
    $_SESSION['MARRIAGE']['HUSBAND']['ERRORS'] = [];
    $_SESSION['MARRIAGE']['HUSBAND']['SUCCESS'] = [];
    $_SESSION['MARRIAGE']['HUSBAND']['visually_hidden'] = false;

    $_SESSION['MARRIAGE']['WIFE']['id'] = 0;
    $_SESSION['MARRIAGE']['WIFE']['wife_surname'] = $post['wife_surname'];
    $_SESSION['MARRIAGE']['WIFE']['wife_name'] = $post['wife_name'];
    $_SESSION['MARRIAGE']['WIFE']['wife_middleName'] = $post['wife_middleName'];
    $_SESSION['MARRIAGE']['WIFE']['ERRORS'] = [];
    $_SESSION['MARRIAGE']['WIFE']['SUCCESS'] = [];
    $_SESSION['MARRIAGE']['WIFE']['visually_hidden'] = false;

    $_SESSION['MARRIAGE']['marriage_date'] = $post['marriage_date'];//роль клиента

    $_SESSION['MARRIAGE']['reg'] = false;//зареган ли брак
}

function data_validate()
{
    /* 01 - Муж - Open */
    //husband_surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['MARRIAGE']['HUSBAND']['husband_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['MARRIAGE']['HUSBAND']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //husband_name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['MARRIAGE']['HUSBAND']['husband_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['MARRIAGE']['HUSBAND']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //husband_middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['MARRIAGE']['HUSBAND']['husband_middleName']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['MARRIAGE']['HUSBAND']['ERRORS'], "Отчество может содержать только кириллицу");
    }
    /* 02 - Муж - Close */

    /* 01 - Жена - Open */
    //wife_surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['MARRIAGE']['WIFE']['wife_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['MARRIAGE']['WIFE']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //wife_name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['MARRIAGE']['WIFE']['wife_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['MARRIAGE']['WIFE']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //wife_middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['MARRIAGE']['WIFE']['wife_middleName']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['MARRIAGE']['WIFE']['ERRORS'], "Отчество может содержать только кириллицу");
    }
    /* 02 - Жена - Close */

    /* ДОПУСТИМ ТУТ БУДЕТ ВАЛИДАЦИЯ ДАТЫ  */
}

/*
 * Ищет в бд такого человека. return True если есть
 * */
function check_customer($surname, $name, $middleName, $type)
{
    //$type это муж или жена, чтобы правильно ошибки распределить 0 - муж 1 - жена

    //Поиск нужного пользователя
    $customer_id = R::findOne('customers',
        'surname = ? AND
             name = ? AND
             middle_name = ?', [
            $surname,
            $name,
            $middleName,]);


    if ($type == 0)
    {
        if ($customer_id != NULL)
        {
            $_SESSION['MARRIAGE']['HUSBAND']['id'] = $customer_id->id;
            return true;
        } else
        {
            //если есть такой клиент, говорим что такой уже есть
            array_push($_SESSION['MARRIAGE']['HUSBAND']['ERRORS'], "Клиент не зарегистрирован. Сначала зарегистрируйте его.");
            return false;
        }
    }
    if ($type == 1)
    {
        if ($customer_id != NULL)
        {
            $_SESSION['MARRIAGE']['WIFE']['id'] = $customer_id->id;
            return true;
        } else
        {
            //если есть такой клиент, говорим что такой уже есть
            array_push($_SESSION['MARRIAGE']['WIFE']['ERRORS'], "Клиент не зарегистрирован. Сначала зарегистрируйте его.");
            return false;
        }
    }
}

function save($husbandId, $wifeId, $staffId)
{
    //создаю таблицу браки
    $marriageActs = R::dispense('marriageacts');
    $marriageActs->date_issue = $_SESSION['MARRIAGE']['marriage_date'];
    //R::store($marriage_acts);

    //подгружаю мужа
    $husband = R::load('customers', $husbandId);

    //подгружаю жену
    $wife = R::load('customers', $wifeId);

    //погдружаю работника
    $staff = R::load('staff', $staffId);

    //погдружаю тип акта
    $actType = R::load('actstypes', 1);//свидетельство о браке

    //создаю таблицу пользотели и книги
    $usersAndBookActs = R::dispense('usersandbookacts');
    $usersAndBookActs->locality = 'адрес';
    $usersAndBookActs->year = date('Y');

    //пытаюсь сохранить все это счатье
    $marriageActs->ownUsersAndBookActsList[] = $usersAndBookActs;
    $husband->ownUsersAndBookActsList[] = $usersAndBookActs;
    $wife->ownUsersAndBookActsList[] = $usersAndBookActs;
    $staff->ownUsersAndBookActsList[] = $usersAndBookActs;
    $actType->ownUsersAndBookActsList[] = $usersAndBookActs;

    R::storeAll([$marriageActs, $husband, $wife, $staff, $actType]);

    //сообщение о успешной регистрации Клиента
//    array_push($_SESSION['REGISTER']['CUSTOMER']['SUCCESS'],
//        $_SESSION['REGISTER']['CUSTOMER']['surname'] . ' ' .
//        $_SESSION['REGISTER']['CUSTOMER']['name'] . ' ' .
//        $_SESSION['REGISTER']['CUSTOMER']['middleName'] . ' ' .
//        "успешно зарегистрирован как" . ' ' .
//        $_SESSION['REGISTER']['CUSTOMER']['role_name']);
//
//    $_SESSION['REGISTER']['CUSTOMER']['reg'] = true;
//
//    clear_marriage();//чтобы поля в регистрации были чистыми
}

function clear_marriage()
{

}





