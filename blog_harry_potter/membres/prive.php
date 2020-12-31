<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Page privé</h1>
    <?php
    session_start();

    if(!isset($_SESSION['idm']) or !isset($_SESSION['nom']) or !isset($_SESSION['prenom']) or !isset($_SESSION['email'])) {
        header("Location: ../index.php");
    }

    else {
        echo "<p>Bonjour ".$_SESSION['prenom']." ".$_SESSION['nom']."</p>";
    }
    ?>

    <a href="deconnexion.php">Se déconnecter</a>
    <a href="../index.php">Retour à l'accueil</a>
</body>
</html>