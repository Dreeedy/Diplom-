<?php
session_start();

/*01-Подключение к базе данных*/
require "rb/rb-mysql.php";
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
    var_dump($_POST);
    //header('location: register.php');
}

