<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';
include 'libs/models/Tilaus.php';

session_start();

$tilaus = Tilaus::getTilaus();

if (!empty($_POST['tyhjenna'])) {
    Tilaus::tyhjennaOstoskori($tilaus);
    $tilaus->setTuotteet(Tilaus::getTilausTuotteet($tilaus));
    naytaNakyma("ostoskori.php", array('tilaus' => $tilaus));
}

if (!empty($_POST['maarat']) && !empty($_POST['tuotteet'])) {
    $tuotteet = $_POST['tuotteet'];
    $maarat = $_POST['maarat'];
    foreach ($tuotteet as $key => $tuote) {
        Tilaus::paivitaMaarat($tilaus, $tuote, $maarat[$key]);
//        echo "Tuotteen ID: ", $tuote, " ja tuotteita: ", $maarat[$key], ", thank you<br>";
    }
}

if (!empty($_POST['poista'])) {
    $poistettavaTuote = $_POST['poista'];
    Tilaus::poistaTuote($tilaus, $poistettavaTuote);
}

$tilaus->setTuotteet(Tilaus::getTilausTuotteet($tilaus));


if (empty($_POST['tuoteId'])) {
    naytaNakyma("ostoskori.php", array('tilaus' => $tilaus));
}
$tuoteId = $_POST["tuoteId"];

if (empty($_POST["maara"])) {
    naytaNakyma("ostoskori.php", array('tilaus' => $tilaus));
}
$maara = $_POST["maara"];

if ($maara >= 1) {
    Tilaus::lisaaOstoskoriin($tilaus, $tuoteId, $maara);
    $tilaus->setTuotteet(Tilaus::getTilausTuotteet($tilaus));
}


naytaNakyma("ostoskori.php", array('tilaus' => $tilaus));
