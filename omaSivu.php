<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';

if (!onKirjautunut()) {
    ohjaaSivulle("login.php");
}
//kirjautunut on sessiosta löytyvä kayttaja, eli käyttäjä joka aikoo tehdä muutoksia
$kirjautunut = haeKayttaja();
// mikäli kutsu ei ole POST-tyyppinen, on käyttäjä vasta menossa omalle sivulle, eikä tietoja tarvitse tarkistaa

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    naytaNakyma("omaSivu.php", array('kayttaja' => $kirjautunut));
}

// luodaan uusi käyttäjä lomakkeen tietoja varten, kirjautunut pitää tallessa tietokannassa olevan käyttäjän tiedot
$kayttaja = new Kayttaja();
// näitä kahta käyttäjä ei pysty muuttomaan, joten ne ovat samat kuin aiemminkin
$kayttaja->setKayttajaId($kirjautunut->getKayttajaId());
$kayttaja->setKayttajaTyyppi($kirjautunut->getKayttajaTyyppi());

$kayttaja->setEtunimi($_POST['etunimi']);
$kayttaja->setSukunimi($_POST['sukunimi']);
$kayttaja->setSahkoposti($_POST['sahkoposti']);

$kayttaja->setPuhelin($_POST['puhelin']);
$kayttaja->setOsoite($_POST['osoite']);
$kayttaja->setPostinumero($_POST['postinumero']);
$kayttaja->setPaikkakunta($_POST['paikkakunta']);

$salasana0 = $_POST['salasana0']; // vanha salasana
$salasana1 = $_POST['salasana1'];
$salasana2 = $_POST['salasana2'];

$virheet = array();

// onko salasana oikein
if ($salasana0 == $kirjautunut->getSalasana()) {
    // selvitetään haluaako käyttäjä vaihtaa salasanan
    if (!empty($salasana1) && !empty($salasana2) && $salasana1 == $salasana2) {
        $kayttaja->setSalasana($salasana1);
        $virheet = Kayttaja::kelpaakoKayttajaksi($kayttaja, true);
    } else {
        $kayttaja->setSalasana($salasana0);
        $virheet = Kayttaja::kelpaakoKayttajaksi($kayttaja, true);
    }
} else {
    $virheet[] = "Väärä salasana";
}

if (empty($virheet)) {
    // Jos käyttäjä on painanut painiketta "Poista käyttäjätili" niin sittenhän se poistetaan
    if (isset($_POST['poista'])) {
        Kayttaja::poistaKayttaja($kirjautunut->getKayttajaId());
        kirjauduUlos();
        ohjaaSivulle("index.php");
    } else {
        Kayttaja::paivitaKayttaja($kayttaja);
        $k = Kayttaja::etsiKayttajaTunnuksilla($kayttaja->getSahkoposti(), $kayttaja->getSalasana());
        kirjauduSisaan($k);
        ohjaaSivulle("omaSivu.php", array('kayttaja' => $k));
    }
}
naytaNakyma("omaSivu.php", array('kayttaja' => $kayttaja, 'virheet' => $virheet));
