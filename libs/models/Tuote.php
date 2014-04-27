<?php

require_once 'libs/tietokanta.php';

class Tuote {

    private $tuoteId;
    private $tuoteryhmaId;
    private $nimi;
    private $hinta;
    private $kuvaus;
    private $kuva;

    // Tämä tarkastaa onko parametrinä saatu tuote sopiva tuotteeksi 
    public static function kelpaakoTuotteeksi($tuote) {
        $virheet = array();

        $tutkittava = $tuote->getNimi();
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut nimeä";
        } else if (strlen($tutkittava) < 3 || strlen($tutkittava) > 80) {
            $virheet[] = "Nimen tulee olla 3-80 merkkiä pitkä";
        } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $tutkittava)) {
            $virheet[] = "Antmasi nimi sisältää kiellettyjä erikoismerkkejä";
        }

        $tutkittava = $tuote->getHinta();
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut hintaa";
        } else if ($tutkittava < 0 || $tutkittava > 99999999.99) {
            $virheet[] = "Hinnan tulee olla positiivinen ja korkeintaan 99999999.99";
        } else if (!preg_match("#^[0-9.]+$#", $tutkittava)) {
            $virheet[] = "Sallitut merkit ovat numerot ja .-merkki. Hinta tulee syöttää kahden desimaalin tarkkuudella. Esim. 123.23";
        }

        $tutkittava = $tuote->getKuvaus();
        if (strlen($tutkittava) > 3000) {
            $virheet[] = "Kuvauksen tulee olla korkeintaan 3000 merkkiä pitkä";
        } else if (preg_match('/[\'^£$&}{@#~><>|=_+¬]/', $tutkittava)) {
            $virheet[] = "Antmasi kuvaus sisältää kiellettyjä erikoismerkkejä";
        }

        $tutkittava = $tuote->getKuva();
        if (strlen($tutkittava) > 20) {
            $virheet[] = "Kuvatiedostossa saa olla korkeintaan 20-merkkiä";
        } else if ($tutkittava != null && !preg_match('/(\[a-z0-9-]+)*(\.(png|jpg)){1}$/', $tutkittava)) {
            $virheet[] = "Sallitut merkit ovat pienet merkit välillä a-z, numerot ja .-merkki. Muoto esimerkiksi: kakku12.png. Sallitut formaatit ovat png ja jpg";
        }

        return $virheet;
    }

    public static function tarkistaMaara($maara) {
        $virheet = array();
        if (!preg_match("#^[0-9]+$#", $maara)) {
            $virheet[] = "Määrässa saa olla vain numeroita";
        } else if ($maara > 100) {
            $virheet[] = "Et saa tilata liikaa kakkuja";
        }
        return $virheet;
    }

    // Lisää parametrinä saadun tuotteen tietokantaan
    public static function lisaaTuote($tuote) {
        $kentat = array(
            $tuote->nimi,
            $tuote->hinta,
            $tuote->tuoteryhmaId,
            $tuote->kuvaus);

        $sql = "INSERT INTO Tuote(nimi, hinta, tuoteryhmaId, kuvaus) VALUES(?, ?, ?, ?)";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute($kentat);

        return getTietokantayhteys()->lastInsertId();
    }

    // Tämä päivittää tuotteen tiedot. Tietokannasta haetaan tuote, jolla on parametrinä saadun tuotteen tuoteId, joka sitten muutetaan
    public static function paivitaTuote($tuote) {
        $kentat = array(
            $tuote->nimi,
            $tuote->hinta,
            $tuote->tuoteryhmaId,
            $tuote->kuvaus,
            $tuote->kuva,
            $tuote->tuoteId);

        $sql = "UPDATE Tuote SET nimi = ?, hinta = ?, tuoteryhmaId = ?, kuvaus = ?, kuva = ? WHERE tuoteId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute($kentat);
    }

// Tämä hake tietokannasta sivun tuloksia hakusanalla. Parametreinä annetaan myös sivun numero ja tuotteiden määrä sivulla
    public static function hae() {
        $hakusana = func_get_arg(0);
        $montako = func_get_arg(1);
        $sivu = (func_get_arg(2) - 1) * $montako;
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

    // Hakee sivullisen tuotteita, jotka kuuluvat parametrina saatuun tuoteryhmään, tuoteryhma on siis tuoteyhmaId
    public static function haeTuoteryhmanTuotteet() {
        $tuoteryhma = func_get_arg(0);
        $montako = func_get_arg(1);
        $sivu = (func_get_arg(2) - 1) * $montako;
        $sql = "SELECT * FROM Tuote WHERE tuoteryhmaId = ? ORDER BY nimi LIMIT $sivu, $montako";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tuoteryhma));

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Tuote::tuloksenKasittely($tulos);
        }
        return $tulokset;
    }

    // Laskee kuinka monta tuotetta tietystä tuoteryhmästä löytyy, jotta sivuttaminen onnistuu
    public static function tuoteryhmassaTuotteita($tuoteryhma) {
        $sql = "SELECT count(*) FROM Tuote WHERE tuoteryhmaId LIKE ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tuoteryhma));
        return $kysely->fetchColumn();
    }

// Tämä käsittelee PDO:n kautta saadun tuloksen, ja palauttaa tuotteen. Tätä kutsutaan monissa tietokantahakuihin liittyvissä funktioissa.
    public static function tuloksenKasittely($tulos) {
        if ($tulos == null) {
            return null;
        } else {
            $tuote = new Tuote();
            $tuote->setTuoteId($tulos->tuoteId);
            $tuote->setTuoteryhmaId($tulos->tuoteryhmaId);
            $tuote->setNimi($tulos->nimi);
            $tuote->setHinta($tulos->hinta);
            $tuote->setKuvaus($tulos->kuvaus);
            $tuote->setKuva($tulos->kuva);
            return $tuote;
        }
    }

// Tämä palauttaa tietokannasta tuoteId:tä vastaavan tuotteen
    public static function etsi($tuoteId) {
        $sql = "SELECT * from Tuote where tuoteId = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tuoteId));
        $tulos = $kysely->fetchObject();
        return Tuote::tuloksenKasittely($tulos);
    }

    // Poistaa tietokannasta tuotteen, jolla on tuoteId tuoteId:na
    public static function poista($tuoteId) {
        $sql = "DELETE from Tuote where tuoteId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tuoteId));
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

    public function getKuva() {
        return $this->kuva;
    }

    public function setKuva($kuva) {
        $this->kuva = $kuva;
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
