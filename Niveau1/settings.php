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
        <title>ReSoC - Paramètres</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style.css"/>
    </head>
    <body>
    <?php 
        include 'header.php';
        ?>
        <div id="wrapper" class='profile'>


            <aside>
                <img src="images/user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les informations de l'utilisatrice
                        n° <?php echo intval($_GET['user_id']) ?></p>

                </section>
            </aside>
            <main>
                <?php
                
                // Etape 1: La première étape est donc de trouver quel est l'id de l'utilisatrice
                $userId = intval($_GET['user_id']);

                // Etape 2: se connecter à la base de donnée
                $mysqli = connectToDatabase();
                    
                // Etape 3: récupérer les infos de l'utilisateur
                $userInfo = sqlStructure(retrieveUserInfo($userId), $mysqli);

                $user = $userInfo->fetch_assoc();
                // Etape 4: Remplacer les valeurs par les résultats de la requête
                ($user);
                ?>  

                <article class='parameters'>
                    <h3>Mes paramètres</h3>
                    <dl>
                        <dt>Pseudo</dt>
                        <dd><?php echo $user['alias']?></dd>
                        <dt>Email</dt>
                        <dd><?php echo $user['email']?></dd>
                        <dt>Nombre de message</dt>
                        <dd><?php echo $user['totalpost']?></dd>
                        <dt>Nombre de "Jaime" donnés</dt>
                        <dd><?php echo $user['totalgiven']?></dd>
                        <dt>Nombre de "Jaime" reçus</dt>
                        <dd><?php echo $user['totalrecieved']?></dd>
                    </dl>
                </article>
            </main>
        </div>
    </body>
</html>
