<h3>Omat sivusi!</h3>

<ul>
    <?php
    $k = haeKayttaja();
    if ($k->getKayttajaTyyppi() == "admin" || $k->getKayttajaTyyppi() == "tyontekija") {
        echo "<li> Olet henkilökuntaa!</li>";
        echo "<li> Käyttäjätyyppi: ", $k->getKayttajaTyyppi(), "</li>";
        echo '<a href="tuotetiedot.php">Lisää tuote</a> (muokkaaminen ja poistaminen toimii haun kautta)<br>';

        if ($k->getKayttajaTyyppi() == "admin") {
            echo '<a href="kayttajat.php">Muokkaa käyttäjätyyppejä</a>';
        }
    }
    ?>
</ul>
<form class="form-horizontal" role="form" action="omaSivu.php" method="POST">
    <h4>Päivitä tietosi:</h4>
    <?php
    require 'views/kayttajaLomake.php';
    ?>

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
    <div class="form-group">
        <div class="col-md-offset-2 col-md-6">
            <button type="submit" name="poista" value="poista" class="btn btn-default">Poista käyttäjätili</button>
        </div>
    </div>
</form>
