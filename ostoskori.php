<?php

require_once 'libs/common.php';

// haetaan avoin tilaus, eli ostoskori
$tilaus = Tilaus::getTilaus();

// yksittäisen tuotteen poisto tapahtuu GET-tyyppisellä kutsulla (koska näkymäsivulla käytetty linkkiä)
if (!empty($_GET['poista'])) {
    Tilaus::poistaTuote($tilaus, $_GET['poista']);
}

// jos on asetettu parametri tyhjenna, niin tyhjennetään ostoskori
if (!empty($_POST['tyhjenna'])) {
    Tilaus::tyhjennaOstoskori($tilaus);
    $tilaus->setTuotteet(Tilaus::getTilausTuotteet($tilaus));
    naytaNakyma("ostoskori.php", array('tilaus' => $tilaus));
}

// selvitetään ja käsitellään taulukot ostoskorin tuotteista ja määristä
if (!empty($_POST['maarat']) && !empty($_POST['tuotteet'])) {
    $tuotteet = $_POST['tuotteet'];
    $maarat = $_POST['maarat'];
    foreach ($tuotteet as $key => $tuote) {
        // ostoskorin (tilauksen) määrät päivitetään yksitellen
        Tilaus::paivitaMaara($tilaus, $tuote, $maarat[$key]);
    }
}

// haetaan tilaukselle tuotteet tietokannasta
$tilaus->setTuotteet(Tilaus::getTilausTuotteet($tilaus));


if (empty($_POST['tuoteId'])) {
    naytaNakyma("ostoskori.php", array('tilaus' => $tilaus));
}
$tuoteId = $_POST["tuoteId"];

if (empty($_POST["maara"])) {
    naytaNakyma("ostoskori.php", array('tilaus' => $tilaus));
}

// tarkistetaan, että määrässä on vain numeroita, poikkeustilanteessa palaudutaan tuotteen sivulle
$maara = $_POST["maara"];
$virheet = Tuote::tarkistaMaara($maara);
if (!empty($virheet)) {
    naytaNakyma('tuote.php', array('tuote' => Tuote::etsi($tuoteId), 'maara' => $maara, 'virheet' => $virheet));
} else {
    Tilaus::lisaaOstoskoriin($tilaus, $tuoteId, $maara);
    $tilaus->setTuotteet(Tilaus::getTilausTuotteet($tilaus));
}


naytaNakyma("ostoskori.php", array('tilaus' => $tilaus));
