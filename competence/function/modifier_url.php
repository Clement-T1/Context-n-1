<?php 
session_start();
include '../config.php'; // ajout connexion bdd
// si la session existe pas soit si l'on est pas connecté on redirige
if(!isset($_SESSION['id'])){
    header('Location:index.php');
    die();
}

$req = $bdd->prepare('UPDATE projet SET URL = ? WHERE ID = ?');
$req->execute([
    $_POST['URL'],
    $_GET['id'],
]);

header('Location:../edit_projet.php?id='.$_GET['id'].'&reg_err=success');