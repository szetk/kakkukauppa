<?php

require_once 'libs/tietokanta.php';
require_once 'Tuote.php';

class Tilaus {

    private $tilausId;
    private $kayttajaId;
    private $tilausvaihe;
    private $tilauspaiva;
    private $toimituspaiva;
    private $toimitustapa;
    private $tuotteet;

    public static function getTilaus() {
        session_start();
        if (onKirjautunut()) {
            $kayttaja = haeKayttaja();
            $tilaus = Tilaus::haeAvoinTilaus($kayttaja);
            if ($tilaus == null) {
                $tilaus = Tilaus::uusiTilaus($kayttaja);
            }
            Tilaus::asetaTilaus($tilaus);
        } else if (isset($_SESSION['tilaus'])) {
            $tilaus = $_SESSION['tilaus'];
        } else {
            $tilaus = Tilaus::uusiTilaus(null);
            Tilaus::asetaTilaus($tilaus);
        }
        return $tilaus;
    }

    // vähän ostoskorifunktioita
    public static function getTilausTuotteet($tilaus) {
        $sql = "SELECT * FROM TilausTuote WHERE tilausId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilaus->getTilausId()));
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
//            $arr = array($tulos->tuoteId, $tulos->maara);
            $tulokset[$tulos->tuoteId] = $tulos->maara;
//            $tulokset[] = $arr;
        }
        return $tulokset;
    }

    public static function paivitaMaarat() {
        $tilaus = func_get_arg(0);
        $tuoteId = func_get_arg(1);
        $maara = func_get_arg(2);
        if ($maara == null || $maara <= 0) {
            return;
        }
        $sql = "UPDATE TilausTuote SET maara = ? WHERE tilausId = ? AND tuoteId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($maara, $tilaus->getTilausId(), $tuoteId));
    }

    public static function poistaTuote() {
        $tilaus = func_get_arg(0);
        $tuoteId = func_get_arg(1);
        $sql = "DELETE FROM TilausTuote WHERE tilausId = ? AND tuoteId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilaus->getTilausId(), $tuoteId));
    }

    public static function tyhjennaOstoskori($tilaus) {
        $sql = "DELETE FROM TilausTuote WHERE tilausId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilaus->getTilausId()));
        $tilaus->setTuotteet(null);
    }

    public static function lisaaOstoskoriin() {
        $tilaus = func_get_arg(0);
        $tuoteId = func_get_arg(1);
        $maara = func_get_arg(2);
        if ($maara == null || $maara <= 0) {
            return;
        }
//        if (korissaTuote($tuoteId)){
//            update
//        }
        $sql = "INSERT INTO TilausTuote(tilausId, tuoteId, maara) VALUES(?, ?, ?)";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilaus->getTilausId(), $tuoteId, $maara));
    }

    // jotain muita funktioita
    public static function uusiTilaus($kayttaja) {
        if ($kayttaja != null) {
            $sql = "INSERT INTO Tilaus(tilausvaihe, kayttajaId) VALUES('avoin', ?)";
            $kysely = getTietokantayhteys()->prepare($sql);
            $kysely->execute(array($kayttaja->getKayttajaId()));
        } else {
            $sql = "INSERT INTO Tilaus(tilausvaihe) VALUES('avoin')";
            $kysely = getTietokantayhteys()->prepare($sql);
            $kysely->execute();
        }
        $tilausId = getTietokantayhteys()->lastInsertId();

        return Tilaus::haeTilausId($tilausId);
    }

    public static function asetaTilaus($tilaus) {
        $_SESSION['tilaus'] = $tilaus;
    }

    public static function tuloksenKasittely($tulos) {
        if ($tulos == null) {
            return null;
        } else {
            $tilaus = new Tilaus();
            $tilaus->setTilausId($tulos->tilausId);
            $tilaus->setKayttajaId($tulos->kayttajaId);
            $tilaus->setTilausvaihe($tulos->tilausvaihe);
            $tilaus->setTilauspaiva($tulos->tilauspaiva);
            $tilaus->setToimituspaiva($tulos->toimituspaiva);
            $tilaus->setToimitustapa($tulos->toimitustapa);
            return $tilaus;
        }
    }

    public static function haeAvoinTilaus($kayttaja) {
        $sql = "SELECT * FROM Tilaus WHERE tilausvaihe LIKE 'avoin' and kayttajaId LIKE ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja->getKayttajaId()));
        $tulos = $kysely->fetchObject();
        return Tilaus::tuloksenKasittely($tulos);
    }

    public static function haeTilausId($tilausId) {
        $sql = "SELECT * FROM Tilaus WHERE tilausId = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilausId));
        $tulos = $kysely->fetchObject();
        return Tilaus::tuloksenKasittely($tulos);
    }

    public function getTilausId() {
        return $this->tilausId;
    }

    public function getKayttajaId() {
        return $this->kayttajaId;
    }

    public function getTilausvaihe() {
        return $this->tilausvaihe;
    }

    public function getTilauspaiva() {
        return $this->tilauspaiva;
    }

    public function getToimituspaiva() {
        return $this->toimituspaiva;
    }

    public function getToimitustapa() {
        return $this->toimitustapa;
    }

    public function getTuotteet() {
        return $this->tuotteet;
    }

    public function setTilausId($tilausId) {
        $this->tilausId = $tilausId;
    }

    public function setKayttajaId($kayttajaId) {
        $this->kayttajaId = $kayttajaId;
    }

    public function setTilausvaihe($tilausvaihe) {
        $this->tilausvaihe = $tilausvaihe;
    }

    public function setTilauspaiva($tilauspaiva) {
        $this->tilauspaiva = $tilauspaiva;
    }

    public function setToimituspaiva($toimituspaiva) {
        $this->toimituspaiva = $toimituspaiva;
    }

    public function setToimitustapa($toimitustapa) {
        $this->toimitustapa = $toimitustapa;
    }

    public function setTuotteet($tuotteet) {
        $this->tuotteet = $tuotteet;
    }

}
