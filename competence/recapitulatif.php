<?php 
    session_start();
    include 'config.php'; // ajout connexion bdd
    // si la session existe pas soit si l'on est pas connecté on redirige
    if(!isset($_SESSION['id'])){
        header('Location:index.php');
        die();
    }

    $reqIndicateurs = $bdd->prepare('SELECT * FROM indicateur WHERE IDENTIFIANT_ETUD = ?');
    $reqIndicateurs->execute([
        $_SESSION['id'],
    ]);
    $indicateurs = $reqIndicateurs->fetchAll();

    $reqSavoirs = $bdd->prepare('SELECT * FROM mobiliser WHERE IDENTIFIANT_ETUD = ?');
    $reqSavoirs->execute([
        $_SESSION['id'],
    ]);
    $savoirs = $reqSavoirs->fetchAll();

    $title = 'Récapitulatif';
    include 'elements/header.php';
?>
<div class="container">
    <h2 class="text-center"><strong><b>Récapitulatif de vos savoirs/indicateurs</b></strong></h2>
    <?php if(count($indicateurs) == 0 ):  ?>
    Aucuns indicateurs n'est enregistré. 
    <?php else: ?>
    <table class="table table-striped">
        <thead>
            <th>
                Indicateurs
            </th>
            <th>
                Libelle
            </th>
        </thead>
        <tbody>
        <?php foreach($indicateurs as $indicateur): ?>
            <tr>
                <td>
                    <?= $indicateur['N_ITEM'] ?>
                </td>
                <td>
                    <?= $indicateur['LIBEL_ITEM'] ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <hr>
    <?php if(count($savoirs) == 0): ?>
    Aucuns savoirs n'est enregistré. 
    <?php else: ?>
      <table class="table table-striped">
        <thead>
            <th>
                Savoirs
            </th>
            <th>
                Libelle
            </th>
        </thead>
        <tbody>
        <?php foreach($savoirs as $savoir): ?>
            <tr>
                <td>
                    <?= $savoir['N_ITEM'] ?>
                </td>
                <td>
                    <?= $savoir['LIBEL_ITEM'] ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
<?php include 'elements/footer.php'; ?>