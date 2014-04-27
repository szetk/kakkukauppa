<table>
    <tr>
        <td style="width:700px">
            <h3><?php echo $data->tuote->getNimi(); ?></h3>
            <img class="media-object" src="<?php echo "imgs/", $data->tuote->getKuva(); ?>" onerror="this.src='imgs/kakku.jpg'"> 

            <h4><?php echo $data->tuote->getKuvaus(); ?></h4>
        </td>
        <td style="width:200px">
            <form class="form-horizontal" role="form" action="ostoskori.php" method="POST">
                <h4>Hinta: <?php echo $data->tuote->getHinta(); ?> EUR <br></h4>
                <div class="form-group">
                    <div class="col-md-6">
                        <input type="hidden" name="tuoteId" value=<?php echo $data->tuote->getTuoteId(); ?>/>
                        <input type="number" class="form-control" id="maara" name="maara" value="<?php if (isset($data->maara)){echo "$data->maara";} else{ echo "1"; }?>">
                        <button type="submit" class="btn btn-default">Lisää ostoskoriin</button>

                    </div>
                </div>
            </form>
            <?php if (onKirjautunut() && Kayttaja::onTyontekija(haeKayttaja())): ?>
                <form class="form-horizontal" role="form" action="tuotetiedot.php" method="POST">
                    <div class="form-group">
                        <div class="col-md-5">
                            <input type="hidden" name="toimi" value="tuotesivulta"> <!-- Tällä identifioidaan tullaanko ekaa kertaa muokkaamaan vai ei-->
                            <input type="hidden" name="tuoteId" value=<?php echo $data->tuote->getTuoteId(); ?>/>
                            <button type="submit" class="btn btn-default">Muokkaa tuotetta</button>
                        </div>
                    </div>
                </form>

                <form class="form-horizontal" role="form" action="tuotetiedot.php" method="POST">
                    <div class="form-group">
                        <div class="col-md-5">
                            <input type="hidden" name="toimi" value="poista"> <!-- Tällä identifioidaan tullaanko ekaa kertaa muokkaamaan vai ei-->
                            <input type="hidden" name="tuoteId" value=<?php echo $data->tuote->getTuoteId(); ?>/>
                            <button type="submit" class="btn btn-default">Poista</button>
                        </div>
                    </div>
                </form>
            <?php endif ?>
        </td>
    </tr>

</table>