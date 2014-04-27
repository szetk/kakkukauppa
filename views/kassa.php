<h3>Kassa</h3>
<form class="form-horizontal" role="form" action="kassa.php" method="POST">

    <?php
    if ($data->readonly) {
        echo 'Voit muokata tietojasi <a href="omaSivu.php">omien sivujesi</a> kautta';
    }
    require 'views/kayttajaLomake.php';
    ?> 
    <div class="form-group">
        <label class="col-md-3 control-label">Toimituspäivä</label>
        <div class="col-md-6">
            <input type="date" class="form-control" name="toimituspaiva" value="<?php echo $data->tilaus->getToimituspaiva(); ?>"> 
            <!--Huom! Päivämäärä muodossa kk/pp/vvvv (ilmeisesti vaan chromella)-->
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Toimitustapa</label>
        <div class="col-md-6">
            <select name="toimitustapa">
                <option value="nouto" <?php
                if ($data->tilaus->getToimitustapa() == "nouto") {
                    echo 'selected="selected"';
                }
                ?>>nouto</option>
                <option value="toimitus" <?php
                if ($data->tilaus->getToimitustapa() == "toimitus") {
                    echo 'selected="selected"';
                }
                ?>>toimitus</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Maksutapa</label>
        <div class="col-md-6">
            <select name="maksutapa">
                <option value="lasku" <?php
                if ($data->tilaus->getMaksutapa() == "lasku") {
                    echo 'selected="selected"';
                }
                ?>>lasku</option>
                <option value="tilisiirto" <?php
                if ($data->tilaus->getMaksutapa() == "tilisiirto") {
                    echo 'selected="selected"';
                }
                ?>>tilisiirto</option>
            </select>
        </div>
    </div>

    <h3>Tilauksesi tuotteet: </h3><br>
    <table>
        <thead>
            <tr>
                <th style="width:300px">Tuote</th>
                <th style="width:100px">Hinta</th>
                <th style="width:100px">Määrä</th>
                <th style="width:100px">Yhteensä</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data->tilaus->getTuotteet() as $tuoteId => $maara): ?>
                <?php
                $tuote = Tuote::etsi($tuoteId);
                ?>
                <tr>
                    <td><?php echo $tuote->getNimi(); ?></td>
                    <td><?php echo $tuote->getHinta(); ?> EUR</td>
                    <td><?php echo htmlspecialchars($maara); ?></td>
                    <td><?php
                        $yht = $yht + $tuote->getHinta() * $maara;
                        echo $tuote->getHinta() * $maara;
                        ?> EUR</td>
                </tr>
            <?php endforeach; ?>


            <tr style="height:30px">
                <td></td>
                <td></td>
                <td><h4>yhteensä</h4</td>
                <td><h4><?php echo $yht; ?> EUR</h4></td>
            </tr>
        </tbody>

    </table>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <h4>
                <button type="submit" class="btn btn-default">Aseta tilaus</button>
            </h4>
        </div>
    </div>
</form>