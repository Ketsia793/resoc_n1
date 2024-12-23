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
        <title>ReSoC - Mes abonnements</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style.css"/>
    </head>
    <body>
        <?php 
        include 'partials/header.php';
        ?>
        <div id="wrapper">
            <aside>
                <img src="images/user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes dont
                        l'utilisatrice
                        n° <?php echo intval($_GET['user_id']) ?>
                        suit les messages
                    </p>

                </section>
            </aside>
            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);

                // Etape 2: se connecter à la base de donnée
                $mysqli = connectToDatabase();

                // Etape 3: récupérer le nom de mes abonnements
                $followedUsers  = sqlStructure(retrieveFollowedInfo($userId),$mysqli);
                
                // Etape 4: la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                while ($followed = $followedUsers->fetch_assoc()) 
                {
                    // echo "<pre>" . print_r($followed, 1) . "</pre>";
                    ?>
                    <article>
                        <img src="images/user.jpg" alt="blason"/>
                        <h3><a href="wall.php?user_id=<?php echo $followed['id'] ?>"><?php echo $followed['alias'] ?></a></h3>
                        <p>id: <?php echo $followed['id'] ?></p>                    
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
