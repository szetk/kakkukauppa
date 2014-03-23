<?php

class Kayttaja {

    private $id;
    private $tunnus;
    private $salasana;

    public function __construct($id, $tunnus, $salasana) {
        $this->id = $id;
        $this->tunnus = $tunnus;
        $this->salasana = $salasana;
    }

    public function getId() {
        return $this->id;
    }

    function getTunnus() {
        return $this->tunnus;
    }

    function getSalasana() {
        return $this->salasana;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTunnus($tunnus) {
        $this->tunnus = $tunnus;
    }

    function setSalasana($salasana) {
        $this->salasana = $salasana;
    }

}
