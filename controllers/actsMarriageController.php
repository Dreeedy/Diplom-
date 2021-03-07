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
if ($_POST['post_selector'] === 'post_divorce')
{
    //myDump($_POST);
    marriage_divorce();
    exit;
}

marriage_register();

/* 01 - Create - Open */
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
        //если пользователи найдены, проверка есть ли уже такой брак
        $checkMarriage = check_marriage($_SESSION['MARRIAGE']['HUSBAND']['id'], $_SESSION['MARRIAGE']['WIFE']['id']);

        if ($checkHusband == true && $checkWife == true && $checkMarriage == false)
        {
            //если и муж и жена зареганы, то уже делаем сохранение в базе
            save_marriage($_SESSION['MARRIAGE']['HUSBAND']['id'], $_SESSION['MARRIAGE']['WIFE']['id'], $_SESSION['staff_id']);

            success_marriage();
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

    $_SESSION['MARRIAGE']['date_marriage'] = $post['date_marriage'];//роль клиента

    $_SESSION['MARRIAGE']['reg'] = false;//зареган ли брак

    $_SESSION['MARRIAGE']['SUCCESS'] = [];
    $_SESSION['MARRIAGE']['ERRORS'] = [];

    $_SESSION['MARRIAGE']['visually_hidden'] = false;

    $_SESSION['MARRIAGE']['main_surname'] = $post['radio_main_surname'];
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

function check_marriage($husbandId, $wifeId)
{
    $husband = R::load('customers', $husbandId);
    $husbandMarriageList = $husband->alias('husband')->ownMarriageactsList;

    $wife = R::load('customers', $wifeId);
    $wifeMarriageList = $wife->alias('wife')->ownMarriageactsList;

    if (!empty($husbandMarriageList))
    {
        foreach ($husbandMarriageList as $hm)
        {
            if ($hm->is_active)
            {
                if ($hm->wife_id != $wifeId)
                {
                    //муж состоит в другом браке
                    array_push($_SESSION['MARRIAGE']['HUSBAND']['ERRORS'], 'Муж состоит в другом браке');
                    return  true;
                }elseif ($hm->wife_id == $wifeId)
                {
                    //муж состоит в другом браке
                    array_push($_SESSION['MARRIAGE']['ERRORS'], 'Брак уже зарегистрирован');
                    return true;
                }
            }
        }
    }

    if (!empty($wifeMarriageList))
    {
        foreach ($wifeMarriageList as $wm)
        {
            if ($wm->is_active)
            {
                if ($wm->husband_id != $husbandId)
                {
                    //жена состоит в другом браке
                    array_push($_SESSION['MARRIAGE']['WIFE']['ERRORS'], 'Жена состоит в другом браке');
                    return true;
                }
            }
        }
    }

    return false;
}

function save_marriage($husbandId, $wifeId, $staffId)
{
    //загружаю мужа
    $husband = R::load('customers', $husbandId);

    //меняю фамилию мужу или жене
    if ($_SESSION['MARRIAGE']['main_surname'] == 'wife_surname')
    {
        //если жены, то меняем мужу фамилию на фамилию жены
        $husband->surname = mb_substr($_SESSION['MARRIAGE']['WIFE']['wife_surname'], 0, -1);//отрезаю последнюю букву
    }

    //загружаю жену
    $wife = R::load('customers', $wifeId);

    //меняю фамилию мужу или жене
    if ($_SESSION['MARRIAGE']['main_surname'] == 'husband_surname')
    {
        $wife->surname = $_SESSION['MARRIAGE']['HUSBAND']['husband_surname'];
    }

    //погдружаю работника
    $staff = R::load('staff', $staffId);

    //погдружаю тип акта
    $actType = R::load('actstypes', 1);//свидетельство о браке

    //создаю таблицу браки
    $marriageActs = R::dispense('marriageacts');
    $marriageActs->date_marriage = $_SESSION['MARRIAGE']['date_marriage'];
    //$marriageActs->date_divorce = NULL;
    $marriageActs->is_active = true;

    $marriageActs->staff = $staff;
    $marriageActs->husband = $husband;
    $marriageActs->wife = $wife;

    //создаю таблицу пользотели и книги
    $usersAndBookActs = R::dispense('usersandbookacts');
    $usersAndBookActs->locality = NULL;
    $usersAndBookActs->year = date('Y');//дата внесения в базу?
    $usersAndBookActs->act_types = $actType;

    $usersAndBookActs->divorce_acts = NULL;
    $usersAndBookActs->marriage_acts = $marriageActs;
    $usersAndBookActs->birth_acts = NULL;
    $usersAndBookActs->death_acts = NULL;
    $usersAndBookActs->adoption_acts = NULL;

    //сохраняю marriageacts
    R::store($marriageActs);

    //сохраняю usersandbookacts
    R::store($usersAndBookActs);
}

function success_marriage()
{
    $husband_surname = $_SESSION['MARRIAGE']['HUSBAND']['husband_surname'];
    $husband_name =  $_SESSION['MARRIAGE']['HUSBAND']['husband_name'];
    $husband_middleName = $_SESSION['MARRIAGE']['HUSBAND']['husband_middleName'];

    $wife_surname = $_SESSION['MARRIAGE']['WIFE']['wife_surname'];
    $wife_name = $_SESSION['MARRIAGE']['WIFE']['wife_name'];
    $wife_middleName = $_SESSION['MARRIAGE']['WIFE']['wife_middleName'];

    array_push($_SESSION['MARRIAGE']['SUCCESS'], 'Брак между'.' '.$husband_surname.' '.$husband_name.' '.$husband_middleName.' и '.$wife_surname.' '.$wife_name.' '.$wife_middleName.' '.'успешно зарегистрирован.');

    $_SESSION['MARRIAGE']['visually_hidden'] == true;

    $_SESSION['MARRIAGE']['reg'] = true;

    clear_marriage();
}

function clear_marriage()
{
    $_SESSION['MARRIAGE']['HUSBAND']['id'] = NULL;
    $_SESSION['MARRIAGE']['HUSBAND']['husband_surname'] = NULL;//пол
    $_SESSION['MARRIAGE']['HUSBAND']['husband_name'] = NULL;
    $_SESSION['MARRIAGE']['HUSBAND']['husband_middleName'] = NULL;

    $_SESSION['MARRIAGE']['WIFE']['id'] = 0;
    $_SESSION['MARRIAGE']['WIFE']['wife_surname'] = NULL;
    $_SESSION['MARRIAGE']['WIFE']['wife_name'] = NULL;
    $_SESSION['MARRIAGE']['WIFE']['wife_middleName'] = NULL;

    $_SESSION['MARRIAGE']['date_marriage'] = NULL;
}
/* 02 - Create - Close */

/* 01 - Divorce - Open */
function marriage_divorce()
{
    fill_session_divorce($_POST);
    data_validate_divorce();
    $customer_id = check_customer_divorce();
    $marriage = check_marriage_divorce($customer_id);

    if ($marriage != NULL && $_POST['is_divorce'] == 'is_divorce_true')//если нажал на кнопку разрыва брака
    {
        save_marriage_divorce($marriage);

        session_divorce_clear();
    }

    header('location: ../acts_marriage_divorce.php');
}

function fill_session_divorce($post)
{
    $_SESSION['DIVORCE']['spouse_surname'] = $post['spouse_surname'];
    $_SESSION['DIVORCE']['spouse_name'] = $post['spouse_name'];
    $_SESSION['DIVORCE']['spouse_middleName'] = $post['spouse_middleName'];
    $_SESSION['DIVORCE']['date_divorce'] = $post['date_divorce'];

    $_SESSION['DIVORCE']['ERRORS'] = [];
    $_SESSION['DIVORCE']['SUCCESS'] = [];

    $_SESSION['DIVORCE']['is_divorced'] = false;
}

function data_validate_divorce()
{
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['DIVORCE']['spouse_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['DIVORCE']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['DIVORCE']['spouse_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['DIVORCE']['ERRORS'], "Имя может содержать только кириллицу");
    }

    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['DIVORCE']['spouse_middleName']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['DIVORCE']['ERRORS'], "Отчество может содержать только кириллицу");
    }
}

