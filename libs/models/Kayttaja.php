<?php

require_once 'libs/tietokanta.php';

class Kayttaja {

    private $kayttajaId; //tullaan päivittämään käyttäjäId:ksi ensi viikolla
    private $sahkoposti;
    private $salasana;
    private $etunimi;
    private $sukunimi;
    private $puhelin;
    private $osoite;
    private $postinumero;
    private $posti;
    private $kayttajaTyyppi; // muuttuja käyttäjätyyppejä (asiakas, admin, tyontekija) varten

    // Hakee tietokannasta käyttäjän sähköpostin ja salasanan perusteella 
    public static function etsiKayttajaTunnuksilla($sahkoposti, $salasana) {
        $sql = "SELECT * from Kayttaja where sahkoposti = ? AND salasana = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sahkoposti, $salasana));
        $tulos = $kysely->fetchObject();
        if ($tulos == null) {
            return null;
        } else {
            $kayttaja = new Kayttaja();
            $kayttaja->setKayttajaId($tulos->kayttajaId);
            $kayttaja->setSahkoposti($tulos->sahkoposti);
            $kayttaja->setSalasana($tulos->salasana);
            $kayttaja->setEtunimi($tulos->etunimi);
            $kayttaja->setSukunimi($tulos->sukunimi);
            $kayttaja->setPuhelin($tulos->puhelin);
            $kayttaja->setOsoite($tulos->osoite);
            $kayttaja->setPostinumero($tulos->postinumero);
            $kayttaja->setPosti($tulos->posti);
            $kayttaja->setKayttajaTyyppi($tulos->kayttajaTyyppi);
            return $kayttaja;
        }
    }
    
    // Lisää käyttäjän tietokantaan. Huomioi, että kayttaja:n soveltuvuus on varmistettava ennen funktion kutsua.
    public static function lisaaKayttaja($kayttaja) {
        $kentat = array(
            $kayttaja->etunimi,
            $kayttaja->sukunimi,
            $kayttaja->sahkoposti,
            $kayttaja->puhelin,
            $kayttaja->osoite,
            $kayttaja->posti,
            $kayttaja->postinumero,
            $kayttaja->salasana);

        $sql = "INSERT INTO Kayttaja(etunimi, sukunimi, sahkoposti, puhelin, osoite, posti, postinumero, salasana, kayttajaTyyppi) VALUES(?, ?, ?, ?, ?, ?, ?, ?, 'asiakas')";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute($kentat);
    }

    // Päivittää tietokantaan käyttäjän tiedot. Huomioi, että kayttaja täytyy tarkistaa ennen funktion kutsua.
    public static function paivitaKayttaja($kayttaja) {
        $kentat = array(
            $kayttaja->etunimi,
            $kayttaja->sukunimi,
            $kayttaja->sahkoposti,
            $kayttaja->puhelin,
            $kayttaja->osoite,
            $kayttaja->posti,
            $kayttaja->postinumero,
            $kayttaja->salasana,
            $kayttaja->kayttajaId);

        $sql = "UPDATE Kayttaja SET etunimi = ?, sukunimi = ?, sahkoposti = ?, puhelin = ?, osoite = ?, posti = ?, postinumero = ?, salasana = ? WHERE kayttajaId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute($kentat);
    }

