<?php 
    session_start();
    include 'config.php';
    if(!isset($_SESSION['id'])){
      header('Location:index.php');
      die();
    }
       
    $req2 = $bdd->prepare('SELECT * FROM item_indicateur');
    $req2->execute();
    $indicateurs = $req2->fetchAll();

    $title = 'Indicateurs';
    include 'elements/header.php';
?>
<div class="container">
    <div class="col-md-12">
        <div class="text-center">
            <h2 class="text-center"><strong><b>Indicateur</b></strong></h2>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Numéro item</th>
                        <th>Libelle compétences</th>
                        <th>Indicateur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($indicateurs as $indicateur => $key): ?>
                    <tr>
                        <td><?= $key[0] ?></td>
                        <td><?= $key[1] ?></td>
                        <td><?= $key[2] ?></td>
                    </tr>
                    <?php endforeach; ?> 
                </tbody>
            </table>
        </div>
    </div>
</div> 

<?php include 'elements/footer.php'; ?>