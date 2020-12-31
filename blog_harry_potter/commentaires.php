<!doctype html> 
<html>
	<head> 
		<meta charset="utf-8">
	</head> 
	<body>
		<form method="POST">
			<input type="text" name="nom" placeholder="Nom"><br>
			<textarea name="commentaire" placeholder="Commentaire"></textarea><br>
			<input type="submit" value="Envoyer" name="envoyer">
		</form>
		<?php
			$lien=mysqli_connect("localhost","root","root","tp");
			
			//Ajout d'un commentaire
			if(isset($_POST['envoyer']))
			{
				$nom=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['nom'])));
				$commentaire=trim(htmlentities(mysqli_real_escape_string($lien,$_POST['commentaire'])));
				$req="INSERT INTO commentaires VALUES (NULL,'$nom','$commentaire')";
				$res=mysqli_query($lien,$req);
				if(!$res)
				{
					echo "Erreur SQL:$req<br>".mysqli_error($lien);
				}
			}
			
			//Quelle page je suis et quels commentaires prendre
			if(!isset($_GET['page']))
			{
				$page=1;
			}
			else
			{
				$page=$_GET['page'];
			}
			$commparpage=5;
			$premiercomm=$commparpage*($page-1);
			$req="SELECT * FROM commentaires ORDER BY id LIMIT $premiercomm,$commparpage";//LIMIT dit ou je commence et combien j'en prends
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				while($tableau=mysqli_fetch_array($res))
				{
					echo "<h2>".$tableau['nom']."</h2>";
					echo "<p>".$tableau['commentaire']."</p>";
				}
			}
			
			//Affichage des numéros de page
			$req="SELECT * FROM commentaires";
			$res=mysqli_query($lien,$req);
			if(!$res)
			{
				echo "Erreur SQL:$req<br>".mysqli_error($lien);
			}
			else
			{
				$nbcomm=mysqli_num_rows($res); // Retourne le nombre de lignes dans un résultat. 
				$nbpages=ceil($nbcomm/$commparpage); /*Ceil arrondit a l'entier supérieur*/
				echo "<br> Pages : ";
				echo "<a href='commentaires.php?page=1'> Début </a>";
				echo "<a href='commentaires.php?page=".($page-1)."'> Précédente </a>";
				for($i=($page);$i<=($page+1);$i++)
                {
                    echo "<a href='commentaires.php?page=$i'> $i </a>";
                }
				echo "<a href='commentaires.php?page=".($page+1)."'> Suivante </a>";
				echo "<a href='commentaires.php?page=$nbpages'> Fin </a>";
			}
			mysqli_close($lien);
		?>	
	</body>
</html>