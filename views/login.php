<h3>Kirjautuminen </h3>
<form class="form-horizontal" role="form" action="login.php" method="POST">
    <div class="form-group">
        <label for="inputEmail1" class="col-md-2 control-label">Sähköposti</label>
        <div class="col-md-6">
            <input type="email" class="form-control" id="inputEmail1" name="email" value="<?php echo htmlspecialchars($data->kayttaja); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword1" class="col-md-2 control-label">Salasana</label>
        <div class="col-md-6">
            <input type="password" class="form-control" id="inputPassword1" name="password" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-6">
            <button type="submit" class="btn btn-default">Kirjaudu sisään</button>
        </div>
    </div>
</form>
Etkö ole vielä rekisteröitynyt? <a href="register.php">Rekisteröidy tästä</a>
