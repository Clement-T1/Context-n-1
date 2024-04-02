<?php 
    session_start();
    include 'config.php'; // ajout connexion bdd
    // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['id'])){
        header('Location:index.php');
        die();
    }

    $req = $bdd->prepare('SELECT * FROM item_competence');
    $req->execute();
    $itemCompetences = $req->fetchAll();
    $title = 'Compétences';
    include 'elements/header.php'; 
?>
<div class="container">
    <div class="col-md-12">
        <div class="text-center">
        <h2 class="text-center"><strong><b>Compétence</b></strong></h2>
          <?php
          if(isset($_GET['reg_err']))
          {
            $err = htmlspecialchars($_GET['reg_err']);

            switch($err)
            {
              case 'success':
                ?>
                  <div class="alert alert-success">
                      Enregistrement effectué avec succès !
                  </div>
                <?php
                break;
              case 'error':
                ?>
                  <div class="alert alert-danger">
                      Veuillez renseigner vos compétences avant de valider !
                  </div>
                <?php
                break;
            }
          }
          ?>
            <form action="function/competence_traitement.php" method="post">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Acquis</th>
                            <th>En cours d'acquisition</th>
                            <th>Numéro Item</th>
                            <th>Compétences</th>
                            <th>Libelle compétences</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itemCompetences as $itemCompetence => $key): ?>
                        <tr>
                            <td><input type="checkbox" name="<?= $itemCompetence ?>_acquis" value="<?= $key['N_ITEM'] ?>"></td>
                            <td><input type="checkbox" name="<?= $itemCompetence ?>_enCoursAcquisition" value="<?= $key['N_ITEM'] ?>"></td>
                            <td><?= $key[0] ?></td>
                            <td><?= $key[1] ?></td>
                            <td><?= $key[2] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-success btn-lg mb-4">Enregistrer mes compétences</button>
            </form>
        </div>
    </div>
</div>
<?php include 'elements/footer.php'; ?>