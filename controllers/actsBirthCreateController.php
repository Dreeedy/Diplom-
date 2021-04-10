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

//myDump($_POST);

birth_act_register();

function birth_act_register()
{
    fill_session($_POST);
    data_validate();

    $haveValidateError = true;

    if ( empty($_SESSION['BIRTH']['HUSBAND']['ERRORS'])
        && empty($_SESSION['BIRTH']['WIFE']['ERRORS'])
        && empty($_SESSION['BIRTH']['CHILD']['ERRORS'])
        && empty($_SESSION['BIRTH']['ERRORS']) )
    {
        //если нет ошибок
        $haveValidateError = false;
    }else
    {
        $_SESSION['BIRTH']['HUSBAND']['visually_hidden'] = true;
        $_SESSION['BIRTH']['WIFE']['visually_hidden'] = true;
        $_SESSION['BIRTH']['CHILD']['visually_hidden'] = true;
    }

    $checkHusbandAndWife = false;

    if ($haveValidateError == false)
    {
        $checkHusband = check_customer($_SESSION['BIRTH']['HUSBAND']['husband_surname'], $_SESSION['BIRTH']['HUSBAND']['husband_name'], $_SESSION['BIRTH']['HUSBAND']['husband_middle_name'], 0);
        $checkWife = check_customer($_SESSION['BIRTH']['WIFE']['wife_surname'], $_SESSION['BIRTH']['WIFE']['wife_name'], $_SESSION['BIRTH']['WIFE']['wife_middle_name'], 1);
        $checkChild = check_customer($_SESSION['BIRTH']['CHILD']['child_surname'], $_SESSION['BIRTH']['CHILD']['child_name'], $_SESSION['BIRTH']['CHILD']['child_middle_name'], 2);

        if ($checkHusband && $checkWife && $checkChild == true)
        {
            $checkHusbandAndWife = true;
        }else
        {
            $_SESSION['BIRTH']['HUSBAND']['visually_hidden'] = true;
            $_SESSION['BIRTH']['WIFE']['visually_hidden'] = true;
            $_SESSION['BIRTH']['CHILD']['visually_hidden'] = true;
        }
    }

    if ($checkHusbandAndWife == true)
    {
        birth_save($_SESSION['BIRTH']['HUSBAND']['husband_id'], $_SESSION['BIRTH']['WIFE']['wife_id'], $_SESSION['staff_id']);
    }

    header('location: ../acts_birth_create.php');
}

function fill_session($post)
{
    $_SESSION['BIRTH']['HUSBAND']['husband_id'] = NULL;
    $_SESSION['BIRTH']['HUSBAND']['husband_surname'] = $post['husband_surname'];
    $_SESSION['BIRTH']['HUSBAND']['husband_name'] = $post['husband_name'];
    $_SESSION['BIRTH']['HUSBAND']['husband_middle_name'] = $post['husband_middle_name'];
    $_SESSION['BIRTH']['HUSBAND']['ERRORS'] = [];
    $_SESSION['BIRTH']['HUSBAND']['visually_hidden'] = false;//false

    $_SESSION['BIRTH']['WIFE']['wife_id'] = NULL;
    $_SESSION['BIRTH']['WIFE']['wife_surname'] = $post['wife_surname'];
    $_SESSION['BIRTH']['WIFE']['wife_name'] = $post['wife_name'];
    $_SESSION['BIRTH']['WIFE']['wife_middle_name'] = $post['wife_middle_name'];
    $_SESSION['BIRTH']['WIFE']['ERRORS'] = [];
    $_SESSION['BIRTH']['WIFE']['visually_hidden'] = false;//false

    $_SESSION['BIRTH']['CHILD']['child_surname'] = $post['child_surname'];
    $_SESSION['BIRTH']['CHILD']['child_name'] = $post['child_name'];
    $_SESSION['BIRTH']['CHILD']['child_middle_name'] = $post['child_middle_name'];
    $_SESSION['BIRTH']['CHILD']['gender'] = $post['radio_gender'];
    $_SESSION['BIRTH']['CHILD']['ERRORS'] = [];
    $_SESSION['BIRTH']['CHILD']['visually_hidden'] = false;//false

    $_SESSION['BIRTH']['date_birth'] = $post['date_birth'];

    $_SESSION['BIRTH']['SUCCESS'] = [];
    $_SESSION['BIRTH']['ERRORS'] = [];
}

