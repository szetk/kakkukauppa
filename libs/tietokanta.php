<?php

function getKayttajat() {
    $sql = "SELECT asiakasId AS id, sahkoposti AS tunnus, salasana FROM Asiakas";
    $yhteys = new PDO('mysql:unix_socket=/home/samkorho/mysql/socket;dbname=kakkukauppa', 'root', 'root');
    $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $kysely = $yhteys->prepare($sql);
    $kysely->execute();
    $tulokset = array();
    foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
        $kayttaja = new Kayttaja();
        $kayttaja->setId($tulos->id);
        $kayttaja->setTunnus($tulos->tunnus);
        $kayttaja->setSalasana($tulos->salasana);
            $tulokset[] = $kayttaja;
    }
    return $tulokset;
}
