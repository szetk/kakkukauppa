<h3>Tervetuloa!</h3>
Nämä sivut ovat osa erästä harjoitustyötä, jossa kuvitteelliselle Kakkukaupalle toteutetaan verkkokauppa. Valitettavasti kakkuja ei ole todellisuudessa saatavilla, mutta riittävää kysyntää ilmetessä voidaan perustaa tarvittava liiketoiminta.  
<h3>Suosituimmat tuotteet:</h3>
<div class="media">
    <ul class="media-list">

        <?php foreach ($data->tuotteet as $tuote): ?>
            <li class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="<?php echo "imgs/img",$tuote->getTuoteId(), ".png";?>" onerror="this.src='imgs/kakku.png'"> 
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $tuote->getNimi(); ?></h4>
                    <h5><?php echo $tuote->getKuvaus(); ?> </h5>
                    <h5 class="pull-right"> <?php echo $tuote->getHinta(); ?> EUR <br>
                        <form class="form-horizontal" role="form" action="ostoskori.php" method="POST">

                            <div class="form-group">
                                <div class="col-md-5">
                                    <input type="hidden" name="tuoteId" value=<?php echo $tuote->getTuoteId(); ?>/>
                                    <input type="hidden" class="form-control" id="maara" name="maara" value="1">
                                    <button type="submit" class="btn btn-default">Lisää ostoskoriin</button>

                                </div>
                            </div>
                        </form></h5>
                    <a href="tuote.php?id=<?php echo $tuote->getTuoteId(); ?>">Lisätietoja > </a>
                </div>
            </li>
        <?php endforeach; ?>

    </ul>
</div>