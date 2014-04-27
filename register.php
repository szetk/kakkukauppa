<?php

require_once 'libs/common.php';

$kayttaja = new Kayttaja();
// jos kutsu ei ole POST-tyyppinen ei tarvitse tehdä tarkistuksia tai ilmoittaa virheistä
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    naytaNakyma("register.php", array('kayttaja' => $kayttaja, 'readonly' => false));
}
// tiedot talteen
$kayttaja->setEtunimi($_POST['etunimi']);
$kayttaja->setSukunimi($_POST['sukunimi']);
$kayttaja->setSahkoposti($_POST['sahkoposti']);

$kayttaja->setPuhelin($_POST['puhelin']);
$kayttaja->setOsoite($_POST['osoite']);
$kayttaja->setPostinumero($_POST['postinumero']);
$kayttaja->setPaikkakunta($_POST['paikkakunta']);

$kayttaja->setKayttajaTyyppi('asiakas');

// Lomakkeessa on kaksi salasanakenttää. Toinen on varmistuksen vuoksi.
$salasana1 = $_POST['salasana1'];
$salasana2 = $_POST['salasana2'];

// Asetetaan aluksi salasana1 salasanaksi, jotta voidaan tarkistaa muiden kenttien pätevyys. Myöhemmin tarkastetaan täsmäävätkö nämä
$kayttaja->setSalasana(kryptaa($salasana1));

// Tämä palauttaa listan virheistä, mikäli kayttaja ei ole sovetuva kayttajaksi
$virheet = Kayttaja::kelpaakoKayttajaksi($kayttaja);

// jos salasanat eivät täsmää siitä ilmoitetaan käyttäjälle 
if ($salasana1 != $salasana2) {
    $virheet[] = "Salasanat eivät täsmää";
    // jos salasanat täsmäävät, tarkastetaan vielä niiden pituus
} else if (strlen($salasana1) < 4 || strlen($salasana1) > 30) {
    $virheet[] = "Salasanan tulee olla 4-30 merkkiä pitkä";
}
// jos virheet ei ole tyhjä, niin käyttäjä ei ole soveltuva
if (!empty($virheet)) {
    naytaNakyma("register.php", array('kayttaja' => $kayttaja, 'virheet' => $virheet, 'readonly' => false));
}
// jos kaikki on kunnossa, lisätään käyttäjä ja kirjaudutaan sisään
$kayttajaId = Kayttaja::lisaaKayttaja($kayttaja); // tämä palauttaa viimeksi asetetun käyttäjän tunnuksen, kayttajaId:n
kirjauduSisaan(Kayttaja::etsiKayttajaIdlla($kayttajaId));

ohjaaSivulle("index.php");
