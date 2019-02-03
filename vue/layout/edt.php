<!doctype html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <title>Application - Emploi du temps</title>
   <link rel="stylesheet" type="text/css" href="./vue/style/bootstrap.css" />
   <link rel="stylesheet" type="text/css" href="./vue/style/style.css" />
   <link rel="stylesheet" type="text/css" href="./vue/style/normalize.css" />
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
      crossorigin="anonymous">
   <script src="./vue/scripts/jquery-3.3.1.min.js"></script>
   <script src="./vue/scripts/bootstrap.js"></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
   <script src="./vue/scripts/script2.js"></script>

</head>
<!-- BODY -->

<body>
    <div class="container">
    <?php require('require/options.php');?> 
        <div class="row">
          <div class="col-md-6">
              <div class="row">
                <div class="zone col-md-6" id="btns">
                    <i class="fas fa-trash-alt" style="font-size:48px;"></i>
                </div>
              </div>
              <div class="zone" id="edt">
                <div class="row" id="H">
                    <div class="cellules titre silver" id="titre">
                      <p class="barre"></p>
                      <p class="hautD">Périodes</p>
                      <p class="basG">Modules</p>
                    </div>
                </div>
                <div class="row cptV" id="total_periode">
                    <div class="cellules silver" id="lineTot">
                      <p><b>Total/Période</b></p>
                    </div>
                </div>
              </div>
          </div>
        </div>
    </div>

</body>
</html>