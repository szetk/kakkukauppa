<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';
include 'libs/models/Tuote.php';
include 'libs/models/Tuoteryhma.php';


$sivu = 1;
if (isset($_GET['sivu'])) {
    $sivu = (int) $_GET['sivu'];

//Sivunumero ei saa olla pienempi kuin yksi
    if ($sivu < 1) {
        $sivu = 1;
    }
}
$montako = 3; // Tämä voisi olla toki enemmänkin, mutta toistaiseksi tuotteita on niin vähän

if (isset($_GET['tuoteryhma'])) {
    $tuoteryhma = $_GET['tuoteryhma'];
    $tuotteet = Tuote::haeTuoteryhmanTuotteet($tuoteryhma, $montako, $sivu);
    $tuotteita = Tuote::tuoteryhmassaTuotteita($tuoteryhma);

    $sivuja = ceil($tuotteita / $montako);
    naytaNakyma("lista.php", array('tuotteet' => $tuotteet, 'tuoteryhma' => Tuoteryhma::haeTuoteryhmaNimi($tuoteryhma), 'sivu' => $sivu, 'montako' => $montako, 'tuotteita' => $tuotteita, 'sivuja' => $sivuja));
} else {
    if (isset($_GET['hakusana'])) {
        $hakusana = $_GET['hakusana'];
    }
    $hakusana = null;
    $tuotteet = Tuote::hae($hakusana, $montako, $sivu);
    $tuotteita = Tuote::hakutuloksia($hakusana);

    $sivuja = ceil($tuotteita / $montako);
    naytaNakyma("lista.php", array('tuotteet' => $tuotteet, 'hakusana' => $hakusana, 'sivu' => $sivu, 'montako' => $montako, 'tuotteita' => $tuotteita, 'sivuja' => $sivuja));
}


    