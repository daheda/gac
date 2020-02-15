<!DOCTYPE html>
<html>
<head>
    <title>GAC - Tickets appels</title>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">
    <script type="text/javascript" src="js/upload.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">GAC - Tickets appels</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</nav>
<main role="main" class="container">
  <div class="starter-template">
    <div class="row"> <div class="col"><pre id="message"></pre> </div></div>
    <div class="row">
    
        <div class="col">
            <div class="card">
                <h4>1 - Import :</h4>
                <hr/>
                <div class="form-group">
                    <label for="csv">Veuillez selectionner le fichier à Importer.</label>
                    <input type="file" class="form-control-file" id="csv" accept=".csv,text/csv">
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" id="envoyer" onclick="sendAction()">Importer</button>
                </div>
            </div>
            
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <h4>2 - Exploiter les données : </h4>
                <hr/>
                <p>
                  <ul>
                  <li>Rapport 1 : Retrouver la durée totale réelle des appels effectués après le 15/02/2012 (inclus)</li>
                  <li>Rapport 2 : Retrouver le TOP 10 des volumes data facturés en dehors de la tranche horaire 8h00-
18h00, par abonné</li>
                  <li>Rapport 3 : Retrouver la quantité totale de SMS envoyés par l'ensemble des abonnés</li>
                  </ul>
                </p>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary mr-2" onclick="report('report-a')">Rapport 1</button>
                    <button type="button" class="btn btn-primary mr-2" onclick="report('report-b')">Rapport 2</button>
                    <button type="button" class="btn btn-primary mr-2" onclick="report('report-c')">Rapport 3</button>
                </div>
            </div>
            
        </div>
    </div>
    <div class="row"> <div class="col"><pre id="report"></pre> </div></div>
    
  </div>
</main>
</body>
</html>