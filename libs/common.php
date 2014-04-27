<?php

include_once 'libs/models/Tuote.php';
include_once 'libs/models/Tuoteryhma.php';
include 'libs/models/Tilaus.php';
include_once 'libs/models/Kayttaja.php';


// Tämä sisällyttää pohjan, jonka päälle tulaa parametrina saatu sivu. Lisäksi otetaan koppi mahdollisesta datasta(kuten virheilmoitukset),joka välitetään eteenpäin.
function naytaNakyma($sivu, $data = array()) {
    $data = (object) $data;
    require 'views/pohja.php';
    exit();
}

// Tämä ohjaa suoraan sivulle, eli yleisesti kontrolleriin
function ohjaaSivulle($sivu) {
    header("Location: $sivu");
}

// Käynnistää session, mikäli sellaista ei vielä ole käynnistetty
function kaynnistaSessio() {
    if (session_id() == '') {
        session_start();
    }
}

// Tarkistaa onko käyttäjä kirjautunut
function onKirjautunut() {
    // Täytyy käynnistää sessio, siltä varalta, että sitä ei ole käynnissä
    kaynnistaSessio();

    if (isset($_SESSION['kirjautunut'])) {
        return true;
    }
    return false;
}

// Tämä kryptaa salasanan yksinkertaisella hashilla. Dekryptaukselle ei ole ollut tarvetta.
function kryptaa($salasana){
    return hash("sha512", $salasana);
}

// Hakee sessioon kirjatun käyttäjän, tätä ennen tulee ohjelmassa tarkistaa, onko käyttäjä kirjautunut vai ei
function haeKayttaja() {
    kaynnistaSessio();
    $k = $_SESSION['kirjautunut'];
    return $k;
}

// Kirjautuu sisään, eli asettaa sessioon käyttäjän
function kirjauduSisaan($k) {
    kaynnistaSessio();
    unset($_SESSION['tilaus']); // poistetaan aiempi tilaus sessiosta, jotta tulee oikea ostoskori
    $_SESSION['kirjautunut'] = $k;
}

// Kirjautuu ulos, eli asettaa käyttäjän pois sessiosta
function kirjauduUlos() {
    kaynnistaSessio();
    if (!onKirjautunut()) {
    }
    unset($_SESSION['kirjautunut']);
    unset($_SESSION['tilaus']);
}
