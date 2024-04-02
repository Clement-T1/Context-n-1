<?php
session_start();
include '../config.php';
if(!isset($_SESSION['id'])){
  header('Location:index.php');
  die();
}

    $req = $bdd->prepare('DELETE FROM indicateur WHERE N_ITEM = ? AND IDENTIFIANT_PROJ = ?');
    $req->execute([
    $_GET['indicateur'],
    $_GET['id'],
    ]);

    $reqProjet = $bdd->prepare('UPDATE projet SET DATE_MODIFY = :date WHERE ID = :id');
    $reqProjet->execute([
        'date' => date('Y-m-d'),
        'id' => $_GET['id'],
    ]);

header('Location:../edit_projet.php?id='. $_GET['id'].'&reg_err=indicateur_supprimer');