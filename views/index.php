<h3>Tervetuloa!</h3>
Nämä sivut ovat osa erästä harjoitustyötä, jossa kuvitteelliselle Kakkukaupalle toteutetaan verkkokauppa. Valitettavasti kakkuja ei ole todellisuudessa saatavilla, mutta riittävää kysyntää ilmetessä voidaan perustaa tarvittava liiketoiminta.  
<h3>Suosituimmat tuotteet:</h3>
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
                    <a class="pull-left" href="#">
                        <img class="media-object" src="<?php echo "imgs/", $tuote->getKuva(); ?>" onerror="this.src='imgs/kakku.png'"> 
                    </a>
                </td>
                <td>
                    <h4 class="media-heading"><?php echo $tuote->getNimi(); ?></h4>
                    <h5><?php echo $tuote->getKuvaus(); ?> </h5>
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