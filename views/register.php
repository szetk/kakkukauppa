<h3>Rekisteröityminen </h3>
<form class="form-horizontal" role="form" action="register.php" method="POST">
    <?php
    require 'views/kayttajaLomake.php';
    ?>
    <div class="form-group">
        <label class="col-md-3 control-label">Salasana</label>
        <div class="col-md-6">
            <input type="password" class="form-control" name="salasana1">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label">Vahvista salasana</label>
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