<?php
include('db.php');
// Si l'id n'a pas pu être récupéré ou si l'utilisateur n'est pas connecté
// if(!isset($_GET['id']) || empty($_GET['id']) || !isset($_SESSION['email'])){
//   header("Location:index.php");
//   exit;
// }

if(isset($_POST['update'])){
  if($type == 'client'){
    $p = $_POST['inputPrenom'];
    $n = $_POST['inputNom'];
    // $telephone = $_POST['inputPhone'];
    // $mail = $_POST['inputEmail'];
    $pw = $_POST['inputPassword'];

    pg_query($conn, "UPDATE client
    SET nomclient='$n', prenomclient='$p', motdepassecompte='$pw'
    WHERE idClient = '$id'");
    header("Location:index.php?p=".$p."&n=".$n);
  }
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
    <title>My account</title>

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
      <h2>Your details</h2>
      <br>
      <?php if($type == 'client'){?>
      
      <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">First name : </label>
    <div class="col-sm-10">
      <input type="text" name="inputPrenom" id="inputPrenom" class="form-control" value="<?php echo $prenom;?>">
    </div>
  </div>

      <div class="form-group row">
    <label class="col-sm-2 col-form-label">Last name : </label>
    <div class="col-sm-10">
      <input type="text" name="inputNom" id="inputNom" class="form-control" value="<?php echo $nom;?>">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Email : </label>
    <div class="col-sm-10">
      <input type="text" name="email" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $_SESSION['email']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Password : </label>
    <div class="col-sm-10">
      <input type="password" name="inputPassword" class="form-control" id="inputPassword" value="<?php echo $mdp; ?>">
    </div>
    
  </div><?php } 


  if($type == 'garage') {?>

    <div class="form-group row">
  <label for="staticEmail" class="col-sm-2 col-form-label">Name : </label>
  <div class="col-sm-10">
    <input type="text" name="nom" id="inputNomGarage" class="form-control" value="<?php echo $nom;?>">
  </div>
</div>

  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">CRN : </label>
    <div class="col-sm-10">
      <input type="text" name="crn" id="inputCRN" class="form-control" value="<?php echo $crn;?>">
    </div>
  </div>

    <div class="form-group row">
  <label class="col-sm-2 col-form-label">Address : </label>
  <div class="col-sm-10">
    <input type="text" name="adresse" id="inputadresse" class="form-control" value="<?php echo $adresse;?>">
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Email : </label>
  <div class="col-sm-10">
    <input type="text" name="email" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $_SESSION['email']; ?>">
  </div>
</div>
<div class="form-group row">
  <label for="inputPassword" class="col-sm-2 col-form-label">Password : </label>
  <div class="col-sm-10">
    <input type="password" name="motdepasse" class="form-control" id="inputPassword" value="<?php echo $mdp; ?>">
  </div>
  
</div><?php } 

    if($type == 'administrateur'){ ?>
<div class="form-group row">
  <label class="col-sm-2 col-form-label">Email : </label>
  <div class="col-sm-10">
    <input type="text" name="email" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $_SESSION['email']; ?>">
  </div>
</div>
<div class="form-group row">
  <label for="inputPassword" class="col-sm-2 col-form-label">Password : </label>
  <div class="col-sm-10">
    <input readonly type="password" name="motdepasse" class="form-control" id="inputPassword" value="<?php echo $mdp; ?>">
  </div>
    <?php }
  if($type != 'administrateur'){?>
  <center><button name="update" type="submit" class="info">Update</button></center>
  <?php } ?>
</form>
  </div>
  </div>

</main>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="/docs/4.4/assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="/docs/4.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm" crossorigin="anonymous"></script></body>
</html>