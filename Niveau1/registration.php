<?php 
    error_reporting(-1);
    ini_set( 'display_errors', 1 );

    include 'database/connection.php';
    include 'database/sql-queries.php';
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Inscription</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style2.css"/>
    </head>
    <body>
        <?php 
        include 'header.php';
        ?>
        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenue sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Inscription</h2>

                    <?php
                    // ---------- Validation email et pseudo ---------- // 
                    function validateEmail($email) {
                        $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
                        return preg_match($pattern, $email);
            
                        if(isset($_POST['email'])) {
                            echo "Valid email address.";
                        } else {
                            echo "Invalid email address.";
                        }
                    }
                    function validatePseudo($pseudo) {
                        if (isset($_POST['pseudo'])) {
                            if (preg_match('#^[a-zA-Z0-9.-_]{3,20}$#', $_POST['pseudo'])) { // Contrôle que le pseudo contient 3 à 20 caractères
                                $pseudo = htmlspecialchars($_POST['pseudo']); // Enregistre le pseudo en tant que '$pseudo'
                                return $pseudo; // Retourne le pseudo validé
                            } else {
                                return false; // Retourne 'false' en cas de problème
                            }
                        }
                        return false; // Retourne 'false' si 'pseudo' n'est pas défini dans le formulaire
                    }

                    
                    // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
                    // si on recoit un champs email rempli il y a une chance que ce soit un traitement
                    $enCoursDeTraitement = isset($_POST['email']);
                    $pseudo_name = isset($_POST['pseudo']);
                    
                    if ($enCoursDeTraitement) {
                        // on ne fait ce qui suit que si un formulaire a été soumis.
                        // Etape 2: récupérer ce qu'il y a dans le formulaire
                        // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                        $new_email = $_POST['email'];
                        $new_alias = $_POST['pseudo'];
                        $new_passwd = $_POST['motpasse'];

                        //Etape 3 : Ouvrir une connexion avec la base de donnée.
                        $mysqli = connectToDatabase();

                        //Etape 4 : Petite sécurité
                        // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        $new_email = $mysqli->real_escape_string($new_email);
                        $new_alias = $mysqli->real_escape_string($new_alias);
                        $new_passwd = $mysqli->real_escape_string($new_passwd);

                        //Etape 5 : construction de la requete
                        if (validateEmail($_POST['email']) && validatePseudo($_POST['pseudo'])) {
                            $lesInformations = sqlStructure(insertNewUser($new_email, $new_alias, $new_passwd), $mysqli);

                            // Vérification
                            if (! $lesInformations && ! $_POST['pseudo']) {
                                echo("Échec de la requete : " . $mysqli->error);
                            } else {
                                echo "Votre inscription est un succès " . $new_alias . ".";
                                header("Location: login.php");
                                exit();
                                // echo " <a href='login.php'>Connectez-vous ici.</a>";
                                
                            };

                            // if (! $_POST['pseudo']) {
                            //     echo 'Le pseudo doit contenir entre 3 et 20 caractères, sans espace.<br/>';
                            // } 
                        };
                    }
                    ?>                     
                    <form action="registration.php" method="post">
                        <input type='hidden' name='???' value='achanger'>
                        <form action="registration.php" method="post">
                        <input type='hidden' name='???' value='achanger'>
                        <dl>
                            <dt><label for='pseudo'>Pseudo</label></dt>
                            <dd><input type='text'name='pseudo' id="text" aria-describedby="text-id"></dd>
                            <p id="text-id" aria-hidden="true">
                            <dt><label for='email'>E-Mail</label></dt>
                            <dd><input type='email'name='email' id="email" aria-describedby="email-id"></dd>
                            <p id="email-id" aria-hidden="true">
                            <dt><label for='motpasse'>Mot de passe</label></dt>
                            <dd><input type='password'name='motpasse' id='password'aria-describedby="password"></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                </article>
            </main>
        </div>
    </body>
</html>
