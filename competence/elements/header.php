<?php
if (isset($data)){
  foreach (scandir("upload/") as $fichier){
    if($fichier == $_SESSION['id']){
      foreach(scandir("upload/" . $_SESSION['id']) as $image => $key){
        if($key == $data['AVATAR']){
          $_SESSION['AVATAR'] = $key;
        }
      }
    }
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title><?php echo $title ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <?php if(isset($_SESSION['AVATAR'])){ ?>
        <div style="background: url(<?= 'upload/' . $_SESSION['id'] . '/' . $_SESSION['AVATAR']?>) no-repeat center; background-size: cover; width: 70px; height: 70px"></div>
    <?php } ?>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
              <li <?php if ($_SERVER['PHP_SELF'] == '/competence/profil.php'){?> class="nav-item active"<?php }else{ ?> class="nav-item" <?php } ?>>
                  <a class="nav-link" href="profil.php">Profil</a>
              </li>
              <li <?php if ($_SERVER['PHP_SELF'] == '/competence/competence.php'){?> class="nav-item active"<?php }else{ ?> class="nav-item" <?php } ?>>
                  <a class="nav-link" href="competence.php">Compétence</a>
              </li>
              <li <?php if ($_SERVER['PHP_SELF'] == '/competence/indicateur.php'){?> class="nav-item active"<?php }else{ ?> class="nav-item" <?php } ?>>
                  <a class="nav-link" href="indicateur.php">Indicateur</a>
              </li>
              <li <?php if ($_SERVER['PHP_SELF'] == '/competence/savoir.php'){?> class="nav-item active"<?php }else{ ?> class="nav-item" <?php } ?>>
                  <a class="nav-link" href="savoir.php">Savoir</a>
              </li>
              <li <?php if ($_SERVER['PHP_SELF'] == '/competence/projet.php'){?> class="nav-item active"<?php }else{ ?> class="nav-item" <?php } ?>>
                  <a class="nav-link" href="projet.php">projet</a>
              </li>
              <li <?php if ($_SERVER['PHP_SELF'] == '/competence/recapitulatif.php'){?> class="nav-item active"<?php }else{ ?> class="nav-item" <?php } ?>>
                  <a class="nav-link" href="recapitulatif.php">Récapitulatif</a>
              </li>
          </ul>
      </div>
      <ul class="navbar-nav ml-auto">
          <a href="deconnexion.php" class="btn btn-danger text-right">Déconnexion</a>
      </ul>
  </nav>