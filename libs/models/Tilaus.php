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
    private $maksutapa;

// Tämä hakee parametrinä saadun käyttäjän avoimen tilauksen, eli ostoskorin. Käyttäjällä voi olla vain yksi avoin tilaus kerrallaan.
    public static function haeAvoinTilaus($kayttaja) {
        $sql = "SELECT * FROM Tilaus WHERE tilausvaihe LIKE 'avoin' and kayttajaId LIKE ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja->getKayttajaId()));
        $tulos = $kysely->fetchObject();
        return Tilaus::tuloksenKasittely($tulos);
    }

    // Tämä päivittää tilauksen, jonka tilausId on annetun tilaus-tyyppisen parametrin tilausId
    public static function paivitaTilaus($tilaus) {
        $toimituspaiva = date('Y-m-d', strtotime($tilaus->getToimituspaiva()));
        $sql = "UPDATE Tilaus SET toimitustapa = ?, maksutapa = ?, toimituspaiva = ?, tilausvaihe = ?, kayttajaId = ? WHERE tilausId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilaus->getToimitustapa(), $tilaus->getMaksutapa(), $toimituspaiva, $tilaus->getTilausvaihe(), $tilaus->getKayttajaId(), $tilaus->getTilausId()));
    }

    // Tämä hakee tilauksen tietokannasta parametrinä saadun tilausId:n perusteella
    public static function haeTilausId($tilausId) {
        $sql = "SELECT * FROM Tilaus WHERE tilausId = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilausId));
        $tulos = $kysely->fetchObject();
        return Tilaus::tuloksenKasittely($tulos);
    }

// Tämä palauttaa avoimen tilauksen (eli ostoskorin), jota verkkokaupan käyttäjä voi käyttää ostoskorina.
    public static function getTilaus() {
        session_start();
        if (isset($_SESSION['tilaus'])) {
            $tilaus = $_SESSION['tilaus'];
        } else if (onKirjautunut()) {
            $kayttaja = haeKayttaja();
            $tilaus = Tilaus::haeAvoinTilaus($kayttaja);
            if ($tilaus == null) {
                $tilaus = Tilaus::uusiTilaus($kayttaja);
            }
            Tilaus::asetaTilausSessioon($tilaus);
        } else {
            $tilaus = Tilaus::uusiTilaus(null);
            Tilaus::asetaTilausSessioon($tilaus);
        }
        return $tilaus;
    }

// Tämä palauttaa parametrinä saadun tilaukseen liittyvät tuotteet, eli tilauksen tuotteet ja määrät
    public static function getTilausTuotteet($tilaus) {
        $sql = "SELECT * FROM TilausTuote WHERE tilausId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilaus->getTilausId()));
        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[$tulos->tuoteId] = $tulos->maara;
        }
        return $tulokset;
    }

// Tämä päivittää parametrinä saatuun tilaukseen parametrinä saadut tuotteiden määrät tuoteId:n perusteella
    public static function paivitaMaara() {
        $tilaus = func_get_arg(0);
        $tuoteId = func_get_arg(1);
        $maara = func_get_arg(2);
        if ($maara == null || $maara < 0) {
            return;
        } else if ($maara == 0) {
            Tilaus::poistaTuote($tilaus, $tuoteId);
            return;
        }
        $sql = "UPDATE TilausTuote SET maara = ? WHERE tilausId = ? AND tuoteId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($maara, $tilaus->getTilausId(), $tuoteId));
    }

// Tämä poistaa parametrinä saadusta tilauksesta parametrinä annetun tuotteen tuoteId:n perusteella
    public static function poistaTuote() {
        $tilaus = func_get_arg(0);
        $tuoteId = func_get_arg(1);
        $sql = "DELETE FROM TilausTuote WHERE tilausId = ? AND tuoteId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilaus->getTilausId(), $tuoteId));
    }

//    public static function poistaTilaus($tilaus){
//        
// Tämä tyhjentää koko ostoskorin, eli tilauksen sisällön (ei poista ostoskoria)
    public static function tyhjennaOstoskori($tilaus) {
        $sql = "DELETE FROM TilausTuote WHERE tilausId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilaus->getTilausId()));
        $tilaus->setTuotteet(null);
    }

// Tämä lisää parametrinä saatuun tilaukseen, parametrina saadun määrn parametrinä saatua tuotetta tuoteId:n perusteella
    public static function lisaaOstoskoriin() {
        $tilaus = func_get_arg(0);
        $tuoteId = func_get_arg(1);
        $maara = func_get_arg(2);
        if ($maara == null || $maara <= 0) {
            return;
        }
        // Jos ostoskorista löytyy jo tuotetta, muutetaan tietokantaan uusi määrä (aiemmat + juuri lisätyt)
        foreach (Tilaus::getTilausTuotteet($tilaus) as $tId => $m) {
            if ($tuoteId == $tId) {
                Tilaus::paivitaMaara($tilaus, $tuoteId, $maara + $m);
                return;
            }
        }
        $sql = "INSERT INTO TilausTuote(tilausId, tuoteId, maara) VALUES(?, ?, ?)";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tilaus->getTilausId(), $tuoteId, $maara));
    }

// Tämä luo käyttäjälle uuden tilauksen, käytännössä ostoskorin
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

// Tämä tekee tietokantakyselyn palauttamasta PDO tuloksesta tilauksen
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
            $tilaus->setMaksutapa($tulos->maksutapa);
            return $tilaus;
        }
    }

// Tämä asettaa sessioon tilauksen
    public static function asetaTilausSessioon($tilaus) {
        $_SESSION['tilaus'] = $tilaus;
    }

// getterit ja setterit

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

    public function getMaksutapa() {
        return $this->maksutapa;
    }

    public function setMaksutapa($maksutapa) {
        $this->maksutapa = $maksutapa;
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
