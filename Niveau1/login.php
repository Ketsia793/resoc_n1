<?php 
    error_reporting(-1);
    ini_set( 'display_errors', 1 );

    include 'database/connection.php';
    include 'database/retrieve.php';
    include 'database/sql-queries.php';
?>

<?php
session_start();
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Connexion</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style2.css"/>
    </head>
    <body>
        <?php 
        include 'partials/header.php';
        ?>
        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenue sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <?php 
                    // Vérification si la variable HTTP_REFERER est définie et contient "registration.php"
                    if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "registration.php") !== false) { ?>
                        <h2>Votre inscription est un succès. Connectez-vous !</h2>
                    <?php  
                    } else { ?>
                        <h2>Connexion</h2>
                    <?php } 
                     
                    // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
                    $enCoursDeTraitement = isset($_POST['email']);
                    if ($enCoursDeTraitement)
                    {
                        // Etape 2: récupérer ce qu'il y a dans le formulaire 
                        // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                        $emailAVerifier = $_POST['email'];
                        $passwdAVerifier = $_POST['motpasse'];

                        //Etape 3 : Ouvrir une connexion avec la base de donnée.
                        $mysqli = connectToDatabase();

                        //Etape 4 : Petite sécurité
                        // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
                        $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);

                        // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                        // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité
                        $passwdAVerifier = md5($passwdAVerifier);

                        //Etape 5 : construction de la requete
                        $userLoginInfo = sqlStructure(retrieveLoginInfo($emailAVerifier), $mysqli);

                        // Etape 6: Vérification de l'utilisateur
                        $user = $userLoginInfo->fetch_assoc();

                        if ( ! $user OR $user["password"] != $passwdAVerifier)
                        {
                            echo "Veuillez vérifier votre adresse e-mail et/ou votre mot de passe.";
                            
                        } else
                        {
                            echo "Votre connexion est un succès : " . $user['alias'] . ".";
                            // Etape 7 : Se souvenir que l'utilisateur s'est connecté pour la suite
                            // documentation: https://www.php.net/manual/fr/session.examples.basic.php
                            $_SESSION['connected_id']=$user['id'];
                            header("Location: wall.php?user_id=" . $_SESSION['connected_id']);
                            // exit();
                        }
                    }
                    ?>                     
                    <form action="login.php" method="post">
                        <dl>
                            <dt><label for='email'>E-Mail</label></dt>
                            <dd><input type='email'name='email' id="email" aria-describedby="email-id"></dd>
                            <p id="email-id" aria-hidden="true">
                            <dt><label for='motpasse'>Mot de passe</label></dt> 
                            <dd><input type='password'name='motpasse' id="password" aria-desribedby="password-id"></dd>
                            <p id="password-id" aria-hidden="true">
                            </dl>
                        <input type='submit'>
                    </form>
                    <p>
                        Pas de compte?
                        <a href='registration.php'>Inscrivez-vous.</a>
                    </p>


                </article>
            </main>
        </div>
    </body>
</html>
