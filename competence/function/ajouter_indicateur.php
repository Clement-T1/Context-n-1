<?php
session_start();
include '../config.php';
if(!isset($_SESSION['id'])){
  header('Location:../index.php');
  die();
}

if (count($_POST) !== 0){

  $reqDesciption = $bdd->prepare('SELECT LIBEL_ITEM FROM item_indicateur WHERE N_ITEM = ?');
  $reqDesciption->execute([
      $_POST['indicateur'],
  ]);
  $description = $reqDesciption->fetch();

  $req = $bdd->prepare('INSERT INTO indicateur (IDENTIFIANT_PROJ, N_ITEM, IDENTIFIANT_ETUD, LIBEL_ITEM) VALUE (:IDENTIFIANT_PROJ, :N_ITEM, :IDENTIFIANT_ETUD, :LIBEL_ITEM)');
  $req->execute([
     'IDENTIFIANT_PROJ' => (int)$_GET['id'],
     'N_ITEM' => $_POST['indicateur'],
     'IDENTIFIANT_ETUD' => $_SESSION['id'],
     'LIBEL_ITEM' => $description['LIBEL_ITEM'],
  ]);

 $reqProjet = $bdd->prepare('UPDATE projet SET DATE_MODIFY = :date WHERE ID = :id');
 $reqProjet->execute([
     'date' => date('Y-m-d'),
     'id' => $_GET['id'],
 ]);

  header('Location:../edit_projet.php?id='.$_GET['id']."&reg_err=success");
}else{
  header('Location:../edit_projet.php?id='.$_GET['id']."&reg_err=error");
}