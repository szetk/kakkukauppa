<h3>Tuotteemme</h3>
<!--<center>-->

<table>
    <thead>
        <tr>
            <td style="width:175px"></td>
            <td style="width:175px"></td>
            <td style="width:175px"></td>
            <td style="width:175px"></td>
        </tr>
    </thead>
    <tbody>
    <tr style="height:180px">
        <?php $n = 0; $i = 1; foreach($data->tuoteryhmat as $tuoteryhma):?>
        <td>
            <a href='lista.php?tuoteryhma=<?php echo $i; $i++; $n++;?>'><?php echo $tuoteryhma; ?><img class="media-object" src="imgs/kakku.png" alt="..."></a>
        </td>
        <?php if ($n == 4){$n = 0; echo '</tr><tr>';} ?>
        <?php endforeach;?>
        
    </tr>
</tbody>
</table>
<!--</center>-->