<?php

require_once 'libs/common.php';
include 'libs/models/Kayttaja.php';

if (onKirjautunut()) {
    naytaNakyma("omaSivu.php");
} else {
    ohjaaSivulle("login.php");
}