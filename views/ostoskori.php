
<h3>Ostoskorisi:</h3>
<h5>Ostoskorin tunnus: <?php
    echo $data->tilaus->getTilausId();
    $yht = 0;
    ?> </h5>

<h3>Tuotteet:</h3>


<form class="form-horizontal" role="form" action="ostoskori.php" method="POST">


    <table>
        <thead>
            <tr>
                <th style="width:500px">Tuote</th>
                <th style="width:100px">Hinta</th>
                <th style="width:70px">Määrä</th>
                <th style="width:90px">Yhteensä</th>
                <th style="width:10px"></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data->tilaus->getTuotteet() as $tuoteId => $maara): ?>
                <?php
                $tuote = Tuote::etsi($tuoteId);
                ?>
                <tr>
                    <td>
                        <div class="media">
                            <a class="pull-left" href="tuote.php?id=<?php echo $tuote->getTuoteId(); ?>">
                        <img width="100px" height="100px" class="media-object" src="<?php echo "imgs/", $tuote->getKuva(); ?>" onerror="this.src='imgs/kakku.jpg'"> 
                    </a>
                            <div class="media-body">
                                <a href="tuote.php?id=<?php echo $tuote->getTuoteId(); ?>" style="color: rgb(0,0,0)"><h4 class="media-heading"><?php echo $tuote->getNimi(); ?></h4></a>
                                <h5><?php
                        $kuvaus = $tuote->getKuvaus();
                        if (strlen($kuvaus) > 200) {
                            $kuvaus = substr($kuvaus, 0, 200);
                            $kuvaus = "$kuvaus...";
                        }
                        echo $kuvaus;
                        ?></h5>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $tuote->getHinta(); ?> EUR</td>
                    <td>
                            <input type="number" class="form-control" name="maarat[]" value=<?php echo htmlspecialchars($maara); ?>>
                    </td>
                    <td><?php
                        $yht = $yht + $tuote->getHinta() * $maara;
                        echo $tuote->getHinta() * $maara;
                        ?> EUR</td>
                    <td><h3><a href="ostoskori.php?poista=<?php echo $tuote->getTuoteId() ?>">X</a></h3></td>
            <input type="hidden" name="tuotteet[]" value=<?php echo $tuoteId; ?>>

            </tr>
            <tr style="height:15px"></tr>
        <?php endforeach; ?>


        <tr style="height:30px">
            <td></td>
            <td></td>
            <td>yhteensä</td>
            <td><?php echo $yht; ?> EUR</td>
            <td></td>
        </tr>
        </tbody>

    </table>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" class="btn btn-default">Tallenna muutokset</button>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" name="tyhjenna" value="tyhjenna" class="btn btn-default">Tyhjennä ostoskori</button>    
        </div>
    </div>
</form>

<div class="form-group">
    <form class="form-horizontal" role="form" action="kassa.php" method="GET">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" class="btn btn-default">Kassalle</button>    
        </div>
    </form>
</div>
