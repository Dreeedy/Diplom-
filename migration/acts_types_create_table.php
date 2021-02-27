<?php
/*01-Подключение к базе данных*/
require_once "../rb/rb-mysql.php";
require_once "../dbConnection.php";

R::setup(get_db_dns(), get_db_username(), get_db_password());

if (!R::testConnection())
{
    exit('Нет подключения к базе данных');
}
/*02-Подключение к базе данных*/

$acts_types_table = R::dispense('actstypes');
$acts_types_table->typeName = 'Свидетельство о заключении брака';
$acts_types_table->typeCode = 0;
R::store($acts_types_table);

$acts_types_table1 = R::dispense('actstypes');
$acts_types_table1->type_name = 'Свидетельство о рождении';
$acts_types_table1->type_code = 1;
R::store($acts_types_table1);

$acts_types_table2 = R::dispense('actstypes');
$acts_types_table2->type_name = 'Свидетельство о усыновлении';
$acts_types_table2->type_code = 2;
R::store($acts_types_table2);

$acts_types_table3 = R::dispense('actstypes');
$acts_types_table3->type_name = 'Свидетельство о смерти';
$acts_types_table3->type_code = 3;
R::store($acts_types_table3);