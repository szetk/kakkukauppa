<?php

require_once 'libs/tietokanta.php';

class Tuote {

    private $tuoteId;
    private $tuoteryhmaId;
    private $nimi;
    private $hinta;
    private $kuvaus;

// Tämä hake tietokannasta sivun tuloksia hakusanalla. Parametreinä annetaan myös sivun numero ja tuotteiden määrä sivulla
    public static function hae() {
        $hakusana = func_get_arg(0);
        $sivu = func_get_arg(1) - 1;
        $montako = func_get_arg(2);
        $hakuparametri = "%$hakusana%";
        if ($hakusana == null) {
            $sql = "SELECT * from Tuote ORDER BY nimi LIMIT $sivu, $montako";
        } else {
            $sql = "SELECT * FROM Tuote WHERE nimi LIKE ? OR kuvaus LIKE ? ORDER BY nimi LIMIT $sivu, $montako";
        }
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($hakuparametri, $hakuparametri));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Tuote::tuloksenKasittely($tulos);
        }
        return $tulokset;
    }

// Tämä hakee tietokannasta eniten tilatut (tai ostoskoriin kerätyt) tuotteet. Parametrinä haluttujen tulosten määrä
    public static function haeSuosikit($montako) {
        $sql = "SELECT Tuote.*, sum(maara) AS sum FROM TilausTuote INNER JOIN Tuote WHERE Tuote.tuoteId = TilausTuote.tuoteId GROUP BY tuoteId ORDER BY sum DESC LIMIT 0, $montako";
//        $sql = "SELECT Tuote.*, sum(maara) AS sum FROM TilausTuote INNER JOIN Tuote WHERE Tuote.tuoteId = TilausTuote.tuoteId GROUP BY tuoteId";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Tuote::tuloksenKasittely($tulos);
        }
        return $tulokset;
    }

// Tämä käsittelee PDO:n kautta saadun tuloksen, ja palauttaa tuotteen. Tätä kutsutaan monissa tietokantahakuihin liittyvissä funktioissa.
    public static function tuloksenKasittely($tulos) {
        $tuote = new Tuote();
        $tuote->setTuoteId($tulos->tuoteId);
        $tuote->setTuoteryhmaId($tulos->tuoteryhmaId);
        $tuote->setNimi($tulos->nimi);
        $tuote->setHinta($tulos->hinta);
        $tuote->setKuvaus($tulos->kuvaus);
        return $tuote;
    }

// Tämä palauttaa tietokannasta tuoteId:tä vastaavan tuotteen
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

// Tämä selvittää kuinka monta hakutulosta löydetään tietyllä hakusanalla. Tätä hyödynnetään hakutulosten sivuttamisessa.
    public static function hakutuloksia($hakusana) {
        $hakuparametri = "%$hakusana%";
        if ($hakusana == null) {
            $sql = "SELECT count(*) FROM Tuote";
        } else {
            $sql = "SELECT count(*) FROM Tuote WHERE nimi LIKE ? OR kuvaus LIKE ?";
        }
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($hakuparametri, $hakuparametri));
        return $kysely->fetchColumn();
    }

// getterit ja setterit

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
