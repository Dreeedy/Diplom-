<?
$usersandbookacts_arr = R::findall('usersandbookacts');
$deathacts_arr = R::findall('deathacts');

$unicle_data = $_SESSION['SHOW']['unicle_data'];

$deathacts_arr_local = [];
foreach ($usersandbookacts_arr as $uba)
{
    if ($uba->year == $unicle_data & $uba->act_types_id == "4")// 4 - id - свидетельство о смерти
    {
        $deathacts_arr_local[] = $uba->deathacts;
    }
}
?>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">ФИО</th>
        <th scope="col">Дата наступления смерти</th>
    </tr>
    </thead>
    <tbody>
    <?
    $i = 1;
    foreach ($deathacts_arr_local as $death_act)
    {
        $customer = $death_act->fetchAs('customers')->customer;
        $customerFIO = $customer->surname.' '.$customer->name.' '.$customer->middle_name;
        echo
            '
    <tr>
        <th scope="row">'.$i.'</th>
        <td>'.$customerFIO.'</td>
        <td>'.$death_act->date_death.'</td>     
    </tr>
    ';
        $i++;
    }
    ?>
    </tbody>
</table>
