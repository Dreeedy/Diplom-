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
