<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';
include 'libs/models/Tuote.php';


$sivu = 1;
if (isset($_GET['sivu'])) {
    $sivu = (int) $_GET['sivu'];

//Sivunumero ei saa olla pienempi kuin yksi
    if ($sivu < 1) {
        $sivu = 1;
    }
}
$montako = 3; // Tämä voisi olla toki enemmänkin, mutta toistaiseksi tuotteita on niin vähän

$hakusana = $_GET['hakusana'];
$tuotteet = Tuote::hae($hakusana, $sivu, $montako);
$tuotteita = Tuote::hakutuloksia($hakusana);

$sivuja = ceil($tuotteita/$montako);

naytaNakyma("lista.php", array('tuotteet' => $tuotteet, 'hakusana' => $hakusana, 'sivu' => $sivu, 'montako' => $montako, 'tuotteita' => $tuotteita, 'sivuja' => $sivuja));
//naytaNakyma("lista.php", array('tuotteet' => $tuotteet, 'hakusana' => $hakusana,'tuotteita' => $tuotteita));  

    