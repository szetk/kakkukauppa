<h3>Käyttäjät</h3>
<h4><?php echo "Käyttäjiä yhteensä: ", $data->kayttajia; ?> </h4>
<form class="form-horizontal" role="form" action="kayttajat.php" method="POST">

    <table>
        <thead>
            <tr>
                <th style="width:80px">Id</th>
                <th style="width:200px">Sahkoposti</th>
                <th style="width:200px">Nimi</th>
                <th style="width:120px">Kayttajatyyppi</th>
                <th style="width:50px">Poista</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data->kayttajat as $kayttaja): ?>
                <tr>
                    <td><?php echo $kayttaja->getKayttajaId(); ?></td>
                    <td><?php echo $kayttaja->getSahkoposti(); ?></td>
                    <td><?php echo $kayttaja->getEtunimi(), " ", $kayttaja->getSukunimi(); ?></td>
                    <td>
                        <select name="kayttajatyypit[]">
                            <option value="asiakas" <?php if($kayttaja->getKayttajaTyyppi() == 'asiakas'){echo 'selected="selected"';} ?>>asiakas</option>
                            <option value="tyontekija" <?php if($kayttaja->getKayttajaTyyppi() == 'tyontekija'){echo 'selected="selected"';} ?>>tyontekija</option>
                            <option value="admin" <?php if($kayttaja->getKayttajaTyyppi() == 'admin'){echo 'selected="selected"';} ?>>admin</option>
                        </select>
                        <!--<input type="number" class="form-control" name="kayttajatyypit[]" value=<?php echo $kayttaja->getKayttajaTyyppi(); ?>>-->
                  </td>
                    <td><h3><a href="kayttajat.php?poista=<?php echo $kayttaja->getKayttajaId(); ?>">X</a></h3></td>
            <input type="hidden" name="kayttajat[]" value=<?php echo $kayttaja->getKayttajaId(); ?>>

            </tr>
        <?php endforeach; ?>


  
        </tbody>

    </table>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <h4>
                <button type="submit" class="btn btn-default">Tallenna muutokset</button>
            </h4>
        </div>
    </div>

</form>

<?php if ($data->sivu > 1): ?>
    <a href="kayttajat.php?sivu=<?php echo $data->sivu - 1; ?>">Edellinen sivu</a>
<?php endif; ?>
<?php if ($data->sivu < $data->sivuja): ?>
    <a href="kayttajat.php?sivu=<?php echo $data->sivu + 1; ?>">Seuraava sivu</a>
<?php endif; ?>