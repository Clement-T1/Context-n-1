<?php 
    require_once '../config.php'; // On inclu la connexion à la bdd

    // Si les variables existent et qu'elles ne sont pas vides
    if(!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
    {
        $email = strtolower($email); // on transforme toute les lettres majuscules en minuscule pour éviter que Foo@gmail.com et foo@gmail.com soient deux compte différents ..
        // Patch XSS
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);

        // On vérifie si l'utilisateur existe
        $check = $bdd->prepare('SELECT PRENOM_ETUD, NOM_ETUD, EMAIL_ETUD, MOT_DE_PASSE_ETUD FROM etudiant WHERE EMAIL_ETUD = ?');
        $check->execute([$email]);
        $row = $check->rowCount();
        
        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
        if($row == 0){ 
            if(strlen($prenom) <= 100){ // On verifie que la longueur du prenom <= 100
                if (strlen($nom) <=100) { // On verifie que la longueur du nom <= 100
                    if(strlen($email) <= 100){ // On verifie que la longueur du mail <= 100
                        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // Si l'email est de la bonne forme
                            if($password === $password_retype){ // si les deux mdp saisis sont bon

                                // On hash le mot de passe avec Bcrypt, via un coût de 12
                                $cost = ['cost' => 12];
                                $password = password_hash($password, PASSWORD_BCRYPT, $cost);

                                // On insère dans la base de données
                                $insert = $bdd->prepare('INSERT INTO etudiant(PRENOM_ETUD, NOM_ETUD, EMAIL_ETUD, MOT_DE_PASSE_ETUD) VALUES(:PRENOM_ETUD, :NOM_ETUD, :EMAIL_ETUD, :MOT_DE_PASSE_ETUD)');
                                $insert->execute([
                                    'PRENOM_ETUD' => $prenom,
                                    'NOM_ETUD' => $nom,
                                    'EMAIL_ETUD' => $email,
                                    'MOT_DE_PASSE_ETUD' => $password,
                                ]);
                                // On redirige avec le message de succès
                                header('Location:../inscription.php?reg_err=success');
                                die();
                            }else{ header('Location:../inscription.php?reg_err=password'); die();}
                        }else{ header('Location:../inscription.php?reg_err=email'); die();}
                    }else{ header('Location:../inscription.php?reg_err=email_length'); die();}
                }else{ header('Location:../inscription.php?reg_err=prenom_length'); die();}
            }else{ header('Location:../inscription.php?reg_err=nom_length'); die();}
        }else{ header('Location:../inscription.php?reg_err=already'); die();}
    }
