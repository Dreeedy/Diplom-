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

death_act_register();

function death_act_register()
{
    fill_session($_POST);
    data_validate();

    $thereIsDeathAct = true;

    $customer_id = check_customer();
    if ($customer_id != NULL)
    {
        $thereIsDeathAct = check_death_act($customer_id);
    }

    if ($thereIsDeathAct == false)
    {
        save_death_act($customer_id, $_SESSION['staff_id']);
    }

    clear_session();

    header('location: ../acts_death_create.php');
}

function fill_session($post)
{
    $_SESSION['DEATHH']['customer_surname'] = $post['customer_surname'];
    $_SESSION['DEATHH']['customer_name'] = $post['customer_name'];
    $_SESSION['DEATHH']['customer_middle_name'] = $post['customer_middle_name'];
    $_SESSION['DEATHH']['date_death'] = $post['date_death'];

    $_SESSION['DEATHH']['SUCCESS'] = [];
    $_SESSION['DEATHH']['ERRORS'] = [];
}

function data_validate()
{
    //surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['DEATHH']['customer_surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['DEATHH']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['DEATHH']['customer_name']))
    {
        //если не проходит проверку
        array_push($_SESSION['DEATHH']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['DEATHH']['customer_middle_name']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['DEATHH']['ERRORS'], "Отчество может содержать только кириллицу");
    }

    /* ДОПУСТИМ ТУТ БУДЕТ ВАЛИДАЦИЯ ДАТЫ  */
}

function check_customer()
{
    //Поиск нужного пользователя
    $customer_id = R::findOne('customers',
        'surname = ? AND
             name = ? AND
             middle_name = ?', [
            $_SESSION['DEATHH']['customer_surname'],
            $_SESSION['DEATHH']['customer_name'],
            $_SESSION['DEATHH']['customer_middle_name']]);

    if ($customer_id != NULL)
    {
        //если есть такой клиент, говорим что такой уже есть
        return $customer_id;

    } else
    {
        array_push($_SESSION['DEATHH']['ERRORS'], "Клиент не зарегистрирован. Сначала зарегистрируйте его");
        return NULL;
    }
}

function check_death_act($customer_id)
{
    $customer = R::load('customers', $customer_id);
    $customerDeathActs = $customer->alias('customer')->ownDeathactsList;
    if (!empty($customerDeathActs))
    {
        array_push($_SESSION['DEATHH']['ERRORS'], "У данного гражданина уже зарегистрировано свидетельство о смерти");
        return true;
    } else
    {
        return false;
    }
}

function save_death_act($customer_id, $staff_id)
{
    $customer = R::load('customers', $customer_id);

    $staff = R::load('staff', $staff_id);

    $actType = R::load('actstypes', 4);//свидетельство о смерти

    $deathacts = R::dispense('deathacts');
    $deathacts->date_death = $_SESSION['DEATHH']['date_death'];
    $deathacts->customer = $customer;
    $deathacts->date = date("Y-m-d");

    $deathacts->staff = $staff;

    //создаю таблицу пользотели и книги
    $usersAndBookActs = R::dispense('usersandbookacts');
    $usersAndBookActs->locality = NULL;
    $usersAndBookActs->year = date('Y');//дата внесения в базу?
    $usersAndBookActs->date = date("Y-m-d");//дата внесения в базу?
    $usersAndBookActs->act_types = $actType;

    //$usersAndBookActs->divorce_acts = NULL;
    //$usersAndBookActs->marriage_acts = NULL;
    //$usersAndBookActs->birth_acts = NULL;
    $usersAndBookActs->deathacts = $deathacts;
    //$usersAndBookActs->adoption_acts = NULL;

    //сохраняю marriageacts
    R::store($deathacts);

    //сохраняю usersandbookacts
    R::store($usersAndBookActs);

    array_push($_SESSION['DEATHH']['SUCCESS'], "Свидетельство о смерти успешно зарегистрировано");
}

function clear_session()
{
    $_SESSION['DEATHH']['customer_surname'] = '';
    $_SESSION['DEATHH']['customer_name'] = '';
    $_SESSION['DEATHH']['customer_middle_name'] = '';
    $_SESSION['DEATHH']['date_death'] = NULL;
}

