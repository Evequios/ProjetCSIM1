<?php
include('db.php');

if(isset($_POST['bilans'])){
  $date = date('Y', strtotime('-2 years')).'-12-31';
  pg_query($conn, "DELETE FROM bilan WHERE datecreation <= '$date'");
  header("Location:index.php?.$date");
}

if(isset($_POST['offres'])){
  pg_query($conn, "UPDATE offre SET etatoffre = 'Expired' WHERE datepublicationoffre + delaioffre < NOW() AND etatoffre='Added'");
  header("Location:index.php?");
}

if(isset($_POST['archive'])){
  
  $listeVoitures = pg_query($conn, "SELECT * FROM voiture WHERE prixventefinal > 0 AND commentaire IS NOT NULL");
  while ($donnees = pg_fetch_array($listeVoitures)){
    $idvoiture = $donnees['idvoiture'];
    pg_query($conn, "INSERT INTO historiquevoiture (SELECT * FROM voiture WHERE idvoiture = '$idvoiture')");
  }


  $listeOffres = pg_query($conn, "SELECT * FROM offre WHERE etatoffre = 'Finished'");
  while ($donnees = pg_fetch_array($listeOffres)){
    $idoffre = $donnees['idoffre'];
    pg_query($conn, "INSERT INTO historiqueoffre
    SELECT idoffre, prixoffre, datepublicationoffre, datevente, voiture, garage FROM offre WHERE idoffre = $idoffre");
  }

  $listePropositions = pg_query($conn, "SELECT * FROM propositionachat WHERE etatproposition = 'Accepted'");
  while ($donnees = pg_fetch_array($listePropositions)){
    $idproposition = $donnees['idproposition'];
    pg_query($conn, "INSERT INTO historiquepropositionachat
    SELECT idproposition, prixproposition, dateproposition, offre, client FROM propositionachat WHERE idproposition ='$idproposition'");
  }

  pg_query($conn, "DELETE FROM propositionachat WHERE etatproposition = 'Declined'");
  // pg_query($conn, "DELETE FROM offre WHERE etatoffre = 'Expired'");

  $listePropositionsHisto = pg_query($conn, "SELECT * FROM historiquepropositionachat");
  while ($donnees = pg_fetch_array($listePropositionsHisto)){
    $idpropositionhisto = $donnees['idproposition'];
    pg_query($conn, "DELETE FROM propositionachat WHERE idproposition ='$idpropositionhisto'");
  }

  $listeOffresHisto = pg_query($conn, "SELECT * FROM historiqueoffre");
  while ($donnees = pg_fetch_array($listeOffresHisto)){
    $idoffrehisto = $donnees['idoffre'];
    pg_query($conn, "DELETE FROM offre WHERE idoffre ='$idoffrehisto'");
  }

  $listeVoituresHisto = pg_query($conn, "SELECT * FROM historiquevoiture");
  while ($donnees = pg_fetch_array($listeVoituresHisto)){
    $idvoiturehisto = $donnees['idvoiture'];
    pg_query($conn, "DELETE FROM voiture WHERE idvoiture ='$idvoiturehisto'");
  }

  header("Location:index.php");
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
    <title>ProjetM1</title>

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
  <form method="post">
  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1 class="display-3"><font size=20>Hello <?php if(isset($_SESSION['email']) && isset($type)){
        if($type == 'client'){echo $prenom." ".$nom; } 
        if($type == 'garage'){echo $nom;}
        if($type == 'administrateur'){echo 'Administrator';}}?></font></h1>
    </div>
  </div>

  <?php if(isset($type) && $type == 'administrateur' && isset($_SESSION['email'])){?>
    <center><button name="bilans" type="submit" class="info">Delete two years old reports</button></center>
    <center><button name="offres" type="submit" class="info">Expired offers</button></center>
    <center><button name="archive" type="submit" class="info">Archive</button></center>
  <?php } ?>
  </form>
</main>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>