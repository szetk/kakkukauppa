<?php
require_once "kayttaja.php";
require_once "libs/tietokanta.php";

$lista = getKayttajat();
//$lista = array("Kirahvi", "Trumpetti", "Jeesus", "Parta");
?><!DOCTYPE HTML>
<html>
    <head><title>Otsikko</title></head>
    <body>
        <h1>Listaelementtitesti</h1>
            <ul>
            <?php foreach ($lista as $asia) { ?>
                    <li><?php echo $asia->getId(), " ", $asia->getTunnus(), $asia->getId(), " ", $asia->getSalasana(); ?></li>
            <?php } ?>
        </ul>
    </body>
</html>
