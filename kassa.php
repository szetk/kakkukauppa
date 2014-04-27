<?php

require_once 'libs/common.php';

$tilaus = Tilaus::getTilaus();
$tilaus->setTuotteet(Tilaus::getTilausTuotteet($tilaus));

// Tuote vaidaan toimittaa aikaisintaan 3pv kuluttua tilauksesta
$ekaToimituspaiva = mktime(0, 0, 0, date("m"), date("d") + 3, date("Y"));
$toimituspaiva = date('Y-m-d', $ekaToimituspaiva);
$tilaus->setToimituspaiva($toimituspaiva);
$tilauspaiva = date('Y-m-d');


if (onKirjautunut()) {
    $kayttaja = haeKayttaja();
    $virheet = array(); // luodaan uusi lista virheille, jos käyttäjä on kirjautunut

    $readonly = true;
} else {
    $kayttaja = new Kayttaja();
    $readonly = false;
}
// jos kutsu ei ole POST-tyyppinen ei tarvitse tehdä tarkistuksia tai ilmoittaa virheistä (ollaan vasta tulossa kassasivulle)
// readonly on kassasivua varten, sillä kirjautuneen käyttjän tietokentät ovat vain readonly
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    naytaNakyma("kassa.php", array('kayttaja' => $kayttaja, 'tilaus' => $tilaus, 'readonly' => $readonly));
}

// kirjautunut käyttäjä ei voi muuttaa tietojaan kassasivulla, sillä siihen vaaditaan salasana
if (!onKirjautunut()) {
    $kayttaja->setEtunimi($_POST['etunimi']);
    $kayttaja->setSukunimi($_POST['sukunimi']);
    $kayttaja->setSahkoposti($_POST['sahkoposti']);

    $kayttaja->setPuhelin($_POST['puhelin']);
    $kayttaja->setOsoite($_POST['osoite']);
    $kayttaja->setPostinumero($_POST['postinumero']);
    $kayttaja->setPaikkakunta($_POST['paikkakunta']);

    $kayttaja->setKayttajaTyyppi('asiakas');
    $kayttaja->setSalasana(kryptaa("paasikivi")); //generoidaan uudelle käyttäjälle salasana

    $virheet = Kayttaja::kelpaakoKayttajaksi($kayttaja);
}


$toimitustapa = $_POST['toimitustapa'];
$maksutapa = $_POST['maksutapa'];
$toimituspaiva = $_POST['toimituspaiva'];

$tilaus->setToimituspaiva($toimituspaiva);
$tilaus->setToimitustapa($toimitustapa);
$tilaus->setMaksutapa($maksutapa);
$tilaus->setTilauspaiva($tilauspaiva);



if ($ekaToimituspaiva > strtotime($toimituspaiva)) {
    $virheet[] = "Toimitus voi olla aikaisintaan 3pv kuluttua. Päiväys on muodossa kk/pp/vvvv";
}

// Tarkastetaa vielä
// virheet on tyhjä, mikäli tilaus on soveltuva
if (!empty($virheet)) {
    naytaNakyma("kassa.php", array('kayttaja' => $kayttaja, 'tilaus' => $tilaus, 'virheet' => $virheet));
}
$tilaus->setTilausvaihe("tilattu");

if (!onKirjautunut()) {
    //rekisteröi käyttäjä generoidulla salasannalla
    $kayttajaId = Kayttaja::lisaaKayttaja($kayttaja);
    $tilaus->setKayttajaId();
    Tilaus::paivitaTilaus($tilaus);
    kirjauduSisaan(Kayttaja::etsiKayttajaIdlla($kayttajaId));
} else {
    Tilaus::paivitaTilaus($tilaus);
    unset($_SESSION['tilaus']);
}

ohjaaSivulle("index.php");
