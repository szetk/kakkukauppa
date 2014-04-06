<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';
include 'libs/models/Tuote.php';


//$sivu = 1;
//if (isset($_GET['sivu'])) {
//    $sivu = (int) $_GET['sivu'];
//
//    //Sivunumero ei saa olla pienempi kuin yksi
//    if ($sivu < 1)
//        $sivu = 1;
//}
//$montako = 2;

$hakusana = $_GET['hakusana'];
$tuotteet = Tuote::hae($hakusana, $sivu, $montako);

//$tuotteita = Tuote::lukumaara();
$tuotteita = count($tuotteet);

//$sivuja = ceil($tuotteita / $montako);

naytaNakyma("lista.php", array('tuotteet' => $tuotteet, 'hakusana' => $hakusana, 'sivu' => $sivu, 'montako' => $montako,'tuotteita' => $tuotteita));
//naytaNakyma("lista.php", array('tuotteet' => $tuotteet, 'hakusana' => $hakusana,'tuotteita' => $tuotteita));
