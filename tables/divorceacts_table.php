<?
$usersandbookacts_arr = R::findall('usersandbookacts');
$divorceacts_arr = R::findall('divorceacts');

$unicle_data = $_SESSION['SHOW']['unicle_data'];

$divorceacts_arr_local = [];
foreach ($usersandbookacts_arr as $uba)
{
    if ($uba->year == $unicle_data & $uba->act_types_id == "5")// 5 - id - свидетельство о расторжения брака
    {
        $divorceacts_arr_local[] = $uba->divorceacts;
    }
}
?>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">ФИО Мужа</th>
        <th scope="col">ФИО Жены</th>
        <th scope="col">Дата расторжения брака</th>
    </tr>
    </thead>
    <tbody>
    <?
    $i = 1;
    foreach ($divorceacts_arr_local as $divorce_act)
    {
        $husband = $divorce_act->fetchAs('customers')->husband;
        $husbandFIO = $husband->surname.' '.$husband->name.' '.$husband->middle_name;
        $wife = $divorce_act->fetchAs('customers')->wife;
        $wifeFIO = $wife->surname.' '.$wife->name.' '.$wife->middle_name;
        echo
            '
    <tr>
        <th scope="row">'.$i.'</th>
        <td>'.$husbandFIO.'</td>
        <td>'.$wifeFIO.'</td>
        <td>'.$divorce_act->date_divorce.'</td>     
    </tr>
    ';
        $i++;
    }
    ?>
    </tbody>
</table>
