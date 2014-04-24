<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';

$virheet = array();

if (onKirjautunut()) {
    kirjauduUlos();
    ohjaaSivulle("login.php");
} else if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    naytaNakyma('login.php');
} else if (empty($_POST["email"])) {
    $virheet[] = "Kirjautuminen epäonnistui! Et antanut sähköpostia!";
    naytaNakyma('login.php', array('virheet' => $virheet, 'kayttaja' => $kayttaja));
}

$kayttaja = $_POST["email"];

if (empty($_POST["salasana"])) {
    $virheet[] = "Kirjautuminen epäonnistui! Et antanut salasanaa!";
    naytaNakyma('login.php', array('virheet' => $virheet));
}

$salasana = $_POST["salasana"];

$k = Kayttaja::etsiKayttajaTunnuksilla($kayttaja, kryptaa($salasana));

if (!is_null($k)) {
    kirjauduSisaan($k);
    ohjaaSivulle('index.php');
} else {
    $virheet[] = "Sähköposti ja salasana eivät täsmää";
    naytaNakyma('login.php', array('kayttaja' => $kayttaja, 'virheet' => $virheet, request));
}