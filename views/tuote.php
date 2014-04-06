<table>
    <tr>
        <td style="width:700px">
            <h3><?php echo $data->tuote->getNimi(); ?></h3>
            <img class="media-object" src="kakku.png" alt="..."> 

            <h4><?php echo $data->tuote->getKuvaus(); ?></h4>
        </td>
        <td style="width:200px">
            <form class="form-horizontal" role="form" action="ostoskori.php" method="POST">

<!--                <select>
                    <option value="mansikka">Mansikka</option>
                    <option value="kinuski">Kinuski</option>
                </select>-->
                <h4>Hinta: <?php echo $data->tuote->getHinta(); ?> EUR <br></h4>
                <div class="form-group">
                    <div class="col-md-5">
                        <input type="hidden" name="tuoteId" value=<?php echo $data->tuote->getTuoteId(); ?>/>
                        <input type="number" class="form-control" id="maara" name="maara" value="1">
                        <button type="submit" class="btn btn-default">Lisää ostoskoriin</button>

                    </div>
                </div>
            </form>
        </td>
    </tr>

</table>