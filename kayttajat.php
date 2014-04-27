<?php

require_once 'libs/common.php';

// mikäli pyyntöön on asetettu muuttuja poista, hautaan poistaa käyttäjä
if (isset($_GET['poista'])){  
    Kayttaja::poistaKayttaja($_GET['poista']);
}

// jos on asetettu listat kayttajat ja kayttajatyypit voidaan muokata näiden käyttäjätyypit
if (isset($_POST['kayttajatyypit']) && isset($_POST['kayttajat'])) {
    $kayttajat = $_POST['kayttajat'];
    $kayttajatyypit = $_POST['kayttajatyypit'];
    foreach ($kayttajat as $key => $kayttaja) {
        // ostoskorin (tilauksen) määrät päivitetään yksitellen
        Kayttaja::paivitaKayttajatyyppi($kayttaja, $kayttajatyypit[$key]);
        }
}



$sivu = 1;
if (isset($_GET['sivu'])) {
    $sivu = (int) $_GET['sivu'];

//Sivunumero ei saa olla pienempi kuin yksi
    if ($sivu < 1) {
        $sivu = 1;
    }
}
$montako = 7; // Tämä voisi olla toki enemmänkin tai valittavissa, mutta toistaiseksi tuotteita on niin vähän

$kayttajat = Kayttaja::haeKaikki($montako, $sivu);
$kayttajia = Kayttaja::kayttajia();

$sivuja = ceil($kayttajia / $montako);

naytaNakyma("kayttajat.php", array('kayttajat' => $kayttajat, 'sivu' => $sivu, 'montako' => $montako, 'kayttajia' => $kayttajia, 'sivuja' => $sivuja));
//naytaNakyma("lista.php", array('tuotteet' => $tuotteet, 'hakusana' => $hakusana,'tuotteita' => $tuotteita));  

    