<?php

require_once 'libs/common.php';

// haetaan pyynnöstä id, jos sitä ei ole se on null
$id = (int) $_GET['id'];

// haetaan id:n perusteella tuote, joka on null, mikäli sitä ei löydy
$tuote = Tuote::etsi($id);

// tarkastellaan tilanne
if ($tuote == null) {
    naytaNakyma('tuote.php', array('virheet' => array("Tuotetta ei löytynyt!"), 'tuote' => null));
} else {
    naytaNakyma('tuote.php', array('tuote' => $tuote));
}