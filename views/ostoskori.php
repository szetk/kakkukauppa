
<h3>Ostoskorisi:</h3>
<h4>Id: <?php echo $data->tilaus->getTilausId(); $yht = 0; ?> </h4>

<form class="form-horizontal" role="form" action="ostoskori.php" method="POST">


    <table>
        <thead>
            <tr>
                <th>Tuote</th>
                <th style="width:100px">Hinta</th>
                <th style="width:100px">Määrä</th>
                <th style="width:100px">Yhteensä</th>
                <th style="width:50px"></th>
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
                            <a class="pull-left" href="#">
                                <img class="media-object" src="kakku.png" alt="..."> 
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $tuote->getNimi(); ?></h4>
                                <h5><?php echo $tuote->getKuvaus(); ?></h5>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $tuote->getHinta(); ?> EUR</td>
                    <td><input type="number" class="form-control" name="maarat[]" value=<?php echo $maara; ?>></td>
                    <td><?php $yht = $yht + $tuote->getHinta() * $maara; echo $tuote->getHinta() * $maara;?> EUR</td>
                    <td><h3><a href="#">X</a></h3></td>
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
            <h4>
                <button type="submit" class="btn btn-default">Tallenna muutokset</button>
            </h4>
        </div>
    </div>

</form>
<form class="form-horizontal" role="form" action="ostoskori.php" method="POST">
    <input type="hidden" name="tyhjenna" value="tyhjenna">
    <button type="submit" class="btn btn-default">Tyhjennä ostoskori</button>    
</form>                
<a href="kassa.html">Kassalle</a> 
