<form class="form-horizontal" role="form" action="tuotetiedot.php" method="POST">
<?php if ($data->toimi == 'lisaa'){
    echo "<h3>Lisää uusi tuote </h3>";
    echo '<input type="hidden" name="toimi" value="lisaa">';
} else if ($data->toimi == 'muokkaa' || $data->toimi == 'tuotesivulta'){
    echo "<h3>Muokkaa tuotteen id=", $data->tuote->getTuoteId(), " tietoja </h3>";
    echo '<input type="hidden" name="toimi" value="muokkaa">';
    echo '<input type="hidden" name="tuoteId" value="', $data->tuote->getTuoteId(), '">';
}
?>
    
    <div class="form-group">
        <label class="col-md-3 control-label">Nimi</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="nimi" value="<?php echo htmlspecialchars($data->tuote->getNimi()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Hinta</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="hinta" value="<?php echo htmlspecialchars($data->tuote->getHinta()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Kuvaus</label>
        <div class="col-md-6">
            <textarea class="form-control" name="kuvaus" rows="5"><?php echo htmlspecialchars($data->tuote->getKuvaus()); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Kuvatiedoston nimi</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="kuva" value="<?php echo htmlspecialchars($data->tuote->getKuva()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Tuoteryhmä</label>
        <div class="col-md-6">
            <select name="tuoteryhma">
                <?php foreach ($data->tuoteryhmat as $ryhma):?>
                <option value="<?php echo htmlspecialchars($ryhma); ?>" <?php if ($data->tuoteryhma == $ryhma) {echo 'selected="selected"';} ?>><?php echo htmlspecialchars($ryhma);?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-6">
            <button type="submit" class="btn btn-default">Lähetä</button>
        </div>
    </div>
</form>