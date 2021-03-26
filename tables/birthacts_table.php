<?
$usersandbookacts_arr = R::findall('usersandbookacts');
$birthacts_arr = R::findall('birthacts');

$unicle_data = $_SESSION['SHOW']['unicle_data'];

$birthacts_arr_local = [];
foreach ($usersandbookacts_arr as $uba)
{
    if ($uba->year == $unicle_data & $uba->act_types_id == "2")// 2 - id - свидетельство о рождении
    {
        $birthacts_arr_local[] = $uba->birthacts;
    }
}
?>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">ФИО Мужа</th>
        <th scope="col">ФИО Жены</th>
        <th scope="col">ФИО Ребенка</th>
        <th scope="col">Дата рождения</th>
    </tr>
    </thead>
    <tbody>
    <?
    $i = 1;
    foreach ($birthacts_arr_local as $birthacts_act)
    {
        $husband = $birthacts_act->fetchAs('customers')->husband;
        $husbandFIO = $husband->surname.' '.$husband->name.' '.$husband->middle_name;
        $wife = $birthacts_act->fetchAs('customers')->wife;
        $wifeFIO = $wife->surname.' '.$wife->name.' '.$wife->middle_name;
        $child = $birthacts_act->fetchAs('customers')->child;
        $childFIO = $child->surname.' '.$child->name.' '.$child->middle_name;
        echo
            '
    <tr>
        <th scope="row">'.$i.'</th>
        <td>'.$husbandFIO.'</td>
        <td>'.$wifeFIO.'</td>
        <td>'.$childFIO.'</td>
        <td>'.$birthacts_act->date_birth.'</td>     
    </tr>
    ';
        $i++;
    }
    ?>
    </tbody>
</table>
