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
    <link rel='stylesheet' href="details.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Modifier l'actualité</title>
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
        <h1>Modification d'une actualité</h1>
    </header>
    <?php
            include('config/bdd.php');
            include('config/outils.php');
            $lien=mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
            $num=$_REQUEST['num'];

            if(isset($_REQUEST['modifier']))
            {
                $titre=nettoyage($lien, $_REQUEST['titre']);
                $contenu=nettoyage($lien, $_REQUEST['contenu']);

                if($_FILES['image']['name']=="")
                {
                    $req="UPDATE actus SET titre='$titre', contenu='$contenu' WHERE ida=$num";
                }
                else{
                    $extensionsvalides=array('gif', 'jpg', 'png', 'jpeg', 'svg');
                    $extension=strtolower(substr(strrchr($_FILES['image']['name'],"."),1));
                    //strrch = coupe à la dernière occurence du paramètre
                    //substr = coupe le morceau après le ième caractère
                    //strtolower = mets en minuscule

                    if(in_array($extension, $extensionsvalides))
                    {
                        $destination="images/".uniqid().".$extension";
                        $envoi=move_uploaded_file($_FILES['image']['tmp_name'],$destination);//tmp_name nom du fichier géré par le navigateur
                        if(!$envoi)
                        {
                            echo "Erreur de transfert<br>";
                            $destination="";
                        }
                    }
                    else
                    {
                        echo "Pas d'image ou image invalide<br>";
                        $destination="";
                    }
                    if($destination=="")
                    {
                        $req="UPDATE actus SET titre='$titre', contenu='$contenu' WHERE ida=$num";
                    }
                    else
                    {
                        $req="UPDATE actus SET titre='$titre', contenu='$contenu', image='$destination' WHERE ida=$num";

                    }
                }



                $res=mysqli_query($lien, $req);

                if(!$res)
                {
                    echo "Erreur SQL:$req<br>".mysqli_error($lien);
                    unlink($destination);
                }
                else
                {
                    echo "Actualité modifiée !<br>";
                    if(($_REQUEST['ancienneimage']!="")&&($_FILES['image']['name']!=""))
                    {
                        unlink($_REQUEST['ancienneimage']);
                    }
                }
            }


            $req="SELECT * FROM actus WHERE ida=$num";
            $res=mysqli_query($lien, $req);

            if(!$res)
            {
                echo "Erreur SQL:$req<br>".mysqli_error($lien);
            }
            else
            {
                $tableau=mysqli_fetch_array($res);
                if(($tableau['auteur']!=$_SESSION['idm']) and ($_SESSION['admin']==0))  {
                    mysqli_close($lien);
                    header("Location: ./index.php");
                    exit;
                }
            ?>
    <form method="post" enctype="multipart/form-data">
        <div>
            <input type="text" name="titre" id="titre" placeholder="Quel sera le nouveau titre de l'article ?">
            <label for="titre">Titre</label>
        </div>
        <div>
            <textarea name="contenu" id="contenu" placeholder="Quel sera le nouveau contenu de l'article ?"></textarea>
            <label for="contenu">contenu</label>
            <p class="ancienne">Ancienne image :</p>
            <img src="<?php echo $tableau['image'];?>">
        </div>
        <div class="image">
            <input type="file" name="image" id="image" placeholder="Quel sera la nouvelle image de l'article ?">
            <label for="image">Image</label>
            <input type="submit" name="modifier" id="modifier" value="Modifier l'actualité">
        </div>
        <div>
            <input type="hidden" name="num" value="<?php echo $num;?>">
            <input type="hidden" name="ancienneimage" value="<?php echo $tableau['image'];?>">
        </div>
    </form>
    <?php
            }
            mysqli_close($lien);
        ?>
        <script src="main.js"></script>
</body>

</html>