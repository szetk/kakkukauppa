<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';

$kayttaja = new Kayttaja();
// jos kutsu ei ole POST-tyyppinen ei tarvitse tehdä tarkistuksia tai ilmoittaa virheistä
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    naytaNakyma("register.php", array('kayttaja' => $kayttaja));
}

$kayttaja->setEtunimi($_POST['etunimi']);
$kayttaja->setSukunimi($_POST['sukunimi']);
$kayttaja->setSahkoposti($_POST['sahkoposti']);

$kayttaja->setPuhelin($_POST['puhelin']);
$kayttaja->setOsoite($_POST['osoite']);
$kayttaja->setPostinumero($_POST['postinumero']);
$kayttaja->setPosti($_POST['posti']);

$kayttaja->setKayttajaTyyppi('asiakas');

// Lomakkeessa on kaksi salasanakenttää. Toinen on varmistuksen vuoksi.
$salasana1 = $_POST['salasana1'];
$salasana2 = $_POST['salasana2'];

if ($salasana1 == $salasana2) {
    $kayttaja->setSalasana($salasana1);
}
// Tämä palauttaa listan virheistä, mikäli kayttaja ei ole sovetuva kayttajaksi
$virheet = Kayttaja::kelpaakoKayttajaksi($kayttaja);

// virheet on tyhjä, mikäli kayttaja on soveltuva
if (!empty($virheet)) {
    naytaNakyma("register.php", array('kayttaja' => $kayttaja, 'virheet' => $virheet));
}

Kayttaja::lisaaKayttaja($kayttaja);
ohjaaSivulle('login.php', array('viesti' => "Rekisteröityminen onnistui"));