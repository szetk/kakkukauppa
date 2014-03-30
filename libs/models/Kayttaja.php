<?php

require 'libs/tietokanta.php';

class Kayttaja {

    private $asiakasId; //tullaan päivittämään käyttäjäId:ksi ensi viikolla
    private $sahkoposti;
    private $salasana;
    private $etunimi;
    private $sukunimi;
    private $puhelin;
    private $osoite;
    private $postinumero;
    private $posti;
    //private $kayttajaTyyppi tullaan lisäämään muuttuja käyttäjätyyppejä (asiakas, työntekijä) varten

    public static function etsiKayttajaTunnuksilla($kayttaja, $salasana) {
        $sql = "SELECT asiakasId, sahkoposti, salasana, osoite, etunimi, sukunimi, puhelin, postinumero, posti from Asiakas where sahkoposti = ? AND salasana = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja, $salasana));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $kayttaja = new Kayttaja();
            $kayttaja->setAsiakasId($tulos->asiakasId);
            $kayttaja->setSahkoposti($tulos->sahkoposti);
            $kayttaja->setSalasana($tulos->salasana);
            $kayttaja->setEtunimi($tulos->etunimi);
            $kayttaja->setSukunimi($tulos->sukunimi);
            $kayttaja->setPuhelin($tulos->puhelin);
            $kayttaja->setOsoite($tulos->osoite);
            $kayttaja->setPostinumero($tulos->postinumero);
            $kayttaja->setPosti($tulos->posti);
            return $kayttaja;
        }
    }

    public function getAsiakasId() {
        return $this->asiakasId;
    }

    public function getSahkoposti() {
        return $this->sahkoposti;
    }

    public function getSalasana() {
        return $this->salasana;
    }

    public function getEtunimi() {
        return $this->etunimi;
    }

    public function getSukunimi() {
        return $this->sukunimi;
    }

    public function getPuhelin() {
        return $this->puhelin;
    }

    public function getOsoite() {
        return $this->osoite;
    }

    public function getPostinumero() {
        return $this->postinumero;
    }

    public function getPosti() {
        return $this->posti;
    }

    public function setAsiakasId($asiakasId) {
        $this->asiakasId = $asiakasId;
    }

    public function setSahkoposti($sahkoposti) {
        $this->sahkoposti = $sahkoposti;
    }

    public function setSalasana($salasana) {
        $this->salasana = $salasana;
    }

    public function setEtunimi($etunimi) {
        $this->etunimi = $etunimi;
    }

    public function setSukunimi($sukunimi) {
        $this->sukunimi = $sukunimi;
    }

    public function setPuhelin($puhelin) {
        $this->puhelin = $puhelin;
    }

    public function setOsoite($osoite) {
        $this->osoite = $osoite;
    }

    public function setPostinumero($postinumero) {
        $this->postinumero = $postinumero;
    }

    public function setPosti($posti) {
        $this->posti = $posti;
    }





}
