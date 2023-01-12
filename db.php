<?php
session_start();

//Connexion à la BDD
$dbhost = "localhost";
$dbuser = "postgres";
$dbpswd = "root";
$dbname = "projetCSIIA";
$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpswd") or die ("Impossible de se connecter au serveur\n");

// Si l'utilisateur est connecté, on récupère ses informations
if(isset($_SESSION['email'])){

    // Vérifie si l'utilisateur est un client
    $sqlidclient = "SELECT idClient FROM Client WHERE identifiantcompte='$_SESSION[email]'";
    $idUtilisateur = pg_query($conn, $sqlidclient);
    $nb_rows = pg_num_rows($idUtilisateur);
    if ($nb_rows == 1){ // Si c'est un client
        while($row = pg_fetch_assoc($idUtilisateur)){
            $id = $row['idclient'];
        }

        $sqlprenom = "SELECT prenomclient FROM Client WHERE identifiantcompte='$_SESSION[email]'";
        $prenomutilisateur = pg_query($conn, $sqlprenom);
        while ($row = pg_fetch_assoc($prenomutilisateur)){
        $prenom = $row['prenomclient'];
        }

        $sqlnom = "SELECT nomclient from Client WHERE identifiantcompte='$_SESSION[email]'";
        $nomutilisateur = pg_query($conn, $sqlnom);
        while ($row = pg_fetch_assoc($nomutilisateur)){
        $nom = $row['nomclient'];
        }
        
        $type = 'client';
        $sqlmdp = "SELECT motdepassecompte FROM Client WHERE identifiantcompte='$_SESSION[email]'";
        $mdputilisateur = pg_query($conn, $sqlmdp);
        while($row = pg_fetch_assoc($mdputilisateur)){
            $mdp=$row['motdepassecompte'];
        }
    }

    else{ // Si c'est un garage
        $sqlidgarage = "SELECT idgarage FROM Garage WHERE identifiantcompte='$_SESSION[email]'";
        $idUtilisateur = pg_query($conn,$sqlidgarage);
        $nb_rows = pg_num_rows($idUtilisateur);
        if ($nb_rows == 1){
            while($row = pg_fetch_assoc($idUtilisateur)){
                $id = $row['idgarage'];
            }

            $sqlnom = "SELECT nomgarage FROM Garage WHERE identifiantcompte='$_SESSION[email]'";
            $nomutilisateur = pg_query($conn, $sqlnom);
            while ($row = pg_fetch_assoc($nomutilisateur)){
            $nom = $row['nomgarage'];
            }

            $sqlcrn= "SELECT crn FROM Garage WHERE identifiantcompte='$_SESSION[email]'";
            $crnutilisateur = pg_query($conn, $sqlcrn);
            while ($row = pg_fetch_assoc($crnutilisateur)){
            $crn = $row['crn'];
            }


            $sqladresse= "SELECT adresse FROM Garage WHERE identifiantcompte='$_SESSION[email]'";
            $adresseutilisateur = pg_query($conn, $sqladresse);
            while ($row = pg_fetch_assoc($adresseutilisateur)){
            $adresse = $row['adresse'];
            }

            $type = 'garage';

            $sqlmdp = "SELECT motdepassecompte FROM Garage WHERE identifiantcompte='$_SESSION[email]'";
            $mdputilisateur = pg_query($conn, $sqlmdp);
            while($row = pg_fetch_assoc($mdputilisateur)){
                $mdp=$row['motdepassecompte'];
            }
        }

        else{
            $sqlidadmin = "SELECT idadministrateur FROM administrateur WHERE identifiantcompte='$_SESSION[email]'";
            $idUtilisateur = pg_query($conn,$sqlidadmin);
            $nb_rows = pg_num_rows($idUtilisateur);
            if ($nb_rows == 1){
                while($row = pg_fetch_assoc($idUtilisateur)){
                    $id = $row['idadministrateur'];
                }

                $type = 'administrateur';

                $sqlmdp = "SELECT motdepassecompte FROM administrateur WHERE identifiantcompte='$_SESSION[email]'";
                $mdputilisateur = pg_query($conn, $sqlmdp);
                while($row = pg_fetch_assoc($mdputilisateur)){
                    $mdp=$row['motdepassecompte'];
                }
            }
        }
    }
}
?>

