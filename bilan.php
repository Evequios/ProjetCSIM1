<?php
include('db.php');
$liste = pg_query($conn, "SELECT * FROM bilan WHERE idauteur = '$id' AND typeauteur = '$type' ORDER BY idbilan DESC");

if(isset($_POST['créerBilan'])){
  if($type == 'administrateur'){
    $garage = $_POST['inputGarage'];
  }
  if($type == 'garage') {
    $garage = $id;
  }
  $debut = $_POST['inputDébut'];
  $fin = $_POST['inputFin'];
  $nbdepots = pg_fetch_array(pg_query($conn, 
  "SELECT COUNT(idoffre) FROM offre 
  WHERE datepublicationoffre >= '$debut' AND datepublicationoffre <= '$fin' AND offre.garage = $garage"))[0];

  $nbventes = pg_fetch_array(pg_query($conn, 
  "SELECT COUNT(idoffre) FROM offre 
  WHERE datevente >= '$debut' AND datevente <= '$fin' AND offre.garage = $garage"))[0];

  $sumprixpredit = pg_fetch_array(pg_query($conn, "SELECT SUM(prixventesuggere) FROM voiture
  INNER JOIN offre ON offre.voiture = voiture.idvoiture
  WHERE etatoffre = 'Finished'
  AND datevente >= '$debut' AND datevente <= '$fin' AND offre.garage = $garage"))[0];

  $sumprixfinal = pg_fetch_array(pg_query($conn, "SELECT SUM(prixventefinal) FROM voiture
  INNER JOIN offre ON offre.voiture = voiture.idvoiture
  WHERE etatoffre = 'Finished'
  AND datevente >= '$debut' AND datevente <= '$fin' AND offre.garage = $garage"))[0];

  $sumprixdemande = pg_fetch_array(pg_query($conn, "SELECT SUM(prixoffre) FROM offre
  WHERE etatoffre = 'Finished'
  AND datevente >= '$debut' AND datevente <= '$fin' AND offre.garage = $garage"))[0];

  $diffprixpreditfinal = $sumprixpredit - $sumprixfinal;
  $diffprixpreditdemande = $sumprixpredit - $sumprixdemande;
  $diffprixdemandefinal = $sumprixdemande - $sumprixfinal;

  pg_query($conn, "INSERT INTO bilan(
    datedebutperiode, datefinperiode, nbdepots, nbventes, diffprixpreditfinal, diffprixpreditdemande, diffprixdemandefinal, typeauteur, idauteur, garage)
    VALUES ('$debut', '$fin', '$nbdepots', '$nbventes', '$diffprixpreditfinal', $diffprixpreditdemande, $diffprixdemandefinal, '$type', '$id', $garage);");
  header("Location:bilan.php?".$nbdepots.'-'.$sumprixfinal.'-'.$sumprixpredit.'-'.$sumprixdemande);
}

if(isset($_GET['delete'])){
  $idbilan=$_GET['bilan'];
  $delete_query = pg_query($conn, "DELETE FROM bilan WHERE idbilan='$idbilan'");
  header("Location:bilan.php");
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Reports</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/jumbotron/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
     integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand"><b>ProjetCSI-IA</b></a>
    <li class="navbar-toggler" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </li>
    
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a href="index.php" class="nav-link">Homepage<span class="sr-only">(current)</span></a>
        </li>
        
        <li class="nav-item active">
          <a class="nav-link" href="offres.php">Offers</a>
        </li>

        <?php if(isset($_SESSION['email']) && $type != 'client'){ ?>
        <li class="nav-item active">
          <a class="nav-link" href="vehicules.php">Vehicles</a>
        </li>
        <?php } ?>

        <?php if(isset($_SESSION['email']) && $type == 'client'){?>
        <li class="nav-item active">
          <a class="nav-link" href="mes_propositions.php">My purchase proposals</a>
        </li>
        <?php }?>

        <?php if(isset($_SESSION['email']) && $type == 'garage'){?>
        <li class="nav-item active">
          <a class="nav-link" href="propositions.php">Manage purchase proposals</a>
        </li>
        <?php }?>

        <?php if(isset($_SESSION['email']) && $type != 'client'){ ?>
        <li class="nav-item active">
          <a class="nav-link" href="bilan.php">Reports</a>
        </li>
        <?php }?>
      </ul>

      <form class="form-inline my-2 my-lg-0">
        <?php if(isset($_SESSION['email'])){?>
        <a href="mon_compte.php?id=<?= $id?><?php if(isset($statut)){echo '&?statut='.$statut;}?>" class="btn btn-outline-success my-2 my-sm-0">My account</a>
        &nbsp;
        <a href="logout.php" class="btn btn-outline-success my-2 my-sm-0">Log out</a>
        <?php } else { ?>
        <a href="connexion.php" class="btn btn-outline-success my-2 my-sm-0">Log in</a>
        &nbsp;
        <a href="inscription.php" class="btn btn-outline-success my-2 my-sm-0">Sign up</a>
        <?php } ?>
      </form>
    </div>
  </nav>

<main role="main">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron" style="background-color:#fff;">
    <div class="container">
    <form method="POST">
      <br>
      <h2>Generate a new report</h2>
      <h10>Enter date in "YYYY-MM-DD" format<h10>
      <br>
      <br>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Start : </label>
    <div class="col-sm-10">
      <input type="text" name="inputDébut" id="inputDébut" class="form-control">
    </div>
  </div>
  
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">End : </label>
    <div class="col-sm-10">
      <input type="text" name="inputFin" id="inputFin" class="form-control">
    </div>
  </div>
  
  <?php if($type == 'administrateur'){ ?>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Garage</label>
    <div class="col-sm-10">
      <input type="text" name="inputGarage" id="inputGarage" class="form-control">
    </div>
  </div>
  <?php } ?>

  <center><button name="créerBilan" type="submit" class="info">Create</button></center>
</form>
  </div>

  <br>
    <h2>Previously generated reports</h2>
  <br>
  <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Start</th>
            <th scope="col">End</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($donnees = pg_fetch_array($liste)){
        ?>
        <tr>
            <td><?= $donnees['datedebutperiode']; ?></td>
            <td><?= $donnees['datefinperiode']; ?></td>
            <td>
                <a href="affiche_bilan.php?id=<?=$donnees['idbilan']?>">View details</a>
                <br>
                <a href="bilan.php?bilan=<?=$donnees['idbilan']?>&delete">Delete</a>
            </td>
        </tr>
        <?php }?>
    </tbody>
  </table>
  </div>

</main>






<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>