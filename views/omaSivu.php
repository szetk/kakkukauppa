<h3>Omat sivusi!</h3>

<ul>
    <?php
    $k = haeKayttaja();
    if ($k->getKayttajaTyyppi() == "admin" || $k->getKayttajaTyyppi() == "tyontekija") {
        echo "<li> Olet henkilökuntaa!</li>";
        echo "<li> Kayttajatyyppi: ", $k->getKayttajaTyyppi(), "</li>";
    }
    echo "<li> Etunimi: ", $k->getEtunimi(), "</li>";
    echo "<li> Sukunimi: ", $k->getSukunimi(), "</li>";
    echo "<li> Sahkoposti: ", $k->getSahkoposti(), "</li>";
    echo "<li> Puhelinnumero: ", $k->getPuhelin(), "</li>";
    echo "<li> Osoite: ", $k->getOsoite(), "</li>";
    echo "<li> Postinumero: ", $k->getPostinumero(), "</li>";
    echo "<li> Postitoimipaikka: ", $k->getPosti(), "</li>";
    ?>
</ul>
