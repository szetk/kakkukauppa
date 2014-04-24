<?php

require_once 'libs/common.php';
include_once 'libs/models/Kayttaja.php';
include_once 'libs/models/Tuote.php';
include_once 'libs/models/Tuoteryhma.php';

if (!onKirjautunut()) {
    ohjaaSivulle("login.php");
} else if (!Kayttaja::onTyontekija(haeKayttaja())) {
    ohjaaSivulle("index.php");
}

$tuote = new Tuote();
$tuoteryhmat = Tuoteryhma::getTuoteryhmienNimet();
$tuoteryhma = "";
$toimi = "";
// jos kutsu ei ole POST-tyyppinen ei tarvitse tehdä tarkistuksia tai ilmoittaa virheistä
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    naytaNakyma("tuotetiedot.php", array('tuote' => $tuote, 'tuoteryhmat' => $tuoteryhmat, 'tuoteryhma' => $tuoteryhma, 'toimi' => "lisaa"));
}
if (isset($_POST['tuoteryhma'])) {
    $tuoteryhma = $_POST['tuoteryhma'];
}
if (isset($_POST['toimi'])) {
    $toimi = $_POST['toimi'];
}
if (isset($_POST['tuoteId'])) {
    $tuoteId = $_POST['tuoteId'];
}

if ($toimi == "poista") {
    Tuote::poista($tuoteId);
    ohjaaSivulle("lista.php");
} else if ($toimi == "tuotesivulta") {
    $tuote = Tuote::etsi($tuoteId);
    naytaNakyma("tuotetiedot.php", array('tuote' => $tuote, 'tuoteryhmat' => $tuoteryhmat, 'tuoteryhma' => $tuoteryhma, 'toimi' => $toimi));
} else if ($toimi == "muokkaa") {
    $toimi = "muokkaa";
    $tuote->setTuoteId($tuoteId);
} else if ($toimi == "lisaa") {
    $toimi = "lisaa";
}

$tuote->setNimi($_POST['nimi']);
$tuote->setHinta($_POST['hinta']);
$tuote->setKuvaus($_POST['kuvaus']);
$tuote->setKuva($_POST['kuva']);
$tuote->setTuoteryhmaId(Tuoteryhma::haeTuoteryhmaId($_POST['tuoteryhma']));

// Tämä palauttaa listan virheistä, mikäli kayttaja ei ole sovetuva kayttajaksi
$virheet = Tuote::kelpaakoTuotteeksi($tuote);

// virheet on tyhjä, mikäli kayttaja on soveltuva
if (!empty($virheet)) {
    naytaNakyma("tuotetiedot.php", array('tuote' => $tuote, 'tuoteryhmat' => $tuoteryhmat, 'virheet' => $virheet, 'tuoteryhma' => $tuoteryhma, 'toimi' => $toimi));
}

if ($toimi == "muokkaa") {
    Tuote::paivitaTuote($tuote);
    ohjaaSivulle("tuote.php?id=$tuoteId");
} else if ($toimi == "lisaa") {
    $tuoteId = Tuote::lisaaTuote($tuote);
    ohjaaSivulle("tuote.php?id=$tuoteId");
}

