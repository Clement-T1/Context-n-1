<?php
session_start();
include 'config.php';
if(!isset($_SESSION['id'])){
header('Location:index.php');
die();
}

$req = $bdd->prepare('SELECT * FROM projet WHERE IDENTIFIANT_ETUD = ?');
$req->execute([
   $_SESSION['id'],
]);
$projets = $req->fetchAll();

setlocale(LC_TIME, "fr_FR");

$title = 'Projet';
include 'elements/header.php';
?>

<div class="container">
    <h2 class="text-center"><strong><b>Projet</b></strong></h2>
  <?php
  if(isset($_GET['reg_err']))
  {
    $err = htmlspecialchars($_GET['reg_err']);

    switch($err)
    {
      case 'success':
        ?>
          <div class="alert alert-success text-center">
              Projet enregisté avec succès !
          </div>
        <?php
        break;
        case 'suppression':
        ?>
          <div class="alert alert-success text-center">
              Suppression effectué avec succès !
          </div>
        <?php
        break;
        case 'error':
        ?>
          <div class="alert alert-danger text-center">
              Veuillez renseigner le nom de votre projet !
          </div>
        <?php
        break;
    }
  }
  ?>
    <div class="text-right">
        <!-- Button trigger modal projet -->
        <button type="button" class="btn btn-info btn-lg mt-4 mb-4" data-toggle="modal" data-target="#projet">
            Ajouter un projet
        </button>
    </div>

    <?php if (count($projets) == 0): ?>
    <div>Aucun projet pour l'instant. Ajouter en-un.</div>
    <?php else: ?>
    <form method="post" action="edit_projet.php">
        <table class="table table-striped">
            <thead class="thead-dark">
            <th>Nom du projet</th>
            <th>URL</th>
            <th>Date de création</th>
            <th>Date dernière modification</th>
            <th>Modifier</th>
            <th>Supprimer</th>
            </thead>
            <tbody>
            <?php foreach ($projets as $projet => $key): ?>
                <tr>
                    <td><?= $key['LIBELLE'] ?></td>
                    <td><a href="https://<?= $key['URL'] ?>" target="_blank"><?= $key['URL'] ?></a></td>
                    <td><?= strftime("%A %d %B %G", strtotime($key['DATE_CREATED'])); ?></td>
                    <td><?php if($key['DATE_MODIFY'] == null){
                        echo 'Aucune modification n\'a été apportée pour le moment';
                    } else{
                        echo strftime("%A %d %B %G", strtotime($key['DATE_MODIFY']));
                    } ?></td>
                    <td><a href="edit_projet.php?id=<?= $key['ID'] ?>"><i class="fa-solid fa-pencil" style="color: dodgerblue"></i></a></td>
                    <td><a href="#" data-toggle="modal" data-target="#confirmation"<i class="fa-solid fa-trash" style="color: red"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </form>
    <?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="projet" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter un projet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="function/projet_ajouter.php">
          <div class="form-group">
            <label for="libelle">Libelle du projet</label>
            <input type="text" name="libelle" id="libelle" class="form-control">
          </div>
          <div class="form-group">
            <label for="url">url du projet</label>
            <input type="text" name="url" id="url" class="form-control">
            <small class="form-text text-muted">L'url n'est pas obligatoire</small>
          </div>
          <div class="mt-4">
              <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger w-100" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal confirmation-->
<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation de suppression du projet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="function/supprimer_projet.php?id=<?= $key['ID'] ?>">
                    <div class="form-group">
                        <p>Attention, si vous supprimez ce projet, tous les indicateurs et les savoirs lié à celui-ci vont disparaître !</p>
                        <p>Voulez-vous vraiment supprimer ce projet ?</p>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100">Supprimer</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger w-100" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<?php include 'elements/footer.php'; ?>