function data_validate()
{
    /* 01 - Муж - Open */
    //surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['BIRTH']['HUSBAND']['husband_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['BIRTH']['HUSBAND']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['BIRTH']['HUSBAND']['husband_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['BIRTH']['HUSBAND']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['BIRTH']['HUSBAND']['husband_middle_name']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['BIRTH']['HUSBAND']['ERRORS'], "Отчество может содержать только кириллицу");
    }
    /* 02 - Муж - Close */

    /* 01 - Жена - Open */
    //surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['BIRTH']['WIFE']['wife_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['BIRTH']['WIFE']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['BIRTH']['WIFE']['wife_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['BIRTH']['WIFE']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['BIRTH']['WIFE']['wife_middle_name']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['BIRTH']['WIFE']['ERRORS'], "Отчество может содержать только кириллицу");
    }
    /* 02 - Жена - Close */

    /* 01 - Ребенок - Open */
    //surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['BIRTH']['CHILD']['child_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['BIRTH']['CHILD']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['BIRTH']['CHILD']['child_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['BIRTH']['CHILD']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['BIRTH']['CHILD']['child_middle_name']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['BIRTH']['CHILD']['ERRORS'], "Отчество может содержать только кириллицу");
    }
    /* 02 - Ребенок - Close */

    /* ДОПУСТИМ ТУТ БУДЕТ ВАЛИДАЦИЯ ДАТЫ  */
}

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
            $_SESSION['BIRTH']['HUSBAND']['husband_id'] = $customer_id->id;
            return true;
        } else
        {
            //если есть такой клиент, говорим что такой уже есть
            array_push($_SESSION['BIRTH']['HUSBAND']['ERRORS'], "Клиент не зарегистрирован. Сначала зарегистрируйте его.");
            return false;
        }
    }
    if ($type == 1)
    {
        if ($customer_id != NULL)
        {
            $_SESSION['BIRTH']['WIFE']['wife_id'] = $customer_id->id;
            return true;
        } else
        {
            //если есть такой клиент, говорим что такой уже есть
            array_push($_SESSION['BIRTH']['WIFE']['ERRORS'], "Клиент не зарегистрирован. Сначала зарегистрируйте его.");
            return false;
        }
    }
    if ($type == 2)//такого пользователя не должно найти
    {
        if ($customer_id != NULL)
        {
            array_push($_SESSION['BIRTH']['CHILD']['ERRORS'], "Клиент уже зарегистрирован");
            return false;
        } else
        {
            return true;
        }
    }
}

function birth_save($husbandId, $wifeId, $staffId)
{
    $husband = R::load('customers', $husbandId);

    $wife = R::load('customers', $wifeId);

    $staff = R::load('staff', $staffId);

    $role = R::load('roles', 1);//1 - роль сотрудник

    $actType = R::load('actstypes', 2);//свидетельство о рождении

    $child = R::dispense('customers');
    $child->gender = $_SESSION['BIRTH']['CHILD']['gender'];
    $child->surname = $_SESSION['BIRTH']['CHILD']['child_surname'];
    $child->name = $_SESSION['BIRTH']['CHILD']['child_name'];
    $child->middle_name= $_SESSION['BIRTH']['CHILD']['child_middle_name'];
    $child->date_birth= $_SESSION['BIRTH']['date_birth'];
    $child->address = NULL;
    $child->phone_number = NULL;
    $child->main_surname = $_SESSION['BIRTH']['CHILD']['child_surname'];

    $role->ownCustomersList[] = $child;
    R::store($role);

    $birthacts = R::dispense('birthacts');
    $birthacts->date_birth = $_SESSION['BIRTH']['date_birth'];
    $birthacts->husband = $husband;
    $birthacts->wife = $wife;
    $birthacts->child = $child;
    $birthacts->staff = $staff;
    $birthacts->date = date("Y-m-d");

    R::store($birthacts);

    //создаю таблицу пользотели и книги
    $usersAndBookActs = R::dispense('usersandbookacts');
    $usersAndBookActs->locality = NULL;
    $usersAndBookActs->year = date('Y');//дата внесения в базу?
    $usersAndBookActs->date = date("Y-m-d");//дата внесения в базу?
    $usersAndBookActs->act_types = $actType;

    //$usersAndBookActs->divorce_acts = NULL;
    //$usersAndBookActs->marriage_acts = NULL;
    $usersAndBookActs->birthacts = $birthacts;
    //$usersAndBookActs->death_acts = NULL;
    //$usersAndBookActs->adoption_acts = NULL;

    R::store($usersAndBookActs);

    array_push($_SESSION['BIRTH']['SUCCESS'], "Акт о рождении ребенка успешно зарегистрирован");

    clear_session();
}

function clear_session()
{
    $_SESSION['BIRTH']['HUSBAND']['husband_id'] = NULL;
    $_SESSION['BIRTH']['HUSBAND']['husband_surname'] = NULL;
    $_SESSION['BIRTH']['HUSBAND']['husband_name'] = NULL;
    $_SESSION['BIRTH']['HUSBAND']['husband_middle_name'] = NULL;
    //$_SESSION['BIRTH']['HUSBAND']['ERRORS'] = [];
    //$_SESSION['BIRTH']['HUSBAND']['visually_hidden'] = false;//false

    $_SESSION['BIRTH']['WIFE']['wife_id'] = NULL;
    $_SESSION['BIRTH']['WIFE']['wife_surname'] = NULL;
    $_SESSION['BIRTH']['WIFE']['wife_name'] = NULL;
    $_SESSION['BIRTH']['WIFE']['wife_middle_name'] = NULL;
    //$_SESSION['BIRTH']['WIFE']['ERRORS'] = [];
    //$_SESSION['BIRTH']['WIFE']['visually_hidden'] = false;//false

    $_SESSION['BIRTH']['CHILD']['child_surname'] = NULL;
    $_SESSION['BIRTH']['CHILD']['child_name'] = NULL;
    $_SESSION['BIRTH']['CHILD']['child_middle_name'] = NULL;
    $_SESSION['BIRTH']['CHILD']['gender'] = NULL;
    //$_SESSION['BIRTH']['CHILD']['ERRORS'] = [];
    //$_SESSION['BIRTH']['CHILD']['visually_hidden'] = false;//false

    $_SESSION['BIRTH']['date_birth'] = NULL;

    //$_SESSION['BIRTH']['SUCCESS'] = [];
    //$_SESSION['BIRTH']['ERRORS'] = [];
}
