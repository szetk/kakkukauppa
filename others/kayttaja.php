<?php

require_once "../libs/tietokanta.php";

class Kayttaja {

    private $id;
    private $tunnus;
    private $salasana;

    public function __construct($id, $tunnus, $salasana) {
        $this->id = $id;
        $this->tunnus = $tunnus;
        $this->salasana = $salasana;
    }

    function getKayttajat() {
        $yhteys = getTietokantayhteys();
        $sql = "SELECT kayttajaId AS id,sahkoposti AS tunnus, salasana FROM Kayttaja";

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

    public function getId() {
        return $this->id;
    }

    function getTunnus() {
        return $this->tunnus;
    }

    function getSalasana() {
        return $this->salasana;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    function setSalasana($salasana) {
        $this->salasana = $salasana;
    }

}
