<?php
    session_start();

    if(!isset($_SESSION['idm']) or !isset($_SESSION['nom']) or !isset($_SESSION['prenom']) or !isset($_SESSION['email'])) {
        header("Location: ../index.php");
    }

    ?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
    <link rel='stylesheet' href="../login.css">
    <link rel='stylesheet' href="../modif.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Modifier son mot de passe</title>
</head>

<body>
    <header>
        <?php
	echo"<nav>";
    echo"<input type='checkbox' id='check'>";
    echo"<label for='check' class='checkbtn'>";
    echo"<i class='fas fa-bars'></i>";
    echo"</label>";
    echo"<ul>";
    echo "<li> <a href='../index.php'><i class='fas fa-home'></i>Retour à l'accueil</a></li>";
    echo"</ul>";
    echo"</nav>";
    
    ?>
        <h1>Modifier son mot de passe</h1>
    </header>

    <form method="post" enctype="multipart/form-data">
        <div>
            <input type="password" name="oldmdp" id="oldmdp" placeholder="Veuillez entrer votre ancien mot de passe">
            <label for="oldmdp">Ancien mdp</label>
        </div>
        <div>
            <input type="password" name="newmdp" id="newmdp" placeholder="Veuillez entrer votre nouveau mot de passe">
            <label for="newmdp">Nouveau mdp</label>
        </div>
        <div>
            <input type="password" name="newmdp2" id="newmdp2" placeholder="Veuillez confirmer et entrer votre nouveau mot de passe">
            <label for="newmdp2">Confirmation</label>
        </div>
        <input type="submit" name="modifier" value="Modifier">
    </form>
 <?php

 if(isset($_REQUEST['modifier'])) {


            include('../config/bdd.php');
            include('../config/outils.php');

            $lien=mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
            $num=$_SESSION['idm'];
            $oldmdp=md5($_REQUEST['oldmdp']);
            $newmdp=md5($_REQUEST['newmdp']);
			$newmdp2=md5($_REQUEST['newmdp2']);
    

            if(($newmdp==$newmdp2) and ($newmdp!=$oldmdp) and ($newmdp2!=$oldmdp)) {
                $req="UPDATE membres SET mdp='$newmdp' WHERE idm=$num";
                $res=mysqli_query($lien,$req);

                if (!$res) {
                    echo "Erreur SQL: $req<br>".mysqli_error($lien);
                }

                else {
                    echo "<p class='reussie'>Mot de passe modifié avec succès !</p>";
                    session_unset();
                    session_destroy();
                }

               
            }
            elseif (($newmdp!=$newmdp2)) {
                echo "<p class='utilise'>Les mots de passes entrés ne sont pas identiques !</p>";
            }
            mysqli_close($lien);
        }

            ?>
  
    <script src="../main.js"></script>
</body>
</html>