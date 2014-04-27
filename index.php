<?php

require_once 'libs/common.php';

// kuinka monta suosikkituotetta halutaan
$montako = 3;

// haetaan suosikkituotteet tietokannasta
$tuotteet = Tuote::haeSuosikit($montako);

// annetaan suosikkituotteet näyttämissivulle, ja asetetaan etusivulta, jotta index.php:sta kutsuttu lista.php tietää mitä tekee
naytaNakyma("index.php", array('tuotteet' => $tuotteet, 'etusivulta' => "etusivulta"));