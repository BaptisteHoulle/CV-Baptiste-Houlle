<?php
session_start();

if(!isset($_SESSION['idm']) or !isset($_SESSION['nom']) or !isset($_SESSION['prenom']) or !isset($_SESSION['email'])) {
	header("Location: ../index.php");
}

else {
	echo "<p>Bonjour ".$_SESSION['prenom']." ".$_SESSION['nom']."</p>";
}

include('config/bdd.php');
include('config/outils.php');
$lien=mysqli_connect(SERVEUR, LOGIN, MDP, BASE);
	$num=nettoyage($lien, $_REQUEST['num']);

	$req="DELETE FROM actus WHERE ida=$num";
	$res=mysqli_query($lien, $req);
	if(!$res)
	{
		echo "Erreur SQL: $req<br>".mysqli_error($lien);
	}
	else
	{
		$tableau=mysqli_fetch_array($res);
		if(($tableau['auteur']!=$_SESSION['idm']) and ($_SESSION['admin']==0)) {
                    mysqli_close($lien);
                    header("Location: ./index.php");
                    exit;
                }
	
		if($tableau['image']!="") {
			unlink($tableau['image']);//supression d'un fichier en ligne
		}
		mysqli_close($lien);
		header("Location: ./index.php");
	}	

	$req="DELETE FROM actus WHERE ida=$num";
	$res=mysqli_query($lien, $req);
	if(!$res)
	{
		echo "Erreur SQL: $req<br>".mysqli_error($lien);
	}
	else
	{
		
		mysqli_close($lien);
		header("Location: ./index.php");
	}	
?>