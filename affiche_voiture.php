<?php
include('db.php');
if(isset($_GET['id'])){
  $idvoiture=$_GET['id'];
  $idgarage= pg_fetch_array(pg_query($conn, "SELECT idgarage FROM garage
  INNER JOIN offre ON garage.idgarage = offre.garage
  INNER JOIN voiture ON offre.voiture = voiture.idvoiture
  WHERE idvoiture = '$idvoiture'"))[0];
  $donneesVoiture = pg_fetch_array(pg_query($conn, "SELECT * FROM voiture WHERE idVoiture='$idvoiture' "));
}

if(isset($_POST['creer&update'])){
  header("Location:offre.php?voiture=".$idvoiture);
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
    <title>Display car</title>

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
      <h2><?= $donneesVoiture['marque'].' '.$donneesVoiture['modele'].' '.$donneesVoiture['annee'];?></h2>
      <br>


  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Garage : </label>
    <div class="col-sm-10">
      <input type="text" name="garage" id="garage" class="form-control-plaintext" value="<?=$idgarage;?>">
    </div>
  </div>
  
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Mileage : </label>
    <div class="col-sm-10">
      <input type="text" name="kilometrage" id="kilometrage" class="form-control-plaintext" value="<?=$donneesVoiture['kilometrage'];?>">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Transmission : </label>
    <div class="col-sm-10">
      <input type="text" name="transmission" readonly class="form-control-plaintext" id="stock" value="<?=$donneesVoiture['typetransmission']?>">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Fuel type : </label>
    <div class="col-sm-10">
      <input type="text" name="carburant" readonly class="form-control-plaintext" id="stock" value="<?=$donneesVoiture['typecarburant']?>">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Miles per gallon: </label>
    <div class="col-sm-10">
      <input type="text" name="consommation" readonly class="form-control-plaintext" id="stock" value="<?=$donneesVoiture['consommation']?>">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Tax: </label>
    <div class="col-sm-10">
      <input type="text" name="taxe" readonly class="form-control-plaintext" id="stock" value="<?=$donneesVoiture['taxe']?>">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Engine size: </label>
    <div class="col-sm-10">
      <input type="text" name="cylindree" readonly class="form-control-plaintext" id="stock" value="<?=$donneesVoiture['cylindree']?>">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">License plate: </label>
    <div class="col-sm-10">
      <input type="text" name="immatriculation" readonly class="form-control-plaintext" id="immatriculation" value="<?=$donneesVoiture['immatriculation']?>">
    </div>
  </div>
  
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Remark: </label>
    <div class="col-sm-10">
      <input type="text" name="commentaire" readonly class="form-control-plaintext" id="commentaire" value="<?=$donneesVoiture['commentaire']?>">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Predicted price: </label>
    <div class="col-sm-10">
      <input type="text" name="prixventesuggere" readonly class="form-control-plaintext" id="prixventesuggere" value="<?=$donneesVoiture['prixventesuggere']?>">
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Final price: </label>
    <div class="col-sm-10">
      <input type="text" name="prixventefinal" readonly class="form-control-plaintext" id="prixventefinal" value="<?=$donneesVoiture['prixventefinal']?>">
    </div>
  </div>
  
  <?php if($type == 'garage' && isset($_SESSION['email'])){
    if($donneesVoiture['prixventefinal'] == 0){ 
      if(pg_num_rows(pg_query($conn, "SELECT * FROM offre WHERE voiture= '$donneesVoiture[idvoiture]' AND etatoffre = 'Added'")) == 0){
      ?>
    <center><button name="creer&update" type="submit" class="info">Update this vehicle's info and create a new offer</button></center>
  <?php }}} ?>
</form>
  </div>
  </div>

</main>






<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>