function check_customer_divorce()
{
    //Поиск нужного пользователя
    $customer_id = R::findOne('customers',
        'surname = ? AND
             name = ? AND
             middle_name = ?', [
            $_SESSION['DIVORCE']['spouse_surname'],
            $_SESSION['DIVORCE']['spouse_name'],
            $_SESSION['DIVORCE']['spouse_middleName'],]);

    if ($customer_id == NUll)
    {
        //array_push($_SESSION['DIVORCE']['ERRORS'], "Клиент не зарегистрирован. Сначала зарегистрируйте его.");
    }
    return $customer_id;
}

function check_marriage_divorce($customer_id)
{
    $customer = R::load('customers', $customer_id);
    $alias = '';
    if ($customer->gender == 'Мужчина')
    {
        $alias = 'husband';
    }
    elseif ($customer->gender == 'Женщина')
    {
        $alias = 'wife';
    }

    $spouse = NULL;
    $marriage = NULL;

    $customerMarriageList = $customer->alias($alias)->ownMarriageactsList;
    if (!empty($customerMarriageList))
    {
        foreach ($customerMarriageList as $cm)
        {
            if ($cm->is_active)
            {
                //вытянуть данные мужа или жены
                if ($customer->gender == 'Мужчина')
                {
                    $spouse = $cm->fetchAs('customers')->wife;//находит жену
                    $marriage = $cm;
                    break;
                }
                elseif($customer->gender == 'Женщина')
                {
                    $spouse = $cm->fetchAs('customers')->husband;//находит мужа
                    $marriage = $cm;
                    break;
                }
                break;
            }
        }
        if ($marriage == NULL)
        {
            array_push($_SESSION['DIVORCE']['ERRORS'], 'Гражданин(ка) не состоит в браке или он не зарегистрирован');
        }
        if ($spouse != NULL)
        {
            array_push($_SESSION['DIVORCE']['SUCCESS'], 'Гражданин(ка) состоит в браке с '.$spouse->surname.' '.$spouse->name.' '.$spouse->middle_name);
            return $marriage;
        }
    }else{
        array_push($_SESSION['DIVORCE']['ERRORS'], 'Гражданин(ка) не состоит в браке или он не зарегистрирован');
    }
    return $marriage;
}

