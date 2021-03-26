<?
$usersandbookacts_arr = R::findall('usersandbookacts');
$adoptionacts_arr = R::findall('adoptionacts');

$unicle_data = $_SESSION['SHOW']['unicle_data'];

$adoptionacts_arr_local = [];
foreach ($usersandbookacts_arr as $uba)
{
    if ($uba->year == $unicle_data & $uba->act_types_id == "3")// 3 - id - свидетельство о усыновлении
    {
        $adoptionacts_arr_local[] = $uba->adoptionacts;
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
        <th scope="col">Дата усыновления (удочерения)</th>
    </tr>
    </thead>
    <tbody>
    <?
    $i = 1;
    foreach ($adoptionacts_arr_local as $adoptionacts_act)
    {
        $husband = $adoptionacts_act->fetchAs('customers')->husband;
        $husbandFIO = $husband->surname.' '.$husband->name.' '.$husband->middle_name;
        $wife = $adoptionacts_act->fetchAs('customers')->wife;
        $wifeFIO = $wife->surname.' '.$wife->name.' '.$wife->middle_name;
        $child = $adoptionacts_act->fetchAs('customers')->child;
        $childFIO = $child->surname.' '.$child->name.' '.$child->middle_name;
        echo
            '
    <tr>
        <th scope="row">'.$i.'</th>
        <td>'.$husbandFIO.'</td>
        <td>'.$wifeFIO.'</td>
        <td>'.$childFIO.'</td>
        <td>'.$adoptionacts_act->date_birth.'</td>    
        <td>'.$adoptionacts_act->date_adoption.'</td>   
    </tr>
    ';
        $i++;
    }
    ?>
    </tbody>
</table>
