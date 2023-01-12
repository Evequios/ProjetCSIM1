<?php
include('db.php');

if(isset($_GET['offre'])){
  $idoffre=$_GET['offre'];
  $ancienprix = pg_fetch_array(pg_query($conn,"SELECT prixoffre FROM Offre WHERE idoffre='$idoffre'"))[0];
  $anciendelai = pg_fetch_array(pg_query($conn,"SELECT delaioffre FROM Offre WHERE idoffre='$idoffre'"))[0];
  $idvoiture = pg_fetch_array(pg_query($conn, "SELECT voiture FROM offre where idoffre='$idoffre' "))[0]; 
  $idgarage = pg_fetch_array(pg_query($conn, "SELECT garage FROM offre where idoffre='$idoffre' "))[0]; 
  $prixOffre = pg_fetch_array(pg_query($conn, "SELECT prixoffre FROM offre where idoffre='$idoffre' "))[0]; 

  $anciennecategorie = pg_fetch_array(pg_query($conn,"SELECT categorie FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciennemarque = pg_fetch_array(pg_query($conn,"SELECT marque FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienmodele = pg_fetch_array(pg_query($conn,"SELECT modele FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienneannee = pg_fetch_array(pg_query($conn,"SELECT annee FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienneimmatriculation = pg_fetch_array(pg_query($conn,"SELECT immatriculation FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciennetransmission = pg_fetch_array(pg_query($conn,"SELECT typetransmission FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciencarburant = pg_fetch_array(pg_query($conn,"SELECT typecarburant FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienkilometrage = pg_fetch_array(pg_query($conn,"SELECT kilometrage FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienneconsommation = pg_fetch_array(pg_query($conn,"SELECT consommation FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciennetaxe = pg_fetch_array(pg_query($conn,"SELECT taxe FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciennecylindree = pg_fetch_array(pg_query($conn,"SELECT cylindree FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienprixia = pg_fetch_array(pg_query($conn,"SELECT prixventesuggere FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
}

if(isset($_GET['voiture'])){
  $idvoiture = $_GET['voiture'];
  $anciennecategorie = pg_fetch_array(pg_query($conn,"SELECT categorie FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciennemarque = pg_fetch_array(pg_query($conn,"SELECT marque FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienmodele = pg_fetch_array(pg_query($conn,"SELECT modele FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienneannee = pg_fetch_array(pg_query($conn,"SELECT annee FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienneimmatriculation = pg_fetch_array(pg_query($conn,"SELECT immatriculation FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciennetransmission = pg_fetch_array(pg_query($conn,"SELECT typetransmission FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciencarburant = pg_fetch_array(pg_query($conn,"SELECT typecarburant FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienkilometrage = pg_fetch_array(pg_query($conn,"SELECT kilometrage FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienneconsommation = pg_fetch_array(pg_query($conn,"SELECT consommation FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciennetaxe = pg_fetch_array(pg_query($conn,"SELECT taxe FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $anciennecylindree = pg_fetch_array(pg_query($conn,"SELECT cylindree FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
  $ancienprixia = pg_fetch_array(pg_query($conn,"SELECT prixventesuggere FROM Voiture WHERE idvoiture='$idvoiture'"))[0];
}

// if(isset($_POST['ia'])){
//   $ia_link = "http://localhost/ProjectCSIM1/prediction.py?year=".$_POST['inputAnnee']."&mileage=".$_POST['inputKilometrage']."&tax=".$_POST['inputTaxe']."&mpg=".$_POST['inputMPG']."&engineSize=".$_POST['inputCylindree'];
//   $ia_data = file_get_contents($ia_link);
//   echo "<br><br><br><br><br><br><br>" . $ia_data;
// }

if(isset($_POST['faireoffre'])){
  $marque = $_POST['inputMarque'];
  $modele = $_POST['inputModele'];
  $annee = $_POST['inputAnnee'];
  $transmission = $_POST['inputTransmission'];
  $carburant = $_POST['inputCarburant'];
  $mpg = $_POST['inputMPG'];
  $taxe = $_POST['inputTaxe'];
  $cylindree = $_POST['inputCylindree'];
  $immatriculation = $_POST['inputImmatriculation'];
  $categorie = $_POST['inputCategorie'];
  $kilometrage = $_POST['inputKilometrage'];
  $prix = $_POST['inputPrix'];
  $prixIA = $_POST['inputPrixIA'];
  $delai = $_POST['inputDelai'];
  if(!isset($_GET['voiture'])){
    $insert_voiture = pg_query($conn, "INSERT INTO voiture(
    categorie, prixventesuggere, immatriculation, typetransmission, typecarburant, kilometrage, marque, modele, annee, consommation, taxe, cylindree)
    VALUES ('$categorie', '$prixIA', '$immatriculation', '$transmission', '$carburant', '$kilometrage', '$marque', '$modele', '$annee', '$mpg', '$taxe', '$cylindree')");
    $newVoiture = pg_fetch_array(pg_query($conn, "SELECT MAX(idvoiture) FROM Voiture"))[0];
    $insert_offre = pg_query($conn, "INSERT INTO offre(
    prixoffre, delaioffre, voiture, garage)
    VALUES ('$prix', '$delai', '$newVoiture', '$id')");
  }

  if(isset($_GET['voiture'])){
    $idvoiture = $_GET['voiture'];
    $update_voiture = pg_query($conn, "UPDATE voiture 
    SET categorie='$categorie',
    immatriculation='$immatriculation',
    typetransmission='$transmission',
    typecarburant='$carburant',
    kilometrage='$kilometrage',
    marque='$marque', 
    modele='$modele',
    annee='$annee',
    consommation='$mpg',
    taxe='$taxe',
    cylindree='$cylindree',
    prixventesuggere='$prixIA'
    WHERE idvoiture='$idvoiture'");

    $delete_offre = pg_query($conn, "DELETE FROM offre WHERE voiture = '$idvoiture'");

    $insert_offre = pg_query($conn, "INSERT INTO offre(prixoffre, delaioffre, voiture, garage)
    VALUES ('$prix', '$delai', '$idvoiture', '$id')");

    
  }
  header("Location:offres.php?".$newVoiture.$prix.$delai.$id);
}

if(isset($_POST['update'])){
  // $idoffre=$_GET['offre'];
  $marque = $_POST['inputMarque'];
  $modele = $_POST['inputModele'];
  $annee = $_POST['inputAnnee'];
  $transmission = $_POST['inputTransmission'];
  $carburant = $_POST['inputCarburant'];
  $mpg = $_POST['inputMPG'];
  $immatriculation = $_POST['inputImmatriculation'];
  $categorie = $_POST['inputCategorie'];
  $kilometrage = $_POST['inputKilometrage'];
  $prixIA = $_POST['inputPrixIA'];
  $prix = $_POST['inputPrix'];
  $delai = $_POST['inputDelai'];
  $taxe = $_POST['inputTaxe'];
  $cylindree = $_POST['inputCylindree'];
  // $idvoiture = pg_fetch_array(pg_query($conn, "SELECT voiture FROM offre where idoffre='$idoffre' "))[0];
  $update_voiture = pg_query($conn, "UPDATE voiture 
  SET categorie='$categorie',
  immatriculation='$immatriculation',
  typetransmission='$transmission',
  typecarburant='$carburant',
  kilometrage='$kilometrage',
  marque='$marque', 
  modele='$modele',
  annee='$annee',
  consommation='$mpg',
  taxe='$taxe',
  cylindree='$cylindree',
  prixventesuggere='$prixIA'
  WHERE idvoiture='$idvoiture'");

  $update_offre = pg_query($conn, "UPDATE offre
  SET prixoffre = '$prix', delaioffre = '$delai'
  WHERE idoffre = '$idoffre'");
  header("Location:offres.php");
}

if(isset($_POST['delete'])){
  $idoffre=$_GET['offre'];
  $delete_query = pg_query($conn, "DELETE FROM offre WHERE idoffre='$idoffre'");
  header("Location:offres.php");
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
    <title>Offer</title>

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
      <?php if(!isset($_GET['offre'])) {?><h2>Create an offer for a new car</h2><?php }
      if(isset($_GET['offre'])) {?><h2>Update an offer</h2><?php } ?>
      <br>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Category : </label>
    <div class="col-sm-10">
      <input type="text" name="inputCategorie" id="inputCategorie" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $anciennecategorie?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Brand : </label>
    <div class="col-sm-10">
      <input type="text" name="inputMarque" id="inputMarque" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $anciennemarque?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Model : </label>
    <div class="col-sm-10">
      <input type="text" name="inputModele" id="inputModele"class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $ancienmodele?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Year : </label>
    <div class="col-sm-10">
      <input type="text" name="inputAnnee" id="inputAnnee"class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $ancienneannee?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">License plate : </label>
    <div class="col-sm-10">
      <input type="text" name="inputImmatriculation" id="inputImmatriculation" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $ancienneimmatriculation?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Transmission : </label>
    <div class="col-sm-10">
      <input type="text" name="inputTransmission" id="inputTransmission" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $anciennetransmission?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Fuel type : </label>
    <div class="col-sm-10">
      <input type="text" name="inputCarburant" id="inputCarburant" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $anciencarburant?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Mileage : </label>
    <div class="col-sm-10">
      <input type="text" name="inputKilometrage" id="inputKilometrage" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $ancienkilometrage?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">MPG : </label>
    <div class="col-sm-10">
      <input type="text" name="inputMPG" id="inputMPG" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $ancienneconsommation?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Tax : </label>
    <div class="col-sm-10">
      <input type="text" name="inputTaxe" id="inputTaxe" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $anciennetaxe?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Engine size : </label>
    <div class="col-sm-10">
      <input type="text" name="inputCylindree" id="inputCylindree" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $anciennecylindree?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Estimated price : </label>
    <div class="col-sm-10">
      <input type="text" name="inputPrixIA" id="inputPrixIA" class="form-control" value=<?php if(isset($_SESSION['email']) && (isset($_GET['offre']) || isset($_GET['voiture'])))echo $ancienprixia?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Price : </label>
    <div class="col-sm-10">
      <input type="text" name="inputPrix" id="inputPrix" class="form-control" value=<?php if(isset($_SESSION['email']) && isset($_GET['offre']))echo $ancienprix?>>
    </div>
  </div>

  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Time limit : </label>
    <div class="col-sm-10">
      <input type="text" name="inputDelai" id="inputDelai" class="form-control" value=<?php if(isset($_SESSION['email']) && isset($_GET['offre']))echo $anciendelai?>>
    </div>
  </div>
  
  
  <?php if($type == 'garage' && isset($_SESSION['email']) && !isset($_GET['offre'])){?>
    <center><button name="faireoffre" type="submit" class="info">Confirm</button></center>
  <?php } ?>
  <?php if($type == 'garage' && isset($_SESSION['email']) && isset($_GET['offre'])){?>
    <center><button name="update" type="submit" class="info">Update</button></center>
    <!-- <center><button name="delete" type="submit" class="info">Delete</button></center> -->
  <?php } ?>

  <?php if(isset($_GET['invalid'])){?>
    <h4 style="color:#FF0000">The price of your proposal can't be higher than the amount demanded in the offer (<?=$prixOffre?>)<h4>
  <?php } ?>
</form>
  </div>
  </div>

</main>






<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>