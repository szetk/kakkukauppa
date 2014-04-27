<?php

require_once 'libs/common.php';

// haetaan lista tuoteryhmistä, ja näytetään sivu
$tuoteryhmat = Tuoteryhma::getTuoteryhmienNimet();
naytaNakyma("tuotteet.php", array('tuoteryhmat' => $tuoteryhmat));