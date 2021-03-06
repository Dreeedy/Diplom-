<?php
session_start();

/*01-Подключение к базе данных*/
require_once "rb/rb-mysql.php";
require_once "dbConnection.php";

R::setup(get_db_dns(), get_db_username(), get_db_password());

if (!R::testConnection())
{
    exit('Нет подключения к базе данных');
}
/*02-Подключение к базе данных*/

login_or_register();

function login_or_register()
{
    fill_session($_POST);//поместили данные в сесиию. дальше работа с ней
    data_validate();//валидация данных. дальше проверка на наличие ошибок в сесии
    if (empty($_SESSION['REGISTER']['CUSTOMER']['ERRORS']))
    {
        //если ошибок нет. Ищем в базе
        find_user();

        if (empty($_SESSION['REGISTER']['CUSTOMER']['ERRORS']))
        {
            //если пользователь не найден
            register_customer();
            header('location: customers_register.php');
        }else
        {
            //если такой пользователь найден
            header('location: customers_register.php');
        }
    } else
    {
        //если ошибки есть. Редирект назад и выдаю ошибки там
        header('location: customers_register.php');
    }
}

function fill_session($post)
{
    $_SESSION['REGISTER']['CUSTOMER']['gender'] = $post['gender'];//пол
    $_SESSION['REGISTER']['CUSTOMER']['surname'] = $post['surname'];
    $_SESSION['REGISTER']['CUSTOMER']['name'] = $post['name'];
    $_SESSION['REGISTER']['CUSTOMER']['middleName'] = $post['middleName'];
    $_SESSION['REGISTER']['CUSTOMER']['dateBirth'] = $post['dateBirth'];
    $_SESSION['REGISTER']['CUSTOMER']['address'] = $post['address'];
    $_SESSION['REGISTER']['CUSTOMER']['phoneNumber'] = $post['phoneNumber'];
    $_SESSION['REGISTER']['CUSTOMER']['role_id'] = '1';//роль клиента
    $_SESSION['REGISTER']['CUSTOMER']['role_name'] = 'Клиент';
    $_SESSION['REGISTER']['CUSTOMER']['ERRORS'] = [];
    $_SESSION['REGISTER']['CUSTOMER']['SUCCESS'] = [];
    $_SESSION['REGISTER']['CUSTOMER']['reg'] = false;
}

function data_validate()
{
    //gender
    if ($_SESSION['REGISTER']['CUSTOMER']['gender'] == "select_gender") {
        array_push($_SESSION['REGISTER']['CUSTOMER']['ERRORS'], "Необходимо указать пол клиента");
    }

    //surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['REGISTER']['CUSTOMER']['surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['REGISTER']['CUSTOMER']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['REGISTER']['CUSTOMER']['name']))
    {
        //если не проходит проверку
        array_push($_SESSION['REGISTER']['CUSTOMER']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['REGISTER']['CUSTOMER']['middleName']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['REGISTER']['CUSTOMER']['ERRORS'], "Отчество может содержать только кириллицу");
    }

    //phoneNumber
    if (preg_match('/[\D]+/u', $_SESSION['REGISTER']['CUSTOMER']['phoneNumber']))
    {
        //если не проходит проверку
        array_push($_SESSION['REGISTER']['CUSTOMER']['ERRORS'], "Номер телефона должен состоять только из цифр");
    }

    //возможно проверка на дату рождения
}

function find_user()
{
    //Поиск нужного пользователя
    $customer_id = R::findOne('customers',
        'roles_id = ? AND
             surname = ? AND
             name = ? AND
             middle_name = ? AND
             dateBirth = ?', [
             $_SESSION['REGISTER']['CUSTOMER']['role_id'],
             $_SESSION['REGISTER']['CUSTOMER']['surname'],
             $_SESSION['REGISTER']['CUSTOMER']['name'],
             $_SESSION['REGISTER']['CUSTOMER']['middleName'],
             $_SESSION['REGISTER']['CUSTOMER']['dateBirth']]);

    if ($customer_id != NULL)
    {
        //если есть такой клиент, говорим что такой уже есть
        array_push($_SESSION['REGISTER']['CUSTOMER']['ERRORS'], "Клиент уже зарегистрирован");
    }
}

function register_customer()
{
    //проверяем есть ли такая таблица
    //создаем если нет
    $role_id = $_SESSION['REGISTER']['CUSTOMER']['role_id'];
    $role_id = R::findOne('roles', 'code = ?',  [$role_id]);

    $role = R::load('roles', $role_id->id);

    $customer = R::dispense('customers');
    $customer->gender       = $_SESSION['REGISTER']['CUSTOMER']['gender'];
    $customer->surname      = $_SESSION['REGISTER']['CUSTOMER']['surname'];
    $customer->name         = $_SESSION['REGISTER']['CUSTOMER']['name'];
    $customer->middleName   = $_SESSION['REGISTER']['CUSTOMER']['middleName'];
    $customer->dateBirth    = $_SESSION['REGISTER']['CUSTOMER']['dateBirth'];
    $customer->address      = $_SESSION['REGISTER']['CUSTOMER']['address'];
    $customer->phoneNumber  = $_SESSION['REGISTER']['CUSTOMER']['phoneNumber'];

    $role->ownCustomersList[] = $customer;
    R::store($role);

    //сообщение о успешной регистрации Клиента
    array_push($_SESSION['REGISTER']['CUSTOMER']['SUCCESS'],
        $_SESSION['REGISTER']['CUSTOMER']['surname'].' '.
        $_SESSION['REGISTER']['CUSTOMER']['name'].' '.
        $_SESSION['REGISTER']['CUSTOMER']['middleName'].' '.
               "успешно зарегистрирован как".' '.
        $_SESSION['REGISTER']['CUSTOMER']['role_name']);

    $_SESSION['REGISTER']['CUSTOMER']['reg'] = true;

    clear_user();//чтобы поля в регистрации были чистыми
}

function clear_user()
{
    $_SESSION['REGISTER']['CUSTOMER']['gender'] = "select_gender";
    $_SESSION['REGISTER']['CUSTOMER']['surname'] = '';
    $_SESSION['REGISTER']['CUSTOMER']['name'] = '';
    $_SESSION['REGISTER']['CUSTOMER']['middleName'] = '';
    $_SESSION['REGISTER']['CUSTOMER']['address'] = '';
    $_SESSION['REGISTER']['CUSTOMER']['phoneNumber'] = '';
    $_SESSION['REGISTER']['CUSTOMER']['dateBirth'] = NULL;
}
