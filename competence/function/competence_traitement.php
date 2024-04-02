<?php
session_start();
require_once '../config.php'; // ajout connexion bdd
// si la session existe pas soit si l'on est pas connecté on redirige
if(!isset($_SESSION['id'])){
  header('Location:index.php');
  die();
}

if ($_POST){
  foreach ($_POST as $item => $key){
    $choix = strpos($item, 'acquis');
    $req = $bdd->prepare('SELECT * FROM acquerir WHERE IDENTIFIANT_ETUD = ? AND N_ITEM = ?');
    $req->execute([
        $_SESSION['id'],
        $key,
    ]);
    $data = $req->rowCount();

    if (count($data) >= 1 && $choix !== false){
      $req3 = $bdd->prepare('UPDATE acquerir SET ACQUISE = 1, EN_COURS_ACQUISITION = 0 WHERE IDENTIFIANT_ETUD = ? AND N_ITEM = ?');
      $req3->execute([
        $_SESSION['id'],
        $key,
      ]);
    }elseif ($data == 1 && $choix == false){
      $req3 = $bdd->prepare('UPDATE acquerir SET ACQUISE = 0, EN_COURS_ACQUISITION = 1 WHERE IDENTIFIANT_ETUD = ? AND N_ITEM = ?');
      $req3->execute([
        $_SESSION['id'],
        $key,
      ]);
    }

    $req2 = $bdd->prepare('INSERT INTO acquerir(IDENTIFIANT_ETUD, N_ITEM, ACQUISE, EN_COURS_ACQUISITION) VALUES(:IDENTIFIANT_ETUD, :N_ITEM, :ACQUISE, :EN_COURS_ACQUISITION)');
    if ($choix !== false){
      $req2->execute([
          'IDENTIFIANT_ETUD' => $_SESSION['id'],
          'N_ITEM' => $key,
          'ACQUISE' => 1,
          'EN_COURS_ACQUISITION'=> 0,
      ]);
    }else{
      $req2->execute([
          'IDENTIFIANT_ETUD' => $_SESSION['id'],
          'N_ITEM' => $key,
          'ACQUISE' => 0,
          'EN_COURS_ACQUISITION'=> 1,
      ]);
    }
  }
  header('Location:../competence.php?reg_err=success');
}else{
  header('Location:../competence.php?reg_err=error');
}