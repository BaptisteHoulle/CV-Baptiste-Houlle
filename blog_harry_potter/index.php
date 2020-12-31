<?php
session_start();

if(!isset($_SESSION['idm']) or !isset($_SESSION['nom']) or !isset($_SESSION['prenom']) or !isset($_SESSION['email'])) {
	$connecte=false;
}
else {
	$connecte=true;
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
	<link rel='stylesheet' href="style.css">
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>

</head>

<body>
	<header>
		<h1>Potter blog</h1>
		<?php
		if ($connecte==false) {
			echo"<nav>";
			echo"<input type='checkbox' id='check'>";
			echo"<label for='check' class='checkbtn'>";
			echo"<i class='fas fa-bars'></i>";
			echo"</label>";
			echo"<ul>";
			echo "<li><a href='./login.php'><i class='fas fa-user'></i>Se rendre à poudlard (connexion)</a></li>";
			echo "<li><a href='membres/inscriptions.php'><i class='fas fa-user-plus'></i>Faire sa lettre à poudlard (s'inscrire)</a>";
			echo"</ul>";
			echo"</nav>";
		}
		else {  
			echo"<nav>";
			echo"<input type='checkbox' id='check'>";
			echo"<label for='check' class='checkbtn'>";
			echo"<i class='fas fa-bars'></i>";
			echo"</label>";
			echo"<ul>";
			echo "<li><a href='./ajout_actu.php'><i class='fas fa-plus-circle'></i>Ajouter une actualité</a></li>";
			echo "<li><a href='../membres/modif_mdp.php'><i class='fas fa-key'></i>Modifier son mot de passe</a></li>";
			echo "<li><a href='../membres/deconnexion.php'><i class='fas fa-sign-out-alt'></i>Partir de poudlard</a></li>";
			echo"</ul>";
			echo"</nav>";
		}

		
		?>
	</header>


	<?php
		include('config/bdd.php');
		$lien=mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
			$req="SELECT * FROM actus";
			$res=mysqli_query($lien, $req);
			
			if(!$res)
			{
				echo "Erreur SQL: $req<br>".mysqli_error($lien);
			}
			else
			{
				echo "<h2><i class='fas fa-newspaper'></i>La gazette du sorcier</h2>";
				echo "<a href='ajout_actu.php' class='svg-wrapper'>
				<svg height='60' width='320' xmlns='http://www.w3.org/2000/svg'><rect class='shape' height='60' width='320'/>
				</svg>
				<div class='text'><i class='fas fa-plus-circle'></i>Ajouter une actualité</div>
			</a>";
			
		if(($connecte==true) and (($_SESSION['idm']==mysqli_fetch_assoc($res)['auteur']) or ($_SESSION['admin']==1))) {
			echo"<h2><i class='fas fa-user-cog'></i>Espace administrateur</h2>";
			$prenom=$_SESSION['prenom'];
			$nom=$_SESSION['nom'];
			echo "<p class='admin'>Bonjour<span> $prenom $nom </span>vous êtes actuellement administrateur sur le blog !</p>";
			//echo "<div><i class='fas fa-user-check'></i>Faire passer les premières années à poudlard (activer)</div>";
			echo "<a href='../membres/activation.php' class='svg-wrapper'>
				<svg height='60' width='320' xmlns='http://www.w3.org/2000/svg'><rect class='shape' height='60' width='320'/>
				</svg>
					<div class='text'><i class='fas fa-user-check'></i>Activer les pass 9<sup>3/4</sup></div>	
			</a>";
		}

		else {
			echo "";
		}

				echo "<table class='cont'>";
				echo "<tr>
					<th><i class='far fa-calendar-alt'></i>Date de publication</th>
					<th><i class='fas fa-heading'></i>Titre & image</th>
					<th><i class='far fa-edit'></i>Modifier l'article</th>
					<th><i class='fas fa-trash-alt'></i>Supprimer l'article</th>
				</tr>";
			
				while($tableau=mysqli_fetch_assoc($res))
				{
					
					echo "<tr>";
					echo "<td><i class='far fa-calendar-alt'></i>".$tableau['date']."</td>";
					echo "<td><a href='details_actu.php?num=".$tableau['ida']."'><p class='titlea'><i class='fas fa-heading'></i></a><a href='details_actu.php?num=".$tableau['ida']."'>".$tableau['titre']."</p><p class='imgtable'><img src='".$tableau['image']."'></p></a></td>";
					//<td><a href='details_actus.php?num=1'>Titre</a></td>
					if( ($connecte==true) and ( ($_SESSION['idm']==$tableau['auteur']) or ($_SESSION['admin']==1)))
					{
						echo "<td><a href='modif-actus.php?num=".$tableau['ida']."'><i class='far fa-edit'></i></a><a href='modif-actus.php?num=".$tableau['ida']."'>Modifier</a></td>";
						echo "<td><a href='suppr_actus.php?num=".$tableau['ida']."'><i class='fas fa-trash-alt'></i></a><a href='suppr_actus.php?num=".$tableau['ida']."'>Supprimer</a></td>";
					}
				
					echo "</tr>";
					
				}
				echo "</table>";
			}	
			mysqli_close($lien);
		?>
	<script src="main.js"></script>
</body>

</html>