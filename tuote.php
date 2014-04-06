<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';
include 'libs/models/Tuote.php';


$id = (int) $_GET['id'];

$tuote = Tuote::etsi($id);


if ($tuote == null) {
    naytaNakyma('tuote.php', array('virhe' => "Tuotetta ei löytynyt!", 'tuote' => null));
} else {
    naytaNakyma('tuote.php', array('tuote' => $tuote));
}