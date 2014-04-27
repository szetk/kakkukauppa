<?php

require_once 'libs/common.php';


$sivu = 1;
if (isset($_GET['sivu'])) {
    $sivu = (int) $_GET['sivu'];

//Sivunumero ei saa olla pienempi kuin yksi
    if ($sivu < 1) {
        $sivu = 1;
    }
}
$montako = 5; // Otetaan vain muutama suosikki, kun on kuitenkin vain etusivu

// jos pyyntöön on asetettu parametri tuoteryhma, listataan tähän tuoteryhmään kuuluvat tuotteet
if (isset($_GET['tuoteryhma'])) {
    $tuoteryhma = $_GET['tuoteryhma'];
    $tuotteet = Tuote::haeTuoteryhmanTuotteet($tuoteryhma, $montako, $sivu);
    $tuotteita = Tuote::tuoteryhmassaTuotteita($tuoteryhma);

    $sivuja = ceil($tuotteita / $montako);
    naytaNakyma("lista.php", array('tuotteet' => $tuotteet, 'tuoteryhma' => Tuoteryhma::haeTuoteryhmaNimi($tuoteryhma), 'sivu' => $sivu, 'montako' => $montako, 'tuotteita' => $tuotteita, 'sivuja' => $sivuja));

    // muutoin tarkastetaan hakusana
} else { 
    $hakusana = null;
    if (isset($_GET['hakusana'])) {
        $hakusana = $_GET['hakusana'];
    }
    $tuotteet = Tuote::hae($hakusana, $montako, $sivu);
    $tuotteita = Tuote::hakutuloksia($hakusana);

    $sivuja = ceil($tuotteita / $montako);
    naytaNakyma("lista.php", array('tuotteet' => $tuotteet, 'hakusana' => $hakusana, 'sivu' => $sivu, 'montako' => $montako, 'tuotteita' => $tuotteita, 'sivuja' => $sivuja));
}


    