function save_marriage_divorce($marriage)
{
    $marriage->is_active = false;

    $husband = R::load('customers', $marriage->husband_id);
    $husband->surname = $husband->main_surname;

    $wife = R::load('customers', $marriage->wife_id);
    $wife->surname = $wife->main_surname;

    $staff = R::load('staff', $_SESSION['staff_id']);

    $actType = R::load('actstypes', 5);//свидетельство о расторжении брака

    $divorceActs = R::dispense('divorceacts');
    $divorceActs->date_divorce = $_SESSION['DIVORCE']['date_divorce'];

    $divorceActs->staff = $staff;
    $divorceActs->husband = $husband;
    $divorceActs->wife = $wife;

    //создаю таблицу пользотели и книги
    $usersAndBookActs = R::dispense('usersandbookacts');
    $usersAndBookActs->locality = NULL;
    $usersAndBookActs->year = date('Y');//дата внесения в базу?
    $usersAndBookActs->act_types = $actType;

    $usersAndBookActs->divorce_acts = $divorceActs;
    $usersAndBookActs->marriage_acts = NULL;
    $usersAndBookActs->birth_acts = NULL;
    $usersAndBookActs->death_acts = NULL;
    $usersAndBookActs->adoption_acts = NULL;

    R::store($marriage);

    R::store($divorceActs);

    R::store($usersAndBookActs);

    array_push($_SESSION['DIVORCE']['SUCCESS'], 'Брак успешно расторгнут');
}

function session_divorce_clear()
{
    $_SESSION['DIVORCE']['spouse_surname'] = '';
    $_SESSION['DIVORCE']['spouse_name'] = '';
    $_SESSION['DIVORCE']['spouse_middleName'] = '';
    $_SESSION['DIVORCE']['date_divorce'] = '';
}
/* 02 - Divorce - Open */