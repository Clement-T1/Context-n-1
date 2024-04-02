<?php
session_start();
include 'config.php';
if(!isset($_SESSION['id'])){
  header('Location:index.php');
  die();
}
$reqIndicateurs = $bdd->prepare('SELECT * FROM item_indicateur');
$reqIndicateurs->execute();
$indicateurs = $reqIndicateurs->fetchAll();

$reqSavoirs = $bdd->prepare('SELECT * FROM savoir');
$reqSavoirs->execute();
$savoirs = $reqSavoirs->fetchAll();

$reqProjet = $bdd->prepare('SELECT * FROM projet WHERE ID = ?');
$reqProjet->execute([
   $_GET['id'],
]);
$projet = $reqProjet->fetch();

$reqProjetSavoirs = $bdd->prepare('SELECT * FROM mobiliser WHERE IDENTIFIANT_PROJ = ?');
$reqProjetSavoirs->execute([
    $_GET['id'],
]);
$projetSavoirs = $reqProjetSavoirs->fetchAll();

$reqProjetIndicateurs = $bdd->prepare('SELECT * FROM indicateur WHERE IDENTIFIANT_PROJ = ?');
$reqProjetIndicateurs->execute([
    $_GET['id'],
]);
$projetIndicateurs = $reqProjetIndicateurs->fetchAll();

$title = 'Modification du projet '. $_GET['id'];
setlocale(LC_TIME, "fr_FR");
include 'elements/header.php';
?>

<div class="container">
  <?php
  if(isset($_GET['reg_err']))
  {
    $err = htmlspecialchars($_GET['reg_err']);

    switch($err)
    {
      case 'success':
        ?>
            <div class="alert alert-success text-center">
              Enregistrement effectué avec succès !
            </div>
        <?php
        break;

        case 'indicateur_supprimer':
        ?>
            <div class="alert alert-success text-center">
                Indicateur supprimer avec succès !
            </div>
        <?php
        break;
        case 'error':
        ?>
            <div class="alert alert-danger text-center">
              Veuillez renseigner une option valide !
            </div>
        <?php
        break;
    }
  }
  ?>
  <?php if ($projet == false): ?>
  <div class="text-center">
    <h1 class="text-danger"><strong>Aucun projet n'est lié à cette ID : <?= $_GET['id'] ?></strong></h1>
  </div>
  <?php else: ?>
  <h1 class="text-center mb-4"><strong>Voici votre projet : <?= $projet['LIBELLE'] ?></strong></h1>

  <?php if (count($projetSavoirs) == 0): ?>

  <?php else: ?>
      <table class="table table-striped w-100">
        <thead>
            <th>Savoir</th>
            <th>Description</th>
            <th>Supprimer</th>
        </thead>
        <tbody>
            <?php foreach($projetSavoirs as $projetSavoir): ?>
            <form method="post" action="function/supprimer_savoir.php?savoir=<?= $projetSavoir['N_ITEM'] ?>&id=<?= $projet['ID'] ?>">
              <tr>
                <td>
                    <?= $projetSavoir['N_ITEM'] ?>
                </td>
                 <td>
                    <?= $projetSavoir['LIBEL_ITEM'] ?>
                </td>
                <td>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </td>
              </tr>
            </form>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
  <br>
  <?php if (count($projetIndicateurs) == 0): ?>

  <?php else:  ?>
      <table class="table table-striped w-100">
          <thead>
            <th class="text-center">Indicateur</th>
            <th class="text-center">Description</th>
            <th class="text-center">Supprimer</th>
          </thead>
          <tbody>
            <?php foreach($projetIndicateurs as $projetIndicateur): ?>
            <form method="post" action="function/supprimer_indicateur.php?indicateur=<?= $projetIndicateur['N_ITEM'] ?>&id=<?= $projet['ID'] ?>">
                <tr>
                    <td class="text-center">
                        <?= $projetIndicateur['N_ITEM'] ?>
                    </td>
                    <td class="text-center">
                        <?= $projetIndicateur['LIBEL_ITEM'] ?>
                    </td>
                    <td class="text-center">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </td>
                </tr>
            </form>
            <?php endforeach; ?>
          </tbody>
      </table>
  <?php endif; ?>
    <button type="button" class="btn btn-info btn-lg mt-4 mb-4" data-toggle="modal" data-target="#indicateur">
        Ajouter un indicateur au projet
    </button>
    <button type="button" class="btn btn-info btn-lg mt-4 mb-4" data-toggle="modal" data-target="#savoir">
        Ajouter un savoir au projet
    </button>

    <form action="function/modifier_url.php?id=<?= $_GET['id'] ?>" method="post">
    <div class="form-group">
        <label for="URL">
            <input type="text" class="form-control" name="URL" id="URL" value="<?= $projet['URL'] ?>">
        </label>
    </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
        <p class="text-right">Date de Création : <?= strftime("%A %d %B %G", strtotime($projet['DATE_CREATED'])); ?></p>
        <p>Date de dernière Modification : <?php 
        if($projet['DATE_MODIFY'] == null){
            echo 'Aucune modification n\'a été apporté pour le moment';
        }
        else {
            echo strftime("%A %d %B %G", strtotime($projet['DATE_MODIFY']));
        }
        ?></p>
  </div>

<?php include "elements/footer.php"; ?>

<?php endif; ?>

<!-- Modal indicateur -->
<div class="modal fade" id="indicateur" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter un indicateur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="function/ajouter_indicateur.php?id=<?= $_GET['id'] ?>">
          <div class="form-group">
            <label for="indicateur">Choississez un indicateur</label>
            <select name="indicateur" id="indicateur" class="form-control">
              <option value="" selected disabled>-- Indicateur --</option>
              <?php foreach ($indicateurs as $indicateur): ?>
                <option value="<?= $indicateur['N_ITEM'] ?>"><?= $indicateur['LIBEL_ITEM'] ?></option>
              <?php endforeach; ?>
            </select>
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

<!-- Modal savoir -->
<div class="modal fade" id="savoir" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajouter un savoir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="function/ajouter_savoir.php?id=<?= $_GET['id'] ?>">
          <div class="form-group">
            <label for="savoir">Choississez un savoir</label>
            <select name="savoir" id="savoir" class="form-control">
              <option value="" selected disabled>-- savoir --</option>
              <?php foreach ($savoirs as $savoir): ?>
                <option value="<?= $savoir['N_ITEM'] ?>"><?= $savoir['LIBEL_ITEM'] ?></option>
              <?php endforeach; ?>
            </select>
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