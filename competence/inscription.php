<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="author" content="NoS1gnal"/>

            <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <title>Inscription</title>
        </head>
        <body>
        <div class="login-form">
            <?php 
                if(isset($_GET['reg_err']))
                {
                    $err = htmlspecialchars($_GET['reg_err']);

                    switch($err)
                    {
                        case 'success':
                        ?>
                            <div class="alert alert-success">
                                Inscription réussie !
                            </div>
                        <?php
                        break;

                        case 'password':
                        ?>
                            <div class="alert alert-danger">
                                Mot de passe différent
                            </div>
                        <?php
                        break;

                        case 'email':
                        ?>
                            <div class="alert alert-danger">
                                Email non valide
                            </div>
                        <?php
                        break;

                        case 'email_length':
                        ?>
                            <div class="alert alert-danger">
                                Email trop long
                            </div>
                        <?php 
                        break;

                        case 'prenom_length':
                        ?>
                            <div class="alert alert-danger">
                                Prénom trop long
                            </div>
                        <?php 

                        case 'nom_length':
                        ?>
                            <div class="alert alert-danger">
                                Nom trop long
                            </div>
                        <?php 

                        case 'already':
                        ?>
                            <div class="alert alert-danger">
                                Compte deja existant
                            </div>
                        <?php 

                    }
                }
                ?>
            <h2 class="text-center">Inscription</h2> 
            <a href="index.php" class="btn btn-primary mb-2">Retour</a>
            <form action="function/inscription_traitement.php" method="post">
                <div class="form-group">
                    <input type="text" name="prenom" class="form-control" placeholder="Prenom" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" name="nom" class="form-control" placeholder="Nom" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" name="password_retype" class="form-control" placeholder="Re-tapez le mot de passe" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">Inscription</button>
                </div>   
            </form>
        </div>
        <style>
            .login-form {
                width: 340px;
                margin: 50px auto;
            }
            .login-form form {
                margin-bottom: 15px;
                background: #f7f7f7;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }
            .login-form h2 {
                margin: 0 0 15px;
            }
            .form-control, .btn {
                min-height: 38px;
                border-radius: 2px;
            }
            .btn {        
                font-size: 15px;
                font-weight: bold;
            }
        </style>
        </body>
</html>