    // Selvittää onko parametrinä annetulla sähköpostilla olemassa jo käyttäjä
    public static function onkoSahkopostiRekisteroity($sahkoposti) {
        $sql = "SELECT count(*) from Kayttaja where sahkoposti = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sahkoposti));
        $tulos = $kysely->fetchColumn();
        if ((int) $tulos > 0) {
            return true;
        }
        return false;
    }

// Takistaa, että onko parametrinä annettu käyttäjä soveltuva tietokantaan. Tämän monsteriluokan voisi jakaa pienempiin luokkiin.
    // Totuusarvoista parametriä reg käytetään, jotta tiedämme tarkistetaanko onko sähköposti jo käytössä. Sähköpostin olemassaoloa ei tule tarkistaa kun esimerkiksi käyttäjä muokkaa omia tietojaan.
    public static function kelpaakoKayttajaksi($kayttaja, $reg) {
        $virheet = array();

        // Tässä käydään käyttäjän muuttujat yksitellen läpi, ja lisätään virheet-listaan virheet
        $tutkittava = $kayttaja->etunimi;
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut etunimeä";
        } else if (strlen($tutkittava) < 3 || strlen($tutkittava) > 80) {
            $virheet[] = "Etunimen tulee olla 3-80 merkkiä pitkä";
        } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $tutkittava)) {
            $virheet[] = "Antmasi etunimi sisältää kiellettyjä erikoismerkkejä";
        }

        $tutkittava = $kayttaja->sukunimi;
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut sukunimeä";
        } else if (strlen($tutkittava) < 3 || strlen($tutkittava) > 80) {
            $virheet[] = "Sukunimen tulee olla 3-80 merkkiä pitkä";
        } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $tutkittava)) {
            $virheet[] = "Antmasi sukunimi sisältää kiellettyjä erikoismerkkejä";
        }

        $tutkittava = $kayttaja->sahkoposti;
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut sähköpostia";
        } else if (strlen($tutkittava) < 5 || strlen($tutkittava) > 80) {
            $virheet[] = "Sähköpostin tulee olla 5-80 merkkiä pitkä";
        } else if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $tutkittava)) {
            $virheet[] = "Sähköpostin tulee olla muotoa xxx@xxx.xx ja sisältää vain sallitutja merkkejä";
        } else if ($reg) {
            if (Kayttaja::onkoSahkopostiRekisteroity($tutkittava)) {
                $virheet[] = "Sähköpostilla on jo käyttäjätunnus";
            }
        }

        $tutkittava = $kayttaja->salasana;
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut salasanaa";
        } else if (strlen($tutkittava) < 4 || strlen($tutkittava) > 30) {
            $virheet[] = "Salasanan tulee olla 4-30 merkkiä pitkä";
        }

        $tutkittava = $kayttaja->puhelin;
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut puhelinnumeroa";
        } else if (strlen($tutkittava) < 3 || strlen($tutkittava) > 15) {
            $virheet[] = "Puhelinnumeron tulee olla 4-15 merkkiä pitkä";
        } else if (!preg_match("#^[0-9+]+$#", $tutkittava)) {
            $virheet[] = "Puhelinnumeroon kelpaavat numerot, ja +-merkki";
        }

        $tutkittava = $kayttaja->osoite;
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut osoitetta";
        } else if (strlen($tutkittava) < 3 || strlen($tutkittava) > 80) {
            $virheet[] = "Osoitteen tulee olla 3-80 merkkiä pitkä";
        } else if (preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬]/', $tutkittava)) {
            $virheet[] = "Antmasi osoite sisältää kiellettyjä erikoismerkkejä";
        }

        $tutkittava = $kayttaja->posti;
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut paikkakuntaa";
        } else if (strlen($tutkittava) < 3 || strlen($tutkittava) > 80) {
            $virheet[] = "Paikkakunnan tulee olla 3-80 merkkiä pitkä";
        } else if (preg_match('/[\'^£$%&*()}{#~?><>,|=_+¬]/', $tutkittava)) {
            $virheet[] = "Antmasi paikkakunta sisältää kiellettyjä erikoismerkkejä";
        }

        $tutkittava = $kayttaja->postinumero;
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut postinumeroa";
        } else if (strlen($tutkittava) != 5) {
            $virheet[] = "Postinumeron tulee olla 5 merkkiä pitkä";
        } else if (!preg_match("#^[0-9]+$#", $tutkittava)) {
            $virheet[] = "Postinumero saa sisältää vain numeroita";
        }


        return $virheet;
    }

    public function getKayttajaId() {
        return $this->kayttajaId;
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

    public function getKayttajaTyyppi() {
        return $this->kayttajaTyyppi;
    }

    public function setKayttajaId($kayttajaId) {
        $this->kayttajaId = $kayttajaId;
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

    public function setKayttajaTyyppi($kayttajaTyyppi) {
        $this->kayttajaTyyppi = $kayttajaTyyppi;
    }

}
