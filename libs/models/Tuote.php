<?php

require_once 'libs/tietokanta.php';

class Tuote {

    private $tuoteId;
    private $tuoteryhmaId;
    private $nimi;
    private $hinta;
    private $kuvaus;

    public static function lukumaara() {
        $sql = "SELECT count(*) FROM Tuote";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        return $kysely->fetchColumn();
    }

    public static function hae($hakusana, $sivu, $montako) {
        if ($hakusana == null) {
            $sql = "SELECT * from Tuote ORDER BY nimi";
        } else {
//            $sql = "SELECT * FROM Tuote WHERE nimi LIKE '%$hakusana%' OR kuvaus LIKE '%$hakusana%' LIMIT ?, ?  ORDER BY nimi";
            $sql = "SELECT * FROM Tuote WHERE nimi LIKE '%$hakusana%' OR kuvaus LIKE '%$hakusana%' ORDER BY nimi";
        }
        $kysely = getTietokantayhteys()->prepare($sql);
//        $kysely->execute(array($montako, ($sivu-1)*$montako));
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Tuote::tuloksenKasittely($tulos);
        }
        return $tulokset;
    }

    public static function tuloksenKasittely($tulos) {
        $tuote = new Tuote();
        $tuote->setTuoteId($tulos->tuoteId);
        $tuote->setTuoteryhmaId($tulos->tuoteryhmaId);
        $tuote->setNimi($tulos->nimi);
        $tuote->setHinta($tulos->hinta);
        $tuote->setKuvaus($tulos->kuvaus);
        return $tuote;
    }

    public static function etsi($tuoteId) {
        $sql = "SELECT * from Tuote where tuoteId = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tuoteId));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $tuote = new Tuote();
            $tuote->setTuoteId($tulos->tuoteId);
            $tuote->setTuoteryhmaId($tulos->tuoteryhmaId);
            $tuote->setNimi($tulos->nimi);
            $tuote->setHinta($tulos->hinta);
            $tuote->setKuvaus($tulos->kuvaus);

            return $tuote;
        }
    }

    public function getTuoteId() {
        return $this->tuoteId;
    }

    public function getTuoteryhmaId() {
        return $this->tuoteryhmaId;
    }

    public function getNimi() {
        return $this->nimi;
    }

    public function getHinta() {
        return $this->hinta;
    }

    public function getKuvaus() {
        return $this->kuvaus;
    }

    public function setTuoteId($tuoteId) {
        $this->tuoteId = $tuoteId;
    }

    public function setTuoteryhmaId($tuoteryhmaId) {
        $this->tuoteryhmaId = $tuoteryhmaId;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
    }

    public function setHinta($hinta) {
        $this->hinta = $hinta;
    }

    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
    }

}
