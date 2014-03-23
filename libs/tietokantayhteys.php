<?php
function getTietokantayhteys() {
  static $yhteys = null; //Muuttuja, jonka sisältö säilyy getTietokantayhteys-kutsujen välillä.
 
  if ($yhteys === null) { 
    $yhteys = new PDO('mysql:unix_socket=/home/samkorho/mysql/socket;dbname=kakkukauppa', 'root', 'root');
    $yhteys->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  }

  return $yhteys;
}
