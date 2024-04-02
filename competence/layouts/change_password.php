<?php   
    // Démarrage de la session 
    session_start();
    // Inclusion du fichier de configuration de la base de données
    require_once '../config.php';

    // Vérification de l'existence de la session
    if(!isset($_SESSION['id'])) {
        header('Location: ../index.php');
        exit(); // Utilisation de exit() après une redirection
    }

    // Vérification de la soumission du formulaire
    if(isset($_POST['current_password'], $_POST['new_password'], $_POST['new_password_retype'])) {
        // Utilisation de la fonction trim() pour supprimer les espaces inutiles
        $current_password = trim($_POST['current_password']);
        $new_password = trim($_POST['new_password']);
        $new_password_retype = trim($_POST['new_password_retype']);

        // Vérification que les champs ne sont pas vides
        if(!empty($current_password) && !empty($new_password) && !empty($new_password_retype)) {
            // Requête préparée pour récupérer le mot de passe de l'utilisateur
            $check_password  = $bdd->prepare('SELECT MOT_DE_PASSE_ETUD FROM etudiant WHERE IDENTIFIANT_ETUD = :id');
            $check_password->execute([
                "id" => $_SESSION['id'],
            ]);
            $data_password = $check_password->fetch();

            // Si le mot de passe est le bon
            if(password_verify($current_password, $data_password['MOT_DE_PASSE_ETUD'])) {
                // Vérification de correspondance entre les nouveaux mots de passe
                if($new_password === $new_password_retype) {
                    // Hachage du nouveau mot de passe
                    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                    // Mise à jour du mot de passe dans la base de données
                    $update = $bdd->prepare('UPDATE etudiant SET MOT_DE_PASSE_ETUD = :password WHERE IDENTIFIANT_ETUD = :id');
                    $update->execute([
                        "password" => $hashed_password,
                        "id" => $_SESSION['id']
                    ]);

                    // Redirection avec un message de succès
                    header('Location: ../profil.php?err=success_password');
                    exit(); // Utilisation de exit() après une redirection
                } else {
                    // Redirection avec un message d'erreur
                    header('Location: ../profil.php?err=password_mismatch');
                    exit(); // Utilisation de exit() après une redirection
                }
            } else {
                // Redirection avec un message d'erreur
                header('Location: ../profil.php?err=current_password');
                exit(); // Utilisation de exit() après une redirection
            }
        } else {
            // Redirection si des champs sont vides
            header('Location: ../profil.php?err=empty_fields');
            exit(); // Utilisation de exit() après une redirection
        }
    } else {
        // Redirection si le formulaire n'a pas été soumis
        header('Location: ../profil.php');
        exit(); // Utilisation de exit() après une redirection
    }
?>
