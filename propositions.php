<?php
include('db.php');
$liste = pg_query($conn, "SELECT * FROM propositionachat
INNER JOIN offre ON propositionachat.offre = offre.idoffre
WHERE offre.garage = '$id'
AND NOT propositionachat.etatproposition = 'Declined'
ORDER BY dateproposition DESC");

if(isset($_GET['accept'])){
  $idproposition=$_GET['id'];
  $idoffre= pg_fetch_array(pg_query($conn, "SELECT offre FROM propositionachat WHERE idproposition='$idproposition'"))[0];
  $idvoiture= pg_fetch_array(pg_query($conn, "SELECT voiture FROM offre WHERE idoffre='$idoffre'"))[0];
  $prixvente = pg_fetch_array(pg_query($conn, "SELECT prixproposition FROM propositionachat WHERE idproposition='$idproposition'"))[0];
  $prixia = pg_fetch_array(pg_query($conn, "SELECT prixventesuggere FROM voiture WHERE idvoiture='$idvoiture'"))[0];

  
  pg_query($conn, "UPDATE propositionachat SET etatproposition='Accepted' WHERE idproposition = '$idproposition'");
  pg_query($conn, "UPDATE propositionachat SET etatproposition='Declined' WHERE offre = '$idoffre' AND NOT idproposition = '$idproposition'");
  pg_query($conn, "UPDATE voiture SET prixventefinal='$prixvente' WHERE idvoiture='$idvoiture'");

  // pg_query($conn, "INSERT INTO historiquevoiture
  // SELECT * FROM voiture WHERE idvoiture = '$idvoiture'");

  pg_query($conn, "UPDATE offre SET etatoffre = 'Finished' WHERE idoffre = '$idoffre'");
  pg_query($conn, "UPDATE offre SET datevente = NOW() WHERE idoffre = '$idoffre'");

  // pg_query($conn, "INSERT INTO historiqueoffre
  // SELECT idoffre, prixoffre, datepublicationoffre, datevente, voiture, garage FROM offre WHERE idoffre='$idoffre'");

  // pg_query($conn, "INSERT INTO historiquepropositionachat
  // SELECT idproposition, prixproposition, dateproposition, client, offre FROM propositionachat WHERE idproposition='$idproposition'");

  $diffprixiavente = $prixia - $prixvente;
  if($diffprixiavente == 0){
    $commentaire = 'The car has been sold at the predicted price';
  }
  if($diffprixiavente > 0){
    $commentaire = 'The car has been sold '.$diffprixiavente.'€ lower than the predicted price';
  }

  if($diffprixiavente < 0){
    $commentaire = 'The car has been sold '.-1*$diffprixiavente.'€ higher than the predicted price';
  }

  pg_query($conn, "UPDATE voiture SET commentaire='$commentaire' WHERE idvoiture='$idvoiture'");
  header("Location:propositions.php?".$diffprixiavente);
}

if(isset($_GET['decline'])){
  $idproposition=$_GET['id'];
  pg_query($conn, "UPDATE propositionachat SET etatproposition = 'Declined' WHERE idproposition = '$idproposition'");
  header("Location:propositions.php");
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
    <title>Managa proposals</title>

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
    <form method="post">
        <br>
        <h2>Purchase proposals</h2>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Offer</th>
                    <th scope="col">Price set</th>
                    <th scope="col">Proposed price</th>
                    <th scope="col">Client</th>
                    <th scope="col">State</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($donnees = pg_fetch_array($liste)){
                  $detailsOffre = pg_query($conn, "SELECT * FROM offre WHERE idoffre='$donnees[offre]'");
                  while ($donneesOffre = pg_fetch_array($detailsOffre)){
                    $detailsVoiture = pg_query($conn, "SELECT * FROM voiture WHERE idvoiture='$donneesOffre[voiture]'");
                    while ($donneesVoiture = pg_fetch_array($detailsVoiture)){
                ?>
                <tr>
                    <td><a href="affiche_offre.php?id=<?=$donnees['offre']?>"><?= $donneesVoiture['marque'].' '.$donneesVoiture['modele'].' '.$donneesVoiture['annee']; ?></a></td>
                    <td><?= $donneesOffre['prixoffre'] ?></td>
                    <td><?= $donnees['prixproposition']; ?></td>
                    <td><?= $donnees['client']; ?></td>
                    <td><?= $donnees['etatproposition']; ?></td>
                    
                    <td>
                    <?php if($donnees['etatproposition']=='Filed'){ ?>
                      <a href="propositions.php?id=<?=$donnees['idproposition']?>&accept">Accept</a>
                      <a href="propositions.php?id=<?=$donnees['idproposition']?>&decline">Decline</a>
                    <?php } ?>
                    </td>
                    
                </tr>
                <?php }}}?>
            </tbody>
        </table>
    </form>
    </div>
  </div>

</main>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>