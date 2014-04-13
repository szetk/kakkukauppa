<h3>Omat sivusi!</h3>

<ul>
    <?php
    $k = haeKayttaja();
    if ($k->getKayttajaTyyppi() == "admin" || $k->getKayttajaTyyppi() == "tyontekija") {
        echo "<li> Olet henkilökuntaa!</li>";
        echo "<li> Käyttäjätyyppi: ", $k->getKayttajaTyyppi(), "</li>";
    }
//    echo "<li> Etunimi: ", $k->getEtunimi(), "</li>";
//    echo "<li> Sukunimi: ", $k->getSukunimi(), "</li>";
//    echo "<li> Sahkoposti: ", $k->getSahkoposti(), "</li>";
//    echo "<li> Puhelinnumero: ", $k->getPuhelin(), "</li>";
//    echo "<li> Osoite: ", $k->getOsoite(), "</li>";
//    echo "<li> Postinumero: ", $k->getPostinumero(), "</li>";
//    echo "<li> Postitoimipaikka: ", $k->getPosti(), "</li>";
    ?>
</ul>
<form class="form-horizontal" role="form" action="omaSivu.php" method="POST">
    <h4>Päivitä tietosi:</h4>

    <div class="form-group">
        <label class="col-md-3 control-label">Etunimi</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="etunimi" value="<?php echo $data->kayttaja->getEtunimi(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Sukunimi</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="sukunimi" value="<?php echo $data->kayttaja->getSukunimi(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Sähköposti</label>
        <div class="col-md-6">
            <input type="email" class="form-control" name="sahkoposti" value="<?php echo $data->kayttaja->getSahkoposti(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Puhelinnumero</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="puhelin" value="<?php echo $data->kayttaja->getPuhelin(); ?>">
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Katuosoite</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="osoite" value="<?php echo $data->kayttaja->getOsoite(); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Postinumero</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="postinumero" value="<?php echo $data->kayttaja->getPostinumero(); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Postitoimipaikka</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="posti" value="<?php echo $data->kayttaja->getPosti(); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Salasana</label>
    <div class="col-md-6">
        <input type="password" class="form-control"  name="salasana0">
    </div>
</div>

<h4>Vaihda salasana:</h4>

<div class="form-group">
    <label class="col-md-3 control-label">Uusi salasana</label>
    <div class="col-md-6">
        <input type="password" class="form-control"  name="salasana1">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Vahvista uusi salasana</label>
    <div class="col-md-6">
        <input type="password" class="form-control"  name="salasana2" >
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-2 col-md-6">
        <button type="submit" class="btn btn-default">Päivitä tiedot</button>
    </div>
</div>
</form>
