<?php 
    session_start();
    require_once 'config.php';

    $title = 'Savoirs';
    if(!isset($_SESSION['id'])){
    header('Location:index.php');
        die();
    }

    $req = $bdd->prepare('SELECT * FROM savoir');
    $req->execute();
    $savoirs = $req->fetchAll();

    include 'elements/header.php'; 
?>
<div class="container">
    <div class="col-md-12">
        <div class="text-center">
            <h2 class="text-center"><strong><b>Savoir</b></strong></h2>
            <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Numéro item</th>
                        <th>Libelle compétence</th>
                        <th>Savoir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($savoirs as $savoir => $key): ?>
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