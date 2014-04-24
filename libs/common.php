<?php

// Näyttämiseen liittyvät funktiot

function naytaNakyma($sivu, $data = array()) {
    $data = (object) $data;
    require 'views/pohja.php';
    exit();
}

function ohjaaSivulle($sivu) {
    header("Location: $sivu");
}

// Kirjautuneeseen käyttäjään liittyvät funktiot

function kaynnistaSessio() {
    if (session_id() == '') {
        session_start();
    }
}

function onKirjautunut() {
    kaynnistaSessio();

    if (isset($_SESSION['kirjautunut'])) {
        return true;
    }
    return false;
}

function kryptaa($salasana){
    return hash("sha512", $salasana);
}

function haeKayttaja() {
    kaynnistaSessio();
    $k = $_SESSION['kirjautunut'];
    return $k;
}

function kirjauduSisaan($k) {
    kaynnistaSessio();
    unset($_SESSION['tilaus']); // poistetaan aiempi tilaus sessiosta
    $_SESSION['kirjautunut'] = $k;
}

function kirjauduUlos() {
    kaynnistaSessio();
    if (!onKirjautunut()) {
    }
    unset($_SESSION['kirjautunut']);
    unset($_SESSION['tilaus']);
}
