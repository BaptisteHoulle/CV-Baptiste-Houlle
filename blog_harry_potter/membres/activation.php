<?php
    session_start();

    if(!isset($_SESSION['idm']) or !isset($_SESSION['nom']) or !isset($_SESSION['prenom']) or !isset($_SESSION['email']) or ($_SESSION['admin']==0)) {
        header("Location: ../index.php");
        exit;
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
    <link rel='stylesheet' href="../style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<header>
        <h1>Activer les membres</h1>
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
    </header>

<body>
    <h2>Activation des membres</h2>
    <p class="activer">Permet d'activer un compte pour que la personne puisse se connecter</p>
    <?php
        include('../config/bdd.php');
        include('../config/outils.php');
        $lien=mysqli_connect(SERVEUR, LOGIN, MDP, BASE);

        if(isset($_REQUEST['num']))
        {
            $num=nettoyage($lien,$_REQUEST['num']);
            $req="UPDATE membres set actif=1 WHERE idm='$num'";
            $res=mysqli_query($lien,$req);
            if(!$res)
			{
				echo "Erreur SQL: $req<br>".mysqli_error($lien);
			}
			else {
                echo "Activation effectuée";
            }
        }
            
			$req="SELECT * FROM membres WHERE actif=0";
			$res=mysqli_query($lien, $req);
			if(!$res)
			{
				echo "Erreur SQL: $req<br>".mysqli_error($lien);
			}
			else
			{
                echo "<table class='cont'>";
				echo "<tr>
					<th><i class='fas fa-user'></i>Prénom de l'auteur</th>
					<th><i class='fas fa-user'></i>Nom de l'auteur</th>
					<th><i class='fas fa-at'></i>Adresse mail de l'auteur</th>
					<th><i class='fas fa-user-check'></i>Activer la demande d'inscription</th>
				</tr>";
                while ($tableau=mysqli_fetch_array($res)) {
                    $ligne="<tr>";
                    $ligne.="<td>".$tableau['prenom']."</td>";
                    $ligne.="<td>".$tableau['nom']."</td>";
                    $ligne.="<td>".$tableau['email']."</td>";
                    $ligne.="<td><a href='activation.php?num=".$tableau['idm']."'><i class='fas fa-user-check'></i></a><a href='activation.php?num=".$tableau['idm']."'>Activer</a></td>";
                    $ligne.="</tr>";
                    echo $ligne;
                }
                echo "</table>";
            }
			mysqli_close($lien);
		?>
</body>

</html>