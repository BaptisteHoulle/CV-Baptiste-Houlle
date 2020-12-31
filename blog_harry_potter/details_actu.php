<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
	<link rel='stylesheet' href="details.css">
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Détail de l'actualité</title>
</head>
<body>
<header>
<h1>Détails de l'actalité</h1>
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
    <?php
    include('config/bdd.php');
    include('config/outils.php');
    $lien=mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
    $num=nettoyage($lien, $_REQUEST['num']);
    $req="SELECT * FROM actus WHERE ida=$num";
    $res=mysqli_query($lien, $req);
    if(!$res) {
    echo "Erreur SQL $req<br>".mysqli_error($lien);
    }
    else {
    $tableau=mysqli_fetch_assoc($res);
    echo"<h2><span><i class='fas fa-heading'></i>Titre : </span>".$tableau['titre']."</h2>";
    echo"<p><span><i class='fas fa-user'></i>Auteur : </span>".$tableau['auteur']."</p>";
    echo "<p><span><i class='fas fa-align-left'></i>Contenu : </span>".$tableau['contenu']."</p>";
    echo "<p><span><i class='fas fa-calendar-alt'></i>Date : </span>".$tableau['date']."</p>";
    echo "<p><img src='".$tableau['image']."'></p>";
    echo"</tr>";
    }
mysqli_close($lien);

?>
<a href="./index.php">Retour à l'accueil</a>
</body>
</html>