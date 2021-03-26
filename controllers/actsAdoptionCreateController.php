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

    if ( empty($_SESSION['ADOPTION']['HUSBAND']['ERRORS'])
        && empty($_SESSION['ADOPTION']['WIFE']['ERRORS'])
        && empty($_SESSION['ADOPTION']['CHILD']['ERRORS'])
        && empty($_SESSION['ADOPTION']['ERRORS']) )
    {
        //если нет ошибок
        $haveValidateError = false;
    }else
    {
        $_SESSION['ADOPTION']['HUSBAND']['visually_hidden'] = true;
        $_SESSION['ADOPTION']['WIFE']['visually_hidden'] = true;
        $_SESSION['ADOPTION']['CHILD']['visually_hidden'] = true;
    }

    $checkHusbandAndWife = false;

    if ($haveValidateError == false)
    {
        $checkHusband = false;
        $checkWife = false;
        $checkChild = false;

        $checkHusband = check_customer($_SESSION['ADOPTION']['HUSBAND']['husband_surname'], $_SESSION['ADOPTION']['HUSBAND']['husband_name'], $_SESSION['ADOPTION']['HUSBAND']['husband_middle_name'], 0);
        $checkWife = check_customer($_SESSION['ADOPTION']['WIFE']['wife_surname'], $_SESSION['ADOPTION']['WIFE']['wife_name'], $_SESSION['ADOPTION']['WIFE']['wife_middle_name'], 1);
        $checkChild = check_customer($_SESSION['ADOPTION']['CHILD']['child_surname'], $_SESSION['ADOPTION']['CHILD']['child_name'], $_SESSION['ADOPTION']['CHILD']['child_middle_name'], 2);

        if ($checkHusband && $checkWife && $checkChild == true)
        {
            $checkHusbandAndWife = true;
        }else
        {
            $_SESSION['ADOPTION']['HUSBAND']['visually_hidden'] = true;
            $_SESSION['ADOPTION']['WIFE']['visually_hidden'] = true;
            $_SESSION['ADOPTION']['CHILD']['visually_hidden'] = true;
        }
    }

    if ($checkHusbandAndWife == true)
    {
        adoption_save($_SESSION['ADOPTION']['HUSBAND']['husband_id'], $_SESSION['ADOPTION']['WIFE']['wife_id'], $_SESSION['staff_id']);
    }

    header('location: ../acts_adoption_create.php');
}

function fill_session($post)
{
    $_SESSION['ADOPTION']['HUSBAND']['husband_id'] = NULL;
    $_SESSION['ADOPTION']['HUSBAND']['husband_surname'] = $post['husband_surname'];
    $_SESSION['ADOPTION']['HUSBAND']['husband_name'] = $post['husband_name'];
    $_SESSION['ADOPTION']['HUSBAND']['husband_middle_name'] = $post['husband_middle_name'];
    $_SESSION['ADOPTION']['HUSBAND']['ERRORS'] = [];
    $_SESSION['ADOPTION']['HUSBAND']['visually_hidden'] = false;//false

    $_SESSION['ADOPTION']['WIFE']['wife_id'] = NULL;
    $_SESSION['ADOPTION']['WIFE']['wife_surname'] = $post['wife_surname'];
    $_SESSION['ADOPTION']['WIFE']['wife_name'] = $post['wife_name'];
    $_SESSION['ADOPTION']['WIFE']['wife_middle_name'] = $post['wife_middle_name'];
    $_SESSION['ADOPTION']['WIFE']['ERRORS'] = [];
    $_SESSION['ADOPTION']['WIFE']['visually_hidden'] = false;//false

    $_SESSION['ADOPTION']['CHILD']['child_surname'] = $post['child_surname'];
    $_SESSION['ADOPTION']['CHILD']['child_name'] = $post['child_name'];
    $_SESSION['ADOPTION']['CHILD']['child_middle_name'] = $post['child_middle_name'];
    $_SESSION['ADOPTION']['CHILD']['gender'] = $post['radio_gender'];
    $_SESSION['ADOPTION']['CHILD']['ERRORS'] = [];
    $_SESSION['ADOPTION']['CHILD']['visually_hidden'] = false;//false

    $_SESSION['ADOPTION']['date_birth'] = $post['date_birth'];
    $_SESSION['ADOPTION']['date_adoption'] = $post['date_adoption'];

    $_SESSION['ADOPTION']['SUCCESS'] = [];
    $_SESSION['ADOPTION']['ERRORS'] = [];
}

