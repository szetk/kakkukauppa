<?php

require_once 'libs/common.php';

// uusi lista virheille
$virheet = array();

// jos käyttäjä on kirjautunut, lukee navigaatio palkissa kirjaudu ulos, jolloin tätä klikannut käyttäjä kirjataan ulos
if (onKirjautunut()) {
    kirjauduUlos();
    ohjaaSivulle("login.php");
    // jos ei ole POST-tyyppinen, ollaan vasta tulossa ensimmäistä kertaa sivulle eikä virheitä tarvitse tarkistaa
} else if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    naytaNakyma('login.php');
    // muutoin tarkistetaan syötteet
} else if (empty($_POST["email"])) {
    $virheet[] = "Kirjautuminen epäonnistui! Et antanut sähköpostia!";
    naytaNakyma('login.php', array('virheet' => $virheet, 'kayttaja' => $kayttaja));
}

$kayttaja = $_POST["email"];
// salasanan olemassaolon tarkistus
if (empty($_POST["salasana"])) {
    $virheet[] = "Kirjautuminen epäonnistui! Et antanut salasanaa!";
    naytaNakyma('login.php', array('virheet' => $virheet, 'kayttaja' => $kayttaja));
}

$salasana = $_POST["salasana"];

// haetaan käyttäjä tietokannasta
$k = Kayttaja::etsiKayttajaTunnuksilla($kayttaja, kryptaa($salasana));

if (!is_null($k)) {
    kirjauduSisaan($k);
    ohjaaSivulle('index.php');
} else {
    $virheet[] = "Sähköposti ja salasana eivät täsmää";
    naytaNakyma('login.php', array('kayttaja' => $kayttaja, 'virheet' => $virheet, request));
}