<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';
include 'libs/models/Tuote.php';

// kuinka monta suosikkituotetta halutaan
$montako = 3;

// haetaan suosikkituotteet tietokannasta
$tuotteet = Tuote::haeSuosikit($montako);

// annetaan suosikkituotteet näyttämis sivulle
naytaNakyma("index.php", array('tuotteet' => $tuotteet));