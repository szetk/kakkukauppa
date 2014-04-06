<h3>Haun tulokset</h3>
<h4><?php if ($data->hakusana != null){echo "Hakusanalla ", $data->hakusana; 
if ($data->tuotteita > 1){echo " löydettiin ", $data->tuotteita, " tuotetta.";}
else if ($data->tuotteita == 1){echo " löydettiin yksi tuote.";}
else {echo " ei löydetty yhtään tuotetta.";}} ?> </h4>




<div class="media">
    <ul class="media-list">

        <?php foreach($data->tuotteet as $tuote): ?>
        <li class="media">
            <a class="pull-left" href="#">
                <img class="media-object" src="kakku.png" alt="..."> 
            </a>
            <div class="media-body">
                <h4 class="media-heading"><?php echo $tuote->getNimi(); ?></h4>
                <h5><?php echo $tuote->getKuvaus(); ?> </h5>
                <h5 class="pull-right"> <?php echo $tuote->getHinta(); ?> EUR <br>
                    <a href="#"> Ostoskoriin </a> </h5>
                <a href="tuote.php?id=<?php echo $tuote->getTuoteId(); ?>">Lisätietoja > </a>
            </div>
        </li>
        <?php endforeach; ?>

    </ul>
</div>

<?php if ($data->sivu > 0): ?>
<a href="lista.php?sivu=<?php echo $data->sivu - 1; ?>">Edellinen sivu</a>
<?php endif; ?>
<?php if ($data->sivu < $data->sivuja): ?>
<a href="lista.php?sivu=<?php echo $data->sivu + 1; ?>">Seuraava sivu</a>
<?php endif; ?>