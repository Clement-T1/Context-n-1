<?php

include '../config.php';

if(isset($_GET['token']) && $_GET['token'] != '')
{
  $stmt = $bdd->prepare('SELECT EMAIL_ETUD FROM etudiant WHERE TOKEN = ?');
  $stmt->execute([$_GET['token']]);
  $email = $stmt->fetchColumn();
  if ($email)
  {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Récupération du mot de passe</title>
    </head>
    <body>
      <form method="post">
        <label for="newPassword">Nouveau mot de passe :</label>
        <input type="password" name="newPassword">
        <input type="submit" value="Confirmer">
      </form>
    </body>
    </html>
    <?php
  }
}

if (isset($_POST['newPassword']))
{
  $cost = ['cost' => 12];
  $hashedPassword = password_hash($_POST['newPassword'], PASSWORD_BCRYPT, $cost);
  $sql = "UPDATE etudiant SET MOT_DE_PASSE_ETUD = ?, TOKEN = NULL WHERE EMAIL_ETUD = ?";
  $stmt = $bdd->prepare($sql);
  $stmt->execute([$hashedPassword, $email]);
  echo 'Mot de passe modifié avec succès !';
  header('Location: ../index.php');
}