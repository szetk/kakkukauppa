<?php

require_once 'libs/tietokanta.php';

class Tuoteryhma {

    private $nimi;
    private $tuoteryhmaId;

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
    
    public static function getTuoteryhmienNimet(){
        $ryhmat = Tuoteryhma::getTuoteryhmat();
        $array = array();
        foreach ($ryhmat as $ryhma){
            $array[] = $ryhma->getNimi();
        }
        return $array;
    }

    public static function haeTuoteryhmaId($nimi){
        $sql = "SELECT tuoteryhmaId from Tuoteryhma where nimi like ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($nimi));
        $tulos = $kysely->fetchObject();
        return $tulos->tuoteryhmaId;
    }
    
    public static function haeTuoteryhmaNimi($tuoteryhmaId){
        $sql = "SELECT nimi from Tuoteryhma where tuoteryhmaId like ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tuoteryhmaId));
        $tulos = $kysely->fetchObject();
        return $tulos->nimi;
    }
    
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
