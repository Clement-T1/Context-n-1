<?php
session_start();
include 'config.php';
$title = 'Profil';

if(!isset($_SESSION['id'])){
    header('Location:index.php');
    die();
}

// On récupere les données de l'utilisateur
$req = $bdd->prepare('SELECT * FROM etudiant WHERE IDENTIFIANT_ETUD = ?');
$req->execute([$_SESSION['id']]);
$data = $req->fetch();

if(isset($_POST['envoyer'])){
    $dossier = "upload/" . $data['IDENTIFIANT_ETUD'] . "/";

    if(!is_dir($dossier)){
        mkdir($dossier);
    }

    $fichier = basename($_FILES['avatar']['name']);
  
    if(file_exists("upload/" . $_SESSION['id'] . '/' . $data['AVATAR']) && isset($_SESSION['AVATAR'])){
        unlink("upload/" . $_SESSION['id'] . '/' . $data['AVATAR']);
    }

    if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)){
        $req = $bdd->prepare("UPDATE ETUDIANT SET AVATAR = ? WHERE IDENTIFIANT_ETUD = ?");
        $req->execute([$fichier, $_SESSION['id']]);
        $_SESSION['AVATAR'] = $fichier;
        $success = '<div class="alert alert-success text-center" id="success"><p>Upload effectué avec succès !</p></div>';
    }else{
        echo 'Echec de l\'upload';
        exit;
        header('Location: profil.php');
    }
}
include 'elements/header.php';

?>

<script type="text/javascript">
    setTimeout(function() {
        document.getElementById("successMessage").style.display = "none";
    }, 5000); // 5000 millisecondes = 5 secondes
</script>
<div id="successMessage" class="alert alert-success" style="position: fixed; top: 0; left: 40%">
    <strong>Succès</strong> Vous êtes connecté.
</div>
<div class="container">
    <?php if (isset($success)){ 
        echo $success;
    }
    ?>
    <h2 class="text-center"><strong><b>Bienvenue sur votre profil</b></strong></h2>
    <p class="text-center">Votre prénom : <strong><?php echo $data['PRENOM_ETUD']; ?></strong></p>
    <p class="text-center">Votre email : <strong><?php echo $data['EMAIL_ETUD']; ?></strong></p>
    <hr/>
    <form method="post" enctype="multipart/form-data">
        <div class="text-center">
        <?php if(!isset($_SESSION['AVATAR'])){ ?>
            Ajouter un avatar <?php }else { ?> changer votre avatar <?php } ?> : <input type="file" name="avatar">
        </div>
        <br>
        <div class="text-center">
            <input class="btn btn-info" type="submit" name="envoyer" value="Envoyer le fichier">
        </div>
    </form>
    <hr/>
    <?php 
        if(isset($_GET['err'])){
            $err = htmlspecialchars($_GET['err']);
            switch($err){
                case 'current_password':
                    echo "<div class='alert alert-danger'>Le mot de passe actuel est incorrect</div>";
                break;

                case 'success_password':
                    echo "<div class='alert alert-success'>Le mot de passe a bien été modifié ! </div>";
                break; 
            }
        }
    ?>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-info btn-lg mb-4" data-toggle="modal" data-target="#change_password">
        Changer mon mot de passe
    </button>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-info btn-lg mb-4" data-toggle="modal" data-target="#contact_admin">
        Contacter un administrateur
    </button>
</div>

<!-- Modal -->
    <div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Changer mon mot de passe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form action="layouts/change_password.php" method="POST">
                                <label for='current_password'>Mot de passe actuel</label>
                                <input type="password" id="current_password" name="current_password" class="form-control" required/>
                                <br />
                                <label for='new_password'>Nouveau mot de passe</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required/>
                                <br />
                                <label for='new_password_retype'>Re tapez le nouveau mot de passe</label>
                                <input type="password" id="new_password_retype" name="new_password_retype" class="form-control" required/>
                                <br />
                                <button type="submit" class="btn btn-success w-100">Sauvegarder</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

<!-- Modal contactez administrateur -->
    <div class="modal fade" id="contact_admin" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Changer mon mot de passe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form action="mail_traitement.php" method="POST">
                                <label for='object'>Objet de votre demande :</label>
                                <input type="text" id="object" name="object" class="form-control" required/>
                                <br />
                                <label for='message'>Saississez votre message :</label>
                                <textarea type="text" id="message" name="message" class="form-control" required/></textarea>
                                <br />
                                <button type="submit" class="btn btn-success w-100">Envoyer</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

<?php include 'elements/footer.php'; ?>