<h3>Rekisteröityminen </h3>
<form class="form-horizontal" role="form" action="register.php" method="POST">
    <div class="form-group">
        <label class="col-md-2 control-label">Etunimi</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="etunimi" value="<?php echo htmlspecialchars($data->kayttaja->getEtunimi()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Sukunimi</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="sukunimi" value="<?php echo htmlspecialchars($data->kayttaja->getSukunimi()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Sähköposti</label>
        <div class="col-md-6">
            <input type="email" class="form-control" name="sahkoposti" value="<?php echo htmlspecialchars($data->kayttaja->getSahkoposti()); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Puhelinnumero</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="puhelin" value="<?php echo htmlspecialchars($data->kayttaja->getPuhelin()); ?>">
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">Katuosoite</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="osoite" value="<?php echo htmlspecialchars($data->kayttaja->getOsoite()); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">Postinumero</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="postinumero" value="<?php echo htmlspecialchars($data->kayttaja->getPostinumero()); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">Paikkakunta</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="posti" value="<?php echo htmlspecialchars($data->kayttaja->getPosti()); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">Salasana</label>
    <div class="col-md-6">
        <input type="password" class="form-control" name="salasana1">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">Vahvista salasana</label>
    <div class="col-md-6">
        <input type="password" class="form-control" name="salasana2" >
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-2 col-md-6">
        <button type="submit" class="btn btn-default">Rekisteröidy</button>
    </div>
</div>
</form>