<?php
session_start();
include '../config.php';
$title = 'Profil';

if(!isset($_SESSION['id'])){
    header('Location:index.php');
    die();
}

var_dump($_GET['id']);
die;

$reqIndicateur = $bdd->prepare('DELETE FROM indicateur WHERE IDENTIFIANT_PROJ = ?');
$reqIndicateur->execute([
    $_GET['id'],
]);

$reqSAvoir = $bdd->prepare('DELETE FROM mobiliser WHERE IDENTIFIANT_PROJ = ?');
$reqSAvoir->execute([
    $_GET['id'],
]);

$supprimerProjet = $bdd->prepare('DELETE FROM projet WHERE ID = ?');
$supprimerProjet->execute([
    $_GET['id'],
]);

header('Location:../projet.php?reg_err=suppression');