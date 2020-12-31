<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
    <link rel='stylesheet' href="../inscription.css">
	<link rel="stylesheet" href="../modif.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <header>
        <h1>Ajout d'un membre</h1>

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
    <h2>S'inscire en première année</h2>
    <form method="post" enctype="multipart/form-data">
        <div>
            <input type="text" name="nom" id="nom" placeholder="Insérez votre nom ici">
            <label for="nom">Nom</label>
        </div>
        <div>
            <input type="text" name="prenom" id="prenom" placeholder="Insérez votre prénom ici">
            <label for="prenom">Prénom</label>
        </div>
        <div>
            <input type="email" name="email" id="email" placeholder="Insérez votre adresse mail ici">
            <label for="email">email</label>
        </div>
        <div>
            <input type="password" name="mdp1" id="mdp1" placeholder="Insérez votre mot de passe ici">
            <label for="mdp1">Mot de passe</label>
        </div>
        <div>
            <input type="password" name="mdp2" id="mdp2" placeholder="Insérez confirmer votre mot de passe ici">
            <label for="mdp2">Confirmation</label>
        </div>
        <input type="submit" name="inscription" value="inscription" class="button">
    </form>
	<?php
			if(isset($_REQUEST['inscription']))
			{
				include('../config/bdd.php');
				include('../config/outils.php');
				$lien=mysqli_connect(SERVEUR,LOGIN,MDP,BASE);
				$nom=nettoyage($lien,$_REQUEST['nom']);
				$prenom=nettoyage($lien,$_REQUEST['prenom']);
				$email=nettoyage($lien,$_REQUEST['email']);
				$mdp1=md5($_REQUEST['mdp1']);
				$mdp2=md5($_REQUEST['mdp2']);
				
				if($mdp1==$mdp2)
				{
					$req="SELECT * FROM membres WHERE email='$email'";
					$res=mysqli_query($lien,$req);
					if(!$res)
					{
						echo "Erreur SQL: $req<br>".mysqli_error($lien);
					}
					else
					{
						$nb=mysqli_num_rows($res);
						if($nb==0)
						{
							$req="INSERT INTO membres VALUES(NULL,'$email','$nom','$prenom','$mdp1',0,0)";
							$res=mysqli_query($lien,$req);
							if(!$res)
							{
								echo "Erreur SQL: $req<br>".mysqli_error($lien);
							}
							else
							{
								echo "<p class='grand'>Demande d'Inscription réussie, veuillez attendre qu'un administrateur valide votre demande.</p>";
							}
						}
						else 
						{
							echo "<p class='utilise'>Adresse email déjà utilisée !</p>";
						}
					}	
				}
				else
				{
					echo "<p class='utilise'>Les mots de passe sont différents !</p>";
				}
				mysqli_close($lien);
			}
		?>
</body>

</html>