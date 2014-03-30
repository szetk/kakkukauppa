<?php

// Näyttämiseen liittyvät funktiot

function naytaNakyma($sivu, $data = array()) {
    $data = (object) $data;
    require 'views/pohja.php';
    exit();
}

function ohjaaSivulle($sivu){
    header("Location: $sivu");
}


// Kirjautuneeseen käyttäjään liittyvät funktiot

function onKirjautunut() {
    session_start();

    if (isset($_SESSION['kirjautunut'])) {
        return true;
    }
    return false;
}

function haeKayttaja(){
    $k = $_SESSION['kirjautunut'];
    return $k;
}

function kirjauduUlos() {
    session_start();
    unset($_SESSION['kirjautunut']);
}


