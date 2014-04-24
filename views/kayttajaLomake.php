<div class="form-group">
    <label class="col-md-3 control-label">Etunimi</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="etunimi" value="<?php echo $data->kayttaja->getEtunimi(); ?>" <?php if ($data->readonly){echo 'readonly="readonly"';}?>>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Sukunimi</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="sukunimi" value="<?php echo $data->kayttaja->getSukunimi(); ?>" <?php if ($data->readonly){echo 'readonly="readonly"';}?>>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Sähköposti</label>
    <div class="col-md-6">
        <input type="email" class="form-control" name="sahkoposti" value="<?php echo $data->kayttaja->getSahkoposti(); ?>" <?php if ($data->readonly){echo 'readonly="readonly"';}?>>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Puhelinnumero</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="puhelin" value="<?php echo $data->kayttaja->getPuhelin(); ?>" <?php if ($data->readonly){echo 'readonly="readonly"';}?>>
    </div>
</div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Katuosoite</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="osoite" value="<?php echo $data->kayttaja->getOsoite(); ?>" <?php if ($data->readonly){echo 'readonly="readonly"';}?>>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Postinumero</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="postinumero" value="<?php echo $data->kayttaja->getPostinumero(); ?>" <?php if ($data->readonly){echo 'readonly="readonly"';}?>>
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Paikkakunta</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="paikkakunta" value="<?php echo $data->kayttaja->getPaikkakunta(); ?>" <?php if ($data->readonly){echo 'readonly="readonly"';}?>>
    </div>
</div>