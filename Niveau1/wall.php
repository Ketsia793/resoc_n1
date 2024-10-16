<?php 
    error_reporting(-1);
    ini_set( 'display_errors', 1 );

    include 'database/connection.php';
    include 'database/sql-queries.php';
?>

<?php
session_start();
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style.css"/>
    </head>
    <body>
        <?php 
        include 'header.php';
        ?>
        <div id="wrapper">
            <?php
            // Etape 1: La première étape est de trouver quel est l'id de l'utilisateur, indiqué en parametre GET de la page sous la forme user_id=...
            $userId = intval($_GET['user_id']);
            ?>
            
            <?php
            // Etape 2: se connecter à la base de donnée
            $mysqli = connectToDatabase();
            ?>

            <aside>
                <?php
                // Etape 3: récupérer le nom de l'utilisateur     
                $lesInformations2 = sqlStructure(retrieveUserName($userId), $mysqli);

                $user = $lesInformations2->fetch_assoc();
                // echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias'] ?>
                        (n° <?php echo $userId ?>)
                    </p>

                <!-- ---------- Suivre une autre utilisatrice ---------- -->
                <?php 
                // echo ('🐝' . $_SESSION['connected_id']);
                // echo ('🐞' . $_GET['user_id']);
                
                if ($_GET['user_id'] !== $_SESSION['connected_id']) { 
                
                    $enCoursFollow = isset($_POST['follow']);
                    if ($enCoursFollow) {
                        $lesInformations = sqlStructure(insertNewSubscription($userId, $_SESSION['connected_id']), $mysqli);
                    }
                ?>
                <form action="wall.php?user_id=<?php echo $_GET['user_id'] ?>" method="post">
                    <input type='hidden' name='follow' value='true'>
                    <?php if ($enCoursFollow) { ?>
                        <input type='submit' value='Ne plus suivre'>
                    <?php } else { ?>
                        <input type='submit' value='Suivre +'>
                    <?php } ?>
                </form> 
                <?php } ?>
                
                <!-- ---------- // Suivre une autre utilisatrice ---------- -->
            </section>
        </aside>
            <main>
                <?php

                if ($userId == $_SESSION['connected_id']) {
                    include 'new-article.php';
                } 


                // Etape 3: récupérer tous les messages de l'utilisatrice
                $lesInformations2 = sqlStructure(retrieveWallPosts($userId), $mysqli);

                include 'like.php';

                // Etape 4: Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                while ($post = $lesInformations2->fetch_assoc())
                {
                    // echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>               
                    <?php 
                        include 'article.php';
                    ?>
                <?php } ?>


            </main>
        </div>
    </body>
</html>
