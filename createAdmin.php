<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--LINKS-->
    <?php require_once("blocks/links.php") ?>
    <!--Конец LINKS-->

    <title>ЗАГС ИК МО "ЛМР" РТ</title>
</head>
<body>
<!--HEADER-->
<?php require_once("blocks/header.php") ?>
<!--Конец HEADER-->

<!--MAIN-->
<div class="container" style="min-height: 850px; background-color: red">
    <main>
        <?php
        /*01-Подключение к базе данных*/
        require "rb/rb-mysql.php";
        require_once "dbConnection.php";

        R::setup(get_db_dns(), get_db_username(), get_db_password());

        if (!R::testConnection())
        {
            exit('Нет подключения к базе данных');
        }
        /*02-Подключение к базе данных*/

        $role_ID = R::findOne('roles', 'role_name = ?',  ['admin']);
        $role = R::load('roles', $role_ID->id);

        $staf = R::dispense('staff');
        $staf->surname = 'Иванов';
        $staf->name = 'Иван';
        $staf->middleName = 'Иванович';
        $staf->phoneNumber = '+79172444941';
        $staf->password = 'admin';

        $role->ownStaffList[] = $staf;
        R::store($role);
        ?>
    </main>
</div>
<!--Конец MAIN-->

<!--FOOTER-->
<?php require_once("blocks/footer.php") ?>
<!--Конец FOOTER-->
</body>
</html>