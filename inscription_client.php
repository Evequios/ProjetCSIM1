<?php 
include('db.php');

// Si l'utilisateur est déjà connecté, il est renvoyé à l'accueil
if(isset($_SESSION['email'])){
  header('Location: index.php');
  exit;
}

// Après clic sur le bouton inscription
if(isset($_POST['submit'])){
  // Récupérations des identifiants
  $prenom = $_POST['inputPrenom'];
  $nom = $_POST['inputNom'];
  $telephone = $_POST['inputPhone'];
  $mail = $_POST['inputEmail'];
  $password = $_POST['inputPassword'];
  $password2 = $_POST['inputPassword2'];
  
  // Vérification de l'existence d'un compte avec ce mail
  $mailcheckclient = pg_num_rows(pg_query($conn, "SELECT 'idClient' FROM Client WHERE identifiantcompte='$mail'"));
  $mailcheckgarage = pg_num_rows(pg_query($conn, "SELECT 'idGarage' FROM Garage WHERE identifiantcompte='$mail'"));
  if($mailcheckclient > 0 || $mailcheckgarage > 0){ // Si un compte est déjà créé avec cette adresse mail
    header("Location : inscription.php?invalidmail");
    exit;
  }
  else{
    if ($password==$password2){ // Insertion si les mots de passes sont identiques
      $insert_query = pg_query($conn, "INSERT INTO Client(prenomclient, nomclient, telephoneclient, identifiantcompte, motDePassecompte) 
      VALUES ('$prenom', '$nom', '$telephone', '$mail', '$password')");
      header("Location: connexion.php");
      exit;
    }else{// Si les mots de passes sont différents
      header("Location: inscription.php?invalidpw");
      exit;
    }
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
    
    <title>Sign up</title>

    

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
     integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">


    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="POST">

        <h1 class="h3 mb-3 font-weight-normal"><font size="24"><a href="index.php"><b>ProjetM1</b></a></font></h1>
        <h1 class="h3 mb-3 font-weight-normal">Sign up as a client</h1>
        <?php if (isset($_GET['invalidmail'])){ ?> <h1 class="h3 mb-3 font-weight-normal" style="color:#FF0000"><font size="3">The email address is already linked to an existing account</font></h1><?php }
        else if (isset($_GET['invalidpw'])){?> <h1 class="h3 mb-3 font-weight-normal" style="color:#FF0000"><font size="3">The passwords must be identical</font></h1><?php } ?>
        <input type="text" id="inputPrenom" name="inputPrenom" class="form-control" placeholder="First name" required autofocus>
        <input type="text" id="inputNom" name="inputNom" class="form-control" placeholder="Last name" required>
        <input type="tel" id="inputPhone" name="inputPhone" class="form-control" placeholder="Phone number" required>
        <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required>
        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
        <input type="password" id="inputPassword2" name="inputPassword2" class="form-control" placeholder="Password confirmation" required>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign up</button>
        <h5 class="h3 mb-3 font-weight-normal"><font size="3">You already have and account ?<br><a href="connexion.php">Log in</a></font></h5>
    </form>
</body>
</html>
