<?php
include('db.php');
if(isset($_SESSION['email']) && $type != 'client'){
  $liste = pg_query($conn, "SELECT * FROM offre ORDER BY datepublicationoffre DESC");
}
else{
  $liste = pg_query($conn, "SELECT * FROM offre WHERE etatoffre = 'Added' ORDER BY datepublicationoffre DESC");
}

// switch($tri){
//     case 'Date' : $liste = pg_query($conn, "SELECT * FROM offre ORDER BY datepublicationoffre DESC"); break;
//     case 'Alphabetically' : $liste = pg_query($conn, "SELECT * FROM offre ORDER BY marque DESC"); break;
//     case 'Payée' : $liste = pg_query($conn, "SELECT * FROM offre ORDER BY datepublicationoffre DESC"); break;
//     case 'En préparation' : $liste = pg_query($conn, "SELECT * FROM offre ORDER BY datepublicationoffre DESC"); break;
//     case 'Prête' : $liste = pg_query($conn, "SELECT * FROM offre ORDER BY datepublicationoffre DESC"); break;
//     case 'Livrée' : $liste = pg_query($conn, "SELECT * FROM offre ORDER BY datepublicationoffre DESC"); break;
//     case 'Abandonnée' : $liste = pg_query($conn, "SELECT * FROM offre ORDER BY datepublicationoffre DESC"); break;
//     case 'Annulée' : $liste = pg_query($conn, "SELECT * FROM offre ORDER BY datepublicationoffre DESC"); break;
//     default : $liste = pg_query($conn, "SELECT * FROM offre ORDER BY datepublicationoffre DESC"); break;
// }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Offers</title>

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
        <h2>Offers list</h2>
        <?php if(isset($_SESSION['email']) && $type == 'garage'){?><h4><a href="offre.php">+ Add an offer for a new car</a></h4><?php } ?>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Brand</th>
                    <th scope="col">Model</th>
                    <th scope="col">Year</th>
                    <th scope="col">Price</th>
                    <th scope="col">State</th>
                    <th scope="col">Action</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                while ($donnees = pg_fetch_array($liste)){
                  $detailsVoiture = pg_query($conn, "SELECT marque, modele, annee FROM voiture WHERE idvoiture='$donnees[voiture]'");
                  while ($donneesVoiture = pg_fetch_array($detailsVoiture)){
                ?>
                <tr>
                    <td><?= $donneesVoiture['marque']; ?></td>
                    <td><?= $donneesVoiture['modele']; ?></td>
                    <td><?= $donneesVoiture['annee']; ?></td>
                    <td><?= $donnees['prixoffre']; ?></td>
                    <td><?= $donnees['etatoffre']; ?></td>
                    <td>
                      <a href="affiche_offre.php?id=<?=$donnees['idoffre']?>">View details</a>
                    </td>
                    <td>
                      <?php if(isset($_SESSION['email']) && $donnees['garage'] == $id and $type == 'garage' and $donnees['etatoffre'] == 'Added') {?>
                        <a href="offre.php?offre=<?=$donnees['idoffre']?>">Update</a>
                      <?php } ?>
                    </td>
                </tr>
                <?php }}?>
            </tbody>
        </table>
    </form>
    </div>
  </div>

</main>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>