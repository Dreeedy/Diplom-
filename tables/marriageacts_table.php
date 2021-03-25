<?
$usersandbookacts_arr = R::findall('usersandbookacts');
$marriageacts_arr = R::findall('marriageacts');

$unicle_data = $_SESSION['SHOW']['unicle_data'];

function hui($usersandbookacts_arr, $unicle_data)
{
    $marriageacts_arr_local = [];
    foreach ($usersandbookacts_arr as $uba)
    {
        if ($uba->year == $unicle_data & $uba->act_types_id == "1")// 1 - id - свидетельство о заключении брака
        {
            myDump($uba->marriage_acts);
            $marriageacts_arr_local[] = $uba->marriageacts;
        }
    }
    return $marriageacts_arr_local;
}

hui($usersandbookacts_arr, $unicle_data);


?>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Муж</th>
        <th scope="col">Жена</th>
        <th scope="col">Дата заключения</th>
    </tr>
    </thead>
    <tbody>
    <?
    $i = 1;
    foreach ($marriageacts_arr as $marr_act)
    {
        $husband = $marr_act->fetchAs('customers')->husband;
        $husbandFIO = $husband->surname.' '.$husband->name.' '.$husband->middle_name;
        $wife = $marr_act->fetchAs('customers')->wife;
        $wifeFIO = $wife->surname.' '.$wife->name.' '.$wife->middle_name;
        echo
            '
    <tr>
        <th scope="row">'.$i.'</th>
        <td>'.$husbandFIO.'</td>
        <td>'.$wifeFIO.'</td>
        <td>'.$marr_act->date_marriage.'</td>     
    </tr>
    ';
        $i++;
    }
    ?>
    </tbody>
</table>
