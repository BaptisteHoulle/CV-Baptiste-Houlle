<?php
    session_start();

    if(!isset($_SESSION['idm']) or !isset($_SESSION['nom']) or !isset($_SESSION['prenom']) or !isset($_SESSION['email'])) {
        header("Location: ../index.php");
    }

    ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Righteous&display=swap" rel="stylesheet">
    <link rel='stylesheet' href="./inscription.css">
    <link rel='stylesheet' href="./modif.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
    <header>
        <h1>Ajout d'une actualité</h1>


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


    <h2>Écrire avec la plume de Rita Skeeter</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <input type="text" name="titre" id="titre" placeholder="Insérez votre titre ici">
            <label for="titre">Titre</label>
        </div>
        <div>
            <textarea name="contenu" id="contenu" placeholder="Insérez votre commentaire ici"></textarea>
            <label for="contenu">Commentaire</label>
        </div>
        <div>
            <input type="text" name="auteur" id="auteur" placeholder="Quel est l'auteur de cette publication ?">
            <label for="auteur">Auteur</label>
        </div>
        <div>
            <input type="datetime" name="date" id="date" placeholder="À quel date est créé cet article ?">
            <label for="date">Date</label>
        </div>
        <div>
            <input type="file" name="image" id="image">
            <label for="image">Image</label>
        </div>
        <input type="submit" name="ajouter" value="Envoyer"> <br>
    </form>

    <?php
    include('config/bdd.php');
    include('config/outils.php');

    if(isset($_REQUEST['ajouter'])) {
        $lien=mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
        $titre=nettoyage($lien, $_REQUEST['titre']);
        $contenu=nettoyage($lien, $_REQUEST['contenu']);
        $auteur=$_SESSION['idm'];
        $date=date("Y-m-d H:i:s");
        $extensionsvalides=array('gif','jpg','png','jpeg','svg');
        $extension=strtolower(substr(strrchr($_FILES['image']['name'],"."),1));
        //strrchr = coupe à la dernière occurence du parametre
        //substr = coupe le morceau après ième caractere
        //strtolower = met en minuscule
       if(in_array($extension, $extensionsvalides)){
           $destination="images/".uniqid().".$extension";
           $envoi=move_uploaded_file($_FILES['image']['tmp_name'],$destination);
           if(!$envoi) {
                echo "Erreur de transfert<br>";
                $destination="";
           }
       }
       else {
           echo "Pas d'image ou image invalide<br>";
           $destination="";
       }
        
       
       
        $req="INSERT INTO actus VALUES(NULL, '$titre', '$contenu', '$auteur', '$date', '$destination')";
    $res=mysqli_query($lien, $req);
    
    if(!$res) {
        echo "Erreur SQL $req<br>".mysqli_error($lien);
    
    }
    else {
        echo "<p class='reussie'>Ajout de l'actualité réussi</p>";
    }
    
    mysqli_close($lien);
}

    ?>
    <script src="main.js"></script>
</body>

</html>