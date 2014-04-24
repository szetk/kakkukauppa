<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <table style="width:1000px">
            <tr>
                <td style="width:100px"></td>
                <td>

                    <h1>Kakkukaupan verkkokauppa</h1>
                    <?php
                    if (onKirjautunut()) {
                        $kayttaja = haeKayttaja();
                        echo 'Hei <a href="omaSivu.php">', $kayttaja->getEtunimi(), '! </a>';
                        if (Kayttaja::onTyontekija($kayttaja)) {
                            echo "Olet kirjautunut sisään työntekijänä. Käyttäjätyyppisi on ", $kayttaja->getKayttajatyyppi();
                        } else {
                            echo 'Olet kirjautunut sisään sähköpostilla ', $kayttaja->getSahkoposti(), "<br>";
                        }
                    } else {
                        echo 'Hei vierailija! Voit <a href="login.php">kirjautua sisään</a>, tai jos et ole rekisteröitynyt vielä, voit rekisteröityä <a href="register.php">tästä</a> <br>';
                    }
                    ?>
                    <nav class="navbar navbar-default" role="navigation">
                        <div class="container-fluid">
                            
                            <form class="navbar-form navbar-left" role="search" action="lista.php" method="GET">
                                <div class="form-group">
                                    <input type="text" name ="hakusana" class="form-control" placeholder="Hakusana">
                                </div>
                                <button type="submit" class="btn btn-default">Hae</button>
                            </form>

                            <ul class="nav navbar-nav">

                                <li <?php
                                if ($sivu == 'index.php') {
                                    echo 'class="active"';
                                }
                                ?>><a href="index.php">Etusivu</a></li>
                                <li <?php
                                if ($sivu == 'tuotteet.php') {
                                    echo 'class="active"';
                                }
                                ?>><a href="tuotteet.php">Tuotteet</a></li>
                                <li <?php
                                if ($sivu == 'yhteystiedot.php') {
                                    echo 'class="active"';
                                }
                                ?>><a href="yhteystiedot.php">Yhteystiedot</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li <?php
                                if ($sivu == 'ostoskori.php') {
                                    echo 'class="active"';
                                }
                                ?>><a href="ostoskori.php">Ostoskori</a></li>
                                <li <?php
                                if ($sivu == 'login.php') {
                                    echo 'class="active"';
                                }
                                ?>>
                                    <a href="login.php"><?php
                                        if (onKirjautunut()) {
                                            echo "Kirjaudu ulos";
                                        } else {
                                            echo "Kirjaudu sisään";
                                        }
                                        ?></a>
                                </li>
                            </ul>
                        </div> 
                    </nav>
                </td>
            </tr>
        </table>

        <table style="width:900px">
            <tr>
                <td style="width:200px"></td>
                <td>
                    <?php if (isset($data->virheet)): ?>
                        <?php foreach ($data->virheet as $virhe): ?>
                            <div class="alert alert-danger"><?php echo $virhe; ?></div>
                        <?php endforeach ?>
                    <?php endif; ?>
                    <!--        <!-- sisältö tulee tähän kohtaan -->

                    <?php
                    require 'views/' . $sivu;
                    ?>
                </td>
            </tr>


        </table>



    </body>
</html>