function data_validate()
{
    /* 01 - Муж - Open */
    //surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['ADOPTION']['HUSBAND']['husband_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['ADOPTION']['HUSBAND']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['ADOPTION']['HUSBAND']['husband_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['ADOPTION']['HUSBAND']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['ADOPTION']['HUSBAND']['husband_middle_name']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['ADOPTION']['HUSBAND']['ERRORS'], "Отчество может содержать только кириллицу");
    }
    /* 02 - Муж - Close */

    /* 01 - Жена - Open */
    //surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['ADOPTION']['WIFE']['wife_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['ADOPTION']['WIFE']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['ADOPTION']['WIFE']['wife_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['ADOPTION']['WIFE']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['ADOPTION']['WIFE']['wife_middle_name']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['ADOPTION']['WIFE']['ERRORS'], "Отчество может содержать только кириллицу");
    }
    /* 02 - Жена - Close */

    /* 01 - Ребенок - Open */
    //surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['ADOPTION']['CHILD']['child_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['ADOPTION']['CHILD']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['ADOPTION']['CHILD']['child_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['ADOPTION']['CHILD']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['ADOPTION']['CHILD']['child_middle_name']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['ADOPTION']['CHILD']['ERRORS'], "Отчество может содержать только кириллицу");
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
            $_SESSION['ADOPTION']['HUSBAND']['husband_id'] = $customer_id->id;
            return true;
        } else
        {
            //если есть такой клиент, говорим что такой уже есть
            array_push($_SESSION['ADOPTION']['HUSBAND']['ERRORS'], "Клиент не зарегистрирован. Сначала зарегистрируйте его.");
            return false;
        }
    }
    if ($type == 1)
    {
        if ($customer_id != NULL)
        {
            $_SESSION['ADOPTION']['WIFE']['wife_id'] = $customer_id->id;
            return true;
        } else
        {
            //если есть такой клиент, говорим что такой уже есть
            array_push($_SESSION['ADOPTION']['WIFE']['ERRORS'], "Клиент не зарегистрирован. Сначала зарегистрируйте его.");
            return false;
        }
    }
    if ($type == 2)//такого пользователя не должно найти
    {
        if ($customer_id != NULL)
        {
            array_push($_SESSION['ADOPTION']['CHILD']['ERRORS'], "Клиент уже зарегистрирован");
            return false;
        } else
        {
            return true;
        }
    }
}

function adoption_save($husbandId, $wifeId, $staffId)
{
    $husband = R::load('customers', $husbandId);

    $wife = R::load('customers', $wifeId);

    $staff = R::load('staff', $staffId);

    $role = R::load('roles', 1);//1 - роль сотрудник

    $actType = R::load('actstypes', 3);//Свидетельство о усыновлении

    $child = R::dispense('customers');
    $child->gender = $_SESSION['ADOPTION']['CHILD']['gender'];
    $child->surname = $_SESSION['ADOPTION']['CHILD']['child_surname'];
    $child->name = $_SESSION['ADOPTION']['CHILD']['child_name'];
    $child->middle_name= $_SESSION['ADOPTION']['CHILD']['child_middle_name'];
    $child->date_birth= $_SESSION['ADOPTION']['date_birth'];
    $child->address = NULL;
    $child->phone_number = NULL;
    $child->main_surname = $_SESSION['ADOPTION']['CHILD']['child_surname'];

    $role->ownCustomersList[] = $child;
    R::store($role);

    $adoptionacts = R::dispense('adoptionacts');
    $adoptionacts->date_birth = $_SESSION['ADOPTION']['date_birth'];
    $adoptionacts->date_adoption = $_SESSION['ADOPTION']['date_adoption'];
    $adoptionacts->husband = $husband;
    $adoptionacts->wife = $wife;
    $adoptionacts->child = $child;
    $adoptionacts->staff = $staff;

    R::store($adoptionacts);

    //создаю таблицу пользотели и книги
    $usersAndBookActs = R::dispense('usersandbookacts');
    $usersAndBookActs->locality = NULL;
    $usersAndBookActs->year = date('Y');//дата внесения в базу?
    $usersAndBookActs->act_types = $actType;

    //$usersAndBookActs->divorce_acts = NULL;
    //$usersAndBookActs->marriage_acts = NULL;
    //$usersAndBookActs->birth_acts = NULL;
    //$usersAndBookActs->death_acts = NULL;
    $usersAndBookActs->adoptionacts = $adoptionacts;

    R::store($usersAndBookActs);

    array_push($_SESSION['ADOPTION']['SUCCESS'], "Акт о усыновлении (удочерении) ребенка успешно зарегистрирован");

    clear_session();
}

function clear_session()
{
    $_SESSION['ADOPTION']['HUSBAND']['husband_id'] = NULL;
    $_SESSION['ADOPTION']['HUSBAND']['husband_surname'] = NULL;
    $_SESSION['ADOPTION']['HUSBAND']['husband_name'] = NULL;
    $_SESSION['ADOPTION']['HUSBAND']['husband_middle_name'] = NULL;
    //$_SESSION['ADOPTION']['HUSBAND']['ERRORS'] = [];
    //$_SESSION['ADOPTION']['HUSBAND']['visually_hidden'] = false;//false

    $_SESSION['ADOPTION']['WIFE']['wife_id'] = NULL;
    $_SESSION['ADOPTION']['WIFE']['wife_surname'] = NULL;
    $_SESSION['ADOPTION']['WIFE']['wife_name'] = NULL;
    $_SESSION['ADOPTION']['WIFE']['wife_middle_name'] = NULL;
    //$_SESSION['ADOPTION']['WIFE']['ERRORS'] = [];
    //$_SESSION['ADOPTION']['WIFE']['visually_hidden'] = false;//false

    $_SESSION['ADOPTION']['CHILD']['child_surname'] = NULL;
    $_SESSION['ADOPTION']['CHILD']['child_name'] = NULL;
    $_SESSION['ADOPTION']['CHILD']['child_middle_name'] = NULL;
    $_SESSION['ADOPTION']['CHILD']['gender'] = NULL;
    //$_SESSION['ADOPTION']['CHILD']['ERRORS'] = [];
    //$_SESSION['ADOPTION']['CHILD']['visually_hidden'] = false;//false

    $_SESSION['ADOPTION']['date_birth'] = NULL;
    $_SESSION['ADOPTION']['date_adoption'] = NULL;

    //$_SESSION['ADOPTION']['SUCCESS'] = [];
    //$_SESSION['ADOPTION']['ERRORS'] = [];
}