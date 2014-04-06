<?php

function getTietokantayhteys() {
  static $yhteys = null; //Muuttuja, jonka sisältö säilyy getTietokantayhteys-kutsujen välillä.
 
  if ($yhteys === null) { 
    $yhteys = new PDO('mysql:unix_socket=/home/samkorho/mysql/socket;dbname=kakkukauppa', 'root', 'root');
    $yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  return $yhteys;
}

function getKayttajat() {
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
