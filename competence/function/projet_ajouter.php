<?php
session_start();
include '../config.php';
if(!isset($_SESSION['id'])){
  header('Location:index.php');
  die();
}

if ($_POST['libelle'] !== ''){
  $req = $bdd->prepare('INSERT INTO projet (IDENTIFIANT_ETUD, LIBELLE, URL, DATE_CREATED) VALUE (:IDENTIFIANT_ETUD, :LIBELLE, :URL, :DATE_CREATED)');
  $req->execute([
      'IDENTIFIANT_ETUD' => $_SESSION['id'],
      'LIBELLE' => $_POST['libelle'],
      'URL' => $_POST['url'],
      'DATE_CREATED' => date('Y-m-d'),
  ]);
  header('Location:../projet.php?reg_err=success');
}else{
  header('Location:../projet.php?reg_err=error');
}