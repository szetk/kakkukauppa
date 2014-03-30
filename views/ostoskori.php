
<h3>Ostoskorisi:</h3>

<form class="form-horizontal" role="form" action="index.html" method="POST">

    <table>
        <thead>
            <tr>
                <th>Tuote</th>
                <th style="width:100px">Hinta</th>
                <th style="width:100px">Määrä</th>
                <th style="width:100px">Yhteensä</th>
                <th style="width:50px"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="kakku.png" alt="..."> 
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">Geneerinen kakku 666</h4>
                            <h5>Lorem ipsum dolor sit amet, consectetur adipisci elit, 
                                sed eiusmod tempor incidunt ut labore et dolore magna aliqua. </h5>
                        </div>
                    </div>
                </td>
                <td>48,00 EUR</td>
                <td><input type="number" class="form-control" id="maara1" name="maara" placeholder="1"></td>
                <td>48,00 EUR</td>
                <td><h3><a href="#">X</a></h3></td>

            </tr>
            <tr style="height:15px"></tr>
            <tr>
                <td>
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="kakku.png" alt="..."> 
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">Geneerinen kakku 420</h4>
                            <h5>Lorem ipsum dolor sit amet, consectetur adipisci elit, 
                                sed eiusmod tempor incidunt ut labore et dolore magna aliqua. </h5>
                        </div>
                    </div>
                </td>
                <td>4,20 EUR</td>
                <td><input type="number" class="form-control" id="maara1" name="maara" placeholder="1"></td>
                <td>4,20 EUR</td>
                <td><h3><a href="#">X</a></h3></td>

            </tr>
            <tr style="height:30px">
                <td></td>
                <td></td>
                <td>yhteensä</td>
                <td>50,20 EUR</td>
                <td></td>
            </tr>
        </tbody>

    </table>
</form>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10">
        <h4>
            <button type="submit" class="btn btn-default">Tallenna muutokset</button>
            <a href="kassa.html">Kassalle</a> 
        </h4>
    </div>
</div>