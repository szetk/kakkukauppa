<h3><?php
    // jos tullaan etusivulta, niin tulostetaan
    if (isset($data->etusivulta)) {
        echo "Suosituimmat tuotteet:";
    } else {
        echo "Haun tulokset:";
    }
    ?>
</h3>
<h4><?php
    if (isset($data->hakusana)) {
        if ($data->hakusana != null) {
            echo 'Hakusanalla "', htmlspecialchars($data->hakusana);
            if ($data->tuotteita > 1) {
                echo '" löydettiin ', $data->tuotteita, " tuotetta.";
            } else if ($data->tuotteita == 1) {
                echo " löydettiin yksi tuote.";
            } else {
                echo " ei löydetty yhtään tuotetta.";
            }
        }
    } else if (isset($data->tuoteryhma)) {
        echo "Tuoteryhmästä ", $data->tuoteryhma;
        if ($data->tuotteita > 1) {
                echo '" löydettiin ', $data->tuotteita, " tuotetta.";
            } else if ($data->tuotteita == 1) {
                echo " löydettiin yksi tuote.";
            } else {
                echo " ei löydetty yhtään tuotetta.";
            }
    }
    ?> </h4>




<table>
    <thead>
        <tr>
            <td style="width:150px"></td>
            <td style="width:500px"></td>
            <td style="width:200px"></td>
        </tr>
    </thead>
    <tbody>
<?php foreach ($data->tuotteet as $tuote): ?>
            <tr>
                <td>
                    <a class="pull-left" href="tuote.php?id=<?php echo $tuote->getTuoteId(); ?>">
                        <img width="100px" height="100px" class="media-object" src="<?php echo "imgs/", $tuote->getKuva(); ?>" onerror="this.src='imgs/kakku.jpg'"> 
                    </a>
                </td>
                <td>
                    <h4 class="media-heading"><?php echo $tuote->getNimi(); ?></h4>
                    <h5><?php
                        $kuvaus = $tuote->getKuvaus();
                        if (strlen($kuvaus) > 200) {
                            $kuvaus = substr($kuvaus, 0, 200);
                            $kuvaus = "$kuvaus...";
                        }
                        echo $kuvaus;
                        ?> </h5>
                    <a href="tuote.php?id=<?php echo $tuote->getTuoteId(); ?>">Lisätietoja > </a>

                </td>
                <td>
                    <h5 class="pull-right"> <?php echo $tuote->getHinta(); ?> EUR <br>
                        <form class="form-horizontal" role="form" action="ostoskori.php" method="POST">

                            <div class="form-group">
                                <div class="col-md-5">
                                    <input type="hidden" name="tuoteId" value=<?php echo $tuote->getTuoteId(); ?>/>
                                    <input type="hidden" class="form-control" id="maara" name="maara" value="1">
                                    <button type="submit" class="btn btn-default">Lisää ostoskoriin</button>

                                </div>
                            </div>
                        </form>
    <?php if (onKirjautunut() && Kayttaja::onTyontekija(haeKayttaja())): ?>
                            <form class="form-horizontal" role="form" action="tuotetiedot.php" method="POST">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <input type="hidden" name="toimi" value="tuotesivulta"> <!-- Tällä identifioidaan tullaanko ekaa kertaa muokkaamaan vai ei-->
                                        <input type="hidden" name="tuoteId" value="<?php echo $tuote->getTuoteId(); ?>"/>
                                        <button type="submit" class="btn btn-default">Muokkaa tuotetta</button>
                                    </div>
                                </div>
                            </form>

                            <form class="form-horizontal" role="form" action="tuotetiedot.php" method="POST">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <input type="hidden" name="toimi" value="poista"> <!-- Tällä identifioidaan tullaanko ekaa kertaa muokkaamaan vai ei-->
                                        <input type="hidden" name="tuoteId" value="<?php echo $tuote->getTuoteId(); ?>"/>
                                        <button type="submit" class="btn btn-default">Poista</button>
                                    </div>
                                </div>
                            </form>
    <?php endif ?>
                    </h5>
                </td>
                <td></td>
            </tr>
            <tr style="height:10px"></tr>
<?php endforeach; ?>
    </tbody>
</table>

<?php if ($data->sivu > 1): ?>
    <a href="lista.php?sivu=<?php echo $data->sivu - 1; ?>">Edellinen sivu</a>
<?php endif; ?>
<?php if ($data->sivu < $data->sivuja): ?>
    <a href="lista.php?sivu=<?php echo $data->sivu + 1; ?>">Seuraava sivu</a>
<?php endif; ?>