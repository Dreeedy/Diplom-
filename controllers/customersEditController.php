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

if ($_POST['do_edit'] == "true")
{
    customer_update();
}
else
{
    $_SESSION['EDIT']['CUSTOMER']['customerId'] = $_POST['customerId'];
    fill_session_edit();
    $_POST = null;
    header('location: ../customers_edit.php');
}


function customer_update()
{
    fill_session($_POST);//поместили данные в сесиию. дальше работа с ней
    data_validate();//валидация данных. дальше проверка на наличие ошибок в сесии
    if (empty($_SESSION['EDIT']['CUSTOMER']['ERRORS']))
    {
        //если ошибок нет. Ищем в базе
        //find_user();

        if (empty($_SESSION['EDIT']['CUSTOMER']['ERRORS']))
        {
            //если пользователь не найден
            register_customer();
            header('location: ../customers_edit.php');
        }else
        {
            //если такой пользователь найден
            header('location: ../customers_edit.php');
        }
    } else
    {
        //если ошибки есть. Редирект назад и выдаю ошибки там
        header('location: ../customers_edit.php');
    }
}

function fill_session($post)
{
    $_SESSION['EDIT']['CUSTOMER']['surname'] = $post['surname'];
    $_SESSION['EDIT']['CUSTOMER']['name'] = $post['name'];
    $_SESSION['EDIT']['CUSTOMER']['middleName'] = $post['middleName'];

    $_SESSION['EDIT']['CUSTOMER']['dateBirth'] = $post['dateBirth'];
    $_SESSION['EDIT']['CUSTOMER']['address'] = $post['address'];
    $_SESSION['EDIT']['CUSTOMER']['phoneNumber'] = $post['phoneNumber'];

    if ($post['gender'] == "Женщина")
    {
        $_SESSION['EDIT']['CUSTOMER']['gender'] = 'female';
    }
    if ($post['gender'] == "Мужчина")
    {
        $_SESSION['EDIT']['CUSTOMER']['gender'] = 'male';
    }

    $_SESSION['EDIT']['CUSTOMER']['role_id'] = '1';//роль клиента
    $_SESSION['EDIT']['CUSTOMER']['role_name'] = 'Клиент';
    $_SESSION['EDIT']['CUSTOMER']['ERRORS'] = [];
    $_SESSION['EDIT']['CUSTOMER']['SUCCESS'] = [];
    $_SESSION['EDIT']['CUSTOMER']['reg'] = false;
}

function fill_session_edit()
{
    $customer = R::Load('customers', $_SESSION['EDIT']['CUSTOMER']['customerId']);
    if ($customer != null)
    {
        $_SESSION['EDIT']['CUSTOMER']['surname'] = $customer->surname;
        $_SESSION['EDIT']['CUSTOMER']['name'] = $customer->name;
        $_SESSION['EDIT']['CUSTOMER']['middleName'] = $customer->middle_name;

        $_SESSION['EDIT']['CUSTOMER']['dateBirth'] = $customer->date_birth;
        $_SESSION['EDIT']['CUSTOMER']['address'] = $customer->address;
        $_SESSION['EDIT']['CUSTOMER']['phoneNumber'] = $customer->phone_number;

        if ($customer->gender == "Женщина")
        {
            $_SESSION['EDIT']['CUSTOMER']['gender'] = 'female';
        }
        if ($customer->gender == "Мужчина")
        {
            $_SESSION['EDIT']['CUSTOMER']['gender'] = 'male';
        }

        $_SESSION['EDIT']['CUSTOMER']['role_id'] = '1';//роль клиента
        $_SESSION['EDIT']['CUSTOMER']['role_name'] = 'Клиент';
        $_SESSION['EDIT']['CUSTOMER']['ERRORS'] = [];
        $_SESSION['EDIT']['CUSTOMER']['SUCCESS'] = [];
        $_SESSION['EDIT']['CUSTOMER']['reg'] = false;
    }
}

function data_validate()
{
    //gender
    if ($_SESSION['EDIT']['CUSTOMER']['gender'] == "select_gender") {
        array_push($_SESSION['EDIT']['CUSTOMER']['ERRORS'], "Необходимо указать пол клиента");
    }

    //surname
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['EDIT']['CUSTOMER']['surname']))
    {
        //если не проходит проверку
        array_push($_SESSION['EDIT']['CUSTOMER']['ERRORS'], "Фамилия может содержать только кириллицу");
    }

    //name
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['EDIT']['CUSTOMER']['name']))
    {
        //если не проходит проверку
        array_push($_SESSION['EDIT']['CUSTOMER']['ERRORS'], "Имя может содержать только кириллицу");
    }

    //middleName
    if (preg_match('/[^,\p{Cyrillic}]/ui', $_SESSION['EDIT']['CUSTOMER']['middleName']))
    {
        //если содержит не только кириллицу
        array_push($_SESSION['EDIT']['CUSTOMER']['ERRORS'], "Отчество может содержать только кириллицу");
    }

    //phoneNumber
    if (preg_match('/[\D]+/u', $_SESSION['EDIT']['CUSTOMER']['phoneNumber']))
    {
        //если не проходит проверку
        array_push($_SESSION['EDIT']['CUSTOMER']['ERRORS'], "Номер телефона должен состоять только из цифр");
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
            $_SESSION['EDIT']['CUSTOMER']['role_id'],
            $_SESSION['EDIT']['CUSTOMER']['surname'],
            $_SESSION['EDIT']['CUSTOMER']['name'],
            $_SESSION['EDIT']['CUSTOMER']['middleName'],
            $_SESSION['EDIT']['CUSTOMER']['dateBirth']]);

    if ($customer_id != NULL)
    {
        //если есть такой клиент, говорим что такой уже есть
        array_push($_SESSION['EDIT']['CUSTOMER']['ERRORS'], "Клиент уже зарегистрирован");
    }
}

