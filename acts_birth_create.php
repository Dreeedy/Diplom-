<?php
session_start();
if ($_SESSION['code'] === "2" || $_SESSION['code'] === "3")
{
    //Пускать работников и админов
}
else
{
    header('location: index.php');
}
?>
<!doctype html>
<html lang="ru" class="html-18px">
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
<? require_once("blocks/header.php") ?>
<!--Конец HEADER-->

<!--MAIN-->
<main>
    <? require_once("blocksMain/acts_birth_main_create.php") ?>
</main>
<!--Конец MAIN-->

<!--FOOTER-->
<? require_once("blocks/footer.php") ?>
<!--Конец FOOTER-->
</body>
</html>
