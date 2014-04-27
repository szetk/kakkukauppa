<?php

require_once 'libs/tietokanta.php';

class Tuoteryhma {

    private $nimi;
    private $tuoteryhmaId;

    // Hakee kaikki tuoteryhmät ja palauttaa ne listana
    public static function getTuoteryhmat() {
        $sql = "SELECT * from Tuoteryhma ORDER BY tuoteryhmaId";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tulokset[] = Tuoteryhma::tuloksenKasittely($tulos);
        }
        return $tulokset;
    }
    
    // Palauttaa listana kaikkien tuoteryhmien nimet
    public static function getTuoteryhmienNimet(){
        $ryhmat = Tuoteryhma::getTuoteryhmat();
        $array = array();
        foreach ($ryhmat as $ryhma){
            $array[] = $ryhma->getNimi();
        }
        return $array;
    }

    // Hakee nimen perusteella tuoteryhmän tuoteryhmaId:n
    public static function haeTuoteryhmaId($nimi){
        $sql = "SELECT tuoteryhmaId from Tuoteryhma where nimi like ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($nimi));
        $tulos = $kysely->fetchObject();
        return $tulos->tuoteryhmaId;
    }
    
    // Hakee tuoteryhmaId:n perusteella tuoteryhmän nimen
    public static function haeTuoteryhmaNimi($tuoteryhmaId){
        $sql = "SELECT nimi from Tuoteryhma where tuoteryhmaId like ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tuoteryhmaId));
        $tulos = $kysely->fetchObject();
        return $tulos->nimi;
    }
    
    // Käsittelee tietokantahaun tuloksen. Tulos on yksi rivi tietokannasta, josta muodostetaan yksi tuoteryhma
    public static function tuloksenKasittely($tulos) {
        if ($tulos == null) {
            return null;
        } else {
            $tuoteryhma = new Tuoteryhma();
            $tuoteryhma->setNimi($tulos->nimi);
            $tuoteryhma->setTuoteryhmaId($tulos->tuoteryhmaId);
            return $tuoteryhma;
        }
    }

    // getterit ja setterit
    
    public function getNimi() {
        return $this->nimi;
    }

    public function getTuoteryhmaId() {
        return $this->tuoteryhmaId;
    }

    public function setNimi($nimi) {
        $this->nimi = $nimi;
    }

    public function setTuoteryhmaId($tuoteryhmaId) {
        $this->tuoteryhmaId = $tuoteryhmaId;
    }


}
