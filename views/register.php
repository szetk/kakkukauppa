<form class="form-horizontal" role="form" action="login.php" method="POST">
    <div class="form-group">
        <label for="inputEtunimi" class="col-md-2 control-label">Etunimi</label>
        <div class="col-md-10">
            <input type="text" class="form-control" id="inputEtunimi" name="etunimi" value="<?php echo $data->kayttaja; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="inputEmail1" class="col-md-2 control-label">Sähköposti</label>
        <div class="col-md-10">
            <input type="email" class="form-control" id="inputEmail1" name="email" value="<?php echo $data->kayttaja; ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword1" class="col-md-2 control-label">Salasana</label>
        <div class="col-md-10">
            <input type="password" class="form-control" id="inputPassword1" name="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <button type="submit" class="btn btn-default">Rekisteröidy</button>
        </div>
    </div>
</form>