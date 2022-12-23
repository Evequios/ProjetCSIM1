<?php 
include('db.php');

// Si l'utilisateur est déjà connecté, il est renvoyé à l'accueil
if(isset($_SESSION['email'])){
  header('Location: index.php');
  exit;
}

// Après clic sur le bouton inscription client
if(isset($_POST['submit_client'])){
    header('Location: inscription_client.php');
    exit;
}

// Après clic sur le bouton inscription garage
if(isset($_POST['submit_garage'])){
  header('Location: inscription_garage.php');
  exit;
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
    
    <title>Inscription</title>

    

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
        <h1 class="h3 mb-3 font-weight-normal">Sign up</h1>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit_client">Sign up as a client</button>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit_garage">Sign up as a garage</button>
        <h5 class="h3 mb-3 font-weight-normal"><font size="3">You already have and account ?<br><a href="connexion.php">Log in</a></font></h5>
        
    </form>



</body>

</html>