function register_customer()
{
    //проверяем есть ли такая таблица
    //создаем если нет
/*    $role_id = $_SESSION['EDIT']['CUSTOMER']['role_id'];
    $role_id = R::findOne('roles', 'code = ?',  [$role_id]);

    $role = R::load('roles', $role_id->id);

    $customer = R::dispense('customers');
    $customer->gender       = $_SESSION['EDIT']['CUSTOMER']['gender'];
    $customer->surname      = $_SESSION['EDIT']['CUSTOMER']['surname'];
    $customer->name         = $_SESSION['EDIT']['CUSTOMER']['name'];
    $customer->middleName   = $_SESSION['EDIT']['CUSTOMER']['middleName'];
    $customer->dateBirth    = $_SESSION['EDIT']['CUSTOMER']['dateBirth'];
    $customer->address      = $_SESSION['EDIT']['CUSTOMER']['address'];
    $customer->phoneNumber  = $_SESSION['EDIT']['CUSTOMER']['phoneNumber'];

    $customer->main_surname  = $_SESSION['EDIT']['CUSTOMER']['surname'];;

    $role->ownCustomersList[] = $customer;
    R::store($role);

    //сообщение о успешной регистрации Клиента
    array_push($_SESSION['EDIT']['CUSTOMER']['SUCCESS'],
        $_SESSION['EDIT']['CUSTOMER']['surname'].' '.
        $_SESSION['EDIT']['CUSTOMER']['name'].' '.
        $_SESSION['EDIT']['CUSTOMER']['middleName'].' '.
        "успешно зарегистрирован как".' '.
        $_SESSION['EDIT']['CUSTOMER']['role_name']);

    $_SESSION['EDIT']['CUSTOMER']['reg'] = true;

    clear_user();//чтобы поля в регистрации были чистыми*/

    $customer = R::Load('customers', $_SESSION['EDIT']['CUSTOMER']['customerId']);
    if ($customer != null)
    {
        $customer->surname = $_SESSION['EDIT']['CUSTOMER']['surname'];
        $customer->name = $_SESSION['EDIT']['CUSTOMER']['name'];
        $customer->middle_name = $_SESSION['EDIT']['CUSTOMER']['middleName'];

        $customer->date_birth = $_SESSION['EDIT']['CUSTOMER']['dateBirth'];

        $customer->phone_number = $_SESSION['EDIT']['CUSTOMER']['phoneNumber'];
        $customer->address = $_SESSION['EDIT']['CUSTOMER']['address'];


        if ($_SESSION['EDIT']['CUSTOMER']['gender'] == "female")
        {
            $_SESSION['EDIT']['CUSTOMER']['gender'] = 'Женщина';
        }
        if ($_SESSION['EDIT']['CUSTOMER']['gender'] == "male")
        {
            $_SESSION['EDIT']['CUSTOMER']['gender'] = 'Мужчина';
        }
        $customer->gender = $_SESSION['EDIT']['CUSTOMER']['gender'];
        R::store($customer);

        array_push($_SESSION['EDIT']['CUSTOMER']['SUCCESS'],
            "Данные ".' '.
            $_SESSION['EDIT']['CUSTOMER']['surname'].' '.
            $_SESSION['EDIT']['CUSTOMER']['name'].' '.
            $_SESSION['EDIT']['CUSTOMER']['middleName'].' '.
            "успешно обновлены");

        if ($_SESSION['EDIT']['CUSTOMER']['gender'] == "Женщина")
        {
            $_SESSION['EDIT']['CUSTOMER']['gender'] = 'female';
        }
        if ($_SESSION['EDIT']['CUSTOMER']['gender'] == "Мужчина")
        {
            $_SESSION['EDIT']['CUSTOMER']['gender'] = 'male';
        }

        //clear_user();
    }
}

function clear_user()
{
    $_SESSION['EDIT']['CUSTOMER']['gender'] = "select_gender";
    $_SESSION['EDIT']['CUSTOMER']['surname'] = '';
    $_SESSION['EDIT']['CUSTOMER']['name'] = '';
    $_SESSION['EDIT']['CUSTOMER']['middleName'] = '';
    $_SESSION['EDIT']['CUSTOMER']['address'] = '';
    $_SESSION['EDIT']['CUSTOMER']['phoneNumber'] = '';
    $_SESSION['EDIT']['CUSTOMER']['dateBirth'] = NULL;
}
