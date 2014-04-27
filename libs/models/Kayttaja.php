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
    private $paikkakunta;
    private $kayttajaTyyppi; // muuttuja käyttäjätyyppejä (asiakas, admin, tyontekija) varten

    // Tämä hakee kaikki käyttäjät tietokannasta, ja sivuttaa ne
    public static function haeKaikki() {
        $montako = func_get_arg(0);
        $sivu = (func_get_arg(1) - 1)*$montako;
        $sql = "SELECT * from Kayttaja ORDER BY kayttajaId LIMIT $sivu, $montako";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        $kayttajat = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $kayttajat[] = Kayttaja::tuloksenKasittely($tulos);
        }
        return $kayttajat;
    }

    // Tämä laskee kuinka monta käyttäjää tietokannasta löytyy, jotta voidaan sivuttaa tulokset
    public static function kayttajia() {
        $sql = "SELECT count(*) FROM Kayttaja";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        return $kysely->fetchColumn();
    }
    
    // Tämä tarkastaa onko käyttäjä työntekijä vai ei. Palautetaan true mikäli kayttaja on työntekijä
    public static function onTyontekija($kayttaja){
        return ($kayttaja->getKayttajaTyyppi() == 'admin' || $kayttaja->getKayttajaTyyppi() == 'tyontekija');
    }

    // Tämä päivittää kayttajan käyttäjätyypiksi parametrina saadun kayttajatyypin
    public static function paivitaKayttajaTyyppi() {
        $kayttaja = func_get_arg(0);
        $kayttajatyyppi = func_get_arg(1);
        $sql = "UPDATE Kayttaja SET kayttajaTyyppi = ? WHERE kayttajaId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajatyyppi, $kayttaja));
    }
    
    // Tämä saa parametrinä käyttäjän tunnuksen (kayttajaId) ja poistaa käyttäjän sen perusteella
    public static function poistaKayttaja() {
        $kayttaja = func_get_arg(0);
        $sql = "DELETE FROM Kayttaja WHERE kayttajaId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttaja));
    }
    
    // Tämä käsittelee hakutuloksia niin, että yhdestä hakutulosrivistä muodostetaan yksi käyttäjä, joka palautetaan
    public static function tuloksenKasittely($tulos) {
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
            $kayttaja->setPaikkakunta($tulos->paikkakunta);
            $kayttaja->setKayttajaTyyppi($tulos->kayttajaTyyppi);
            return $kayttaja;
        }
    }

    // Hakee tietokannasta käyttäjän sähköpostin ja salasanan perusteella 
    public static function etsiKayttajaTunnuksilla($sahkoposti, $salasana) {
        $sql = "SELECT * from Kayttaja where sahkoposti = ? AND salasana = BINARY ? LIMIT 1"; //BINARY:n vuoksi otetaan merkkikoko huomioon
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sahkoposti, $salasana));
        $tulos = $kysely->fetchObject();
        return Kayttaja::tuloksenKasittely($tulos);
    }
    
    // Hakee käyttäjän tietokannasta pelkästään käyttäjätunnuksen, kayttajaId, perusteella
    public static function etsiKayttajaIdlla($kayttajaId) {
        $sql = "SELECT * from Kayttaja where kayttajaId = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($kayttajaId));
        $tulos = $kysely->fetchObject();
        return Kayttaja::tuloksenKasittely($tulos);
    }

    // Lisää käyttäjän tietokantaan. Huomioi, että kayttaja:n soveltuvuus on varmistettava ennen funktion kutsua.
    public static function lisaaKayttaja($kayttaja) {
        $kentat = array(
            $kayttaja->etunimi,
            $kayttaja->sukunimi,
            $kayttaja->sahkoposti,
            $kayttaja->puhelin,
            $kayttaja->osoite,
            $kayttaja->paikkakunta,
            $kayttaja->postinumero,
            $kayttaja->salasana);

        $sql = "INSERT INTO Kayttaja(etunimi, sukunimi, sahkoposti, puhelin, osoite, paikkakunta, postinumero, salasana, kayttajaTyyppi) VALUES(?, ?, ?, ?, ?, ?, ?, ?, 'asiakas')";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute($kentat);
        
        return getTietokantayhteys()->lastInsertId();
    }

    // Päivittää tietokantaan käyttäjän tiedot. Huomioi, että kayttaja täytyy tarkistaa ennen funktion kutsua.
    public static function paivitaKayttaja($kayttaja) {
        $kentat = array(
            $kayttaja->etunimi,
            $kayttaja->sukunimi,
            $kayttaja->sahkoposti,
            $kayttaja->puhelin,
            $kayttaja->osoite,
            $kayttaja->paikkakunta,
            $kayttaja->postinumero,
            $kayttaja->salasana,
            $kayttaja->kayttajaId);

        $sql = "UPDATE Kayttaja SET etunimi = ?, sukunimi = ?, sahkoposti = ?, puhelin = ?, osoite = ?, paikkakunta = ?, postinumero = ?, salasana = ? WHERE kayttajaId = ?";
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
    // Jos käyttäjä muokkaa omia tietojaan, annetaan parametrin omatSivut arvoksi true, jolloin ei tarkisteta sähköpostin olemassaoloa
    public static function kelpaakoKayttajaksi($kayttaja, $omatSivut) {
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
        } else if (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/', $tutkittava)) {
            $virheet[] = "Sähköpostin tulee olla muotoa xxx@xxx.xx ja sisältää vain sallitutja merkkejä";
        } else {
            if (!$omatSivut && Kayttaja::onkoSahkopostiRekisteroity($tutkittava)) {
                $virheet[] = 'Sähköpostilla on jo olemassa <a href="login.php">käyttäjätunnus</a>';
            }
        }
        
        $tutkittava = $kayttaja->salasana;
        if (empty($tutkittava)) {
            $virheet[] = "Et antanut salasanaa";
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

        $tutkittava = $kayttaja->paikkakunta;
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

    public function getPaikkakunta() {
        return $this->paikkakunta;
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

    public function setPaikkakunta($paikkakunta) {
        $this->paikkakunta = $paikkakunta;
    }

    public function setKayttajaTyyppi($kayttajaTyyppi) {
        $this->kayttajaTyyppi = $kayttajaTyyppi;
    }

}
