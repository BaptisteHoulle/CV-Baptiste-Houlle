<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
    <link rel='stylesheet' href="login.css">
    <link rel='stylesheet' href="modif.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <header>
        <h1>Se rendre à poudlard (connexion)</h1>
        <?php
	echo"<nav>";
    echo"<input type='checkbox' id='check'>";
    echo"<label for='check' class='checkbtn'>";
    echo"<i class='fas fa-bars'></i>";
    echo"</label>";
    echo"<ul>";
    echo "<li> <a href='./index.php'><i class='fas fa-home'></i>Retour à l'accueil</a></li>";
    echo"</ul>";
    echo"</nav>";
    ?>
    </header>
    <form action="" method="post">
    <h2>Passer la voie 9<sup>3/4</sup></h2>
        <div>
        <input type="email" name="email" id="email" placeholder="Quelle est votre adresse Mail ?">
            <label for="email">E-Mail</label>
        </div>
        <div>
            <input type="password" id="password" name="mdp" placeholder="Entrez Votre mot de passe"/>
            <label for="password">Mot de passe</label>
        </div>
        <input type="submit" name="connexion" value="Connexion" class="button">
    </form>
    <?php
        if(isset($_REQUEST['connexion'])) {
            include('config/bdd.php');
            include('config/outils.php');
            $lien=mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
            $email=nettoyage($lien, $_REQUEST['email']);
            $mdp=md5($_REQUEST['mdp']);
            $req="SELECT * FROM membres WHERE email='$email' AND mdp='$mdp'";
            $res=mysqli_query($lien, $req);

            if(!$res) {
                echo "Erreur SQL $req<br>".mysqli_error($lien);
            
            }
            else {
                $nb=mysqli_num_rows($res);
                $tableau=mysqli_fetch_array($res);
                if(($nb==1) and ($tableau['actif']==1)) {
                   
                    session_start();
                    $_SESSION['idm']=$tableau['idm'];
                    $_SESSION['nom']=$tableau['nom'];
                    $_SESSION['prenom']=$tableau['prenom'];
                    $_SESSION['email']=$tableau['email'];
                    $_SESSION['admin']=$tableau['admin'];
                    mysqli_close($lien);
                    header("Location: ./index.php");
                }

                else {
                    echo "<p class='utilise'>Informations incorrectes</p>";
                }
            }
            
            mysqli_close($lien);
        }

    ?>
    <script src="main.js"></script>
</body>

</html>