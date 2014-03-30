<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';

session_start();

if (onKirjautunut()) {
    kirjauduUlos();
    ohjaaSivulle("login.php");
} else if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    naytaNakyma('login.php');
} else if (empty($_POST["email"])) {
    naytaNakyma('login.php', array('virhe' => "Kirjautuminen epäonnistui! Et antanut sähköpostia!", 'kayttaja' => $kayttaja));
}

$kayttaja = $_POST["email"];

if (empty($_POST["password"])) {
    naytaNakyma('login.php', array('virhe' => "Kirjautuminen epäonnistui! Et antanut salasanaa!"));
}

$salasana = $_POST["password"];

$k = new Kayttaja();
$k = $k->etsiKayttajaTunnuksilla($kayttaja, $salasana);

if (!is_null($k)) {
    $_SESSION['kirjautunut'] = $k;
    ohjaaSivulle('index.php');
} else {
    naytaNakyma('login.php', array('kayttaja' => $kayttaja, 'virhe' => "Virhe! Sähköposti ja salasana eivät täsmää.", request));
}