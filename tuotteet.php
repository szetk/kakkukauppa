<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';
include 'libs/models/Tuoteryhma.php';

$tuoteryhmat = Tuoteryhma::getTuoteryhmienNimet();
naytaNakyma("tuotteet.php", array('tuoteryhmat' => $tuoteryhmat));