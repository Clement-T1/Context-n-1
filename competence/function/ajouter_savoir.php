<?php
session_start();
include '../config.php';
if(!isset($_SESSION['id'])){
  header('Location:index.php');
  die();
}

if (count($_POST) !== 0){

  $reqDescription = $bdd->prepare('SELECT LIBEL_ITEM FROM savoir WHERE N_ITEM = ?');
  $reqDescription->execute([
      $_POST['savoir'],
  ]);
  $description = $reqDescription->fetch();

  $req = $bdd->prepare('INSERT INTO mobiliser (N_ITEM, IDENTIFIANT_PROJ, IDENTIFIANT_ETUD, LIBEL_ITEM) VALUE (:N_ITEM, :IDENTIFIANT_PROJ, :IDENTIFIANT_ETUD, :LIBEL_ITEM)');
  $req->execute([
      'N_ITEM' => $_POST['savoir'],
      'IDENTIFIANT_PROJ' => $_GET['id'],
      'IDENTIFIANT_ETUD' => $_SESSION['id'],
      'LIBEL_ITEM' => $description['LIBEL_ITEM'],
  ]);

 $reqProjet = $bdd->prepare('UPDATE projet SET DATE_MODIFY = :date WHERE ID = :id');
 $reqProjet->execute([
     'date' => date('Y-m-d'),
     'id' => $_GET['id'],
 ]);

  header('Location:../edit_projet.php?id='. $_GET['id']."&reg_err=success");
}else{
  header('Location:../edit_projet.php?id='.$_GET['id']."&reg_err=error");
}