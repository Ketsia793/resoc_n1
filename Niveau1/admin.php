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
        <title>ReSoC - Administration</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style.css"/>
    </head>
    <body>
        <?php 
        include 'partials/header.php';
        ?>

        <?php
        // Etape 1: Ouvrir une connexion avec la base de donnée.
        $mysqli = connectToDatabase();
        
        ?>
        <div id="wrapper" class='admin'>
            <aside>
                <h2>Mots-clés</h2>
                <?php
                // Etape 2 : trouver tous les mots clés
                $tagsInfo = sqlStructure(retrieveTag(), $mysqli);

                // Etape 3 : Afficher les mots clés en s'inspirant de ce qui a été fait dans news.php
                while ($tag = $tagsInfo->fetch_assoc())
                {
                    // echo "<pre>" . print_r($tag, 1) . "</pre>";
                    ?>
                    <article>
                        <h3>#<?php echo $tag['label'] ?></h3>
                        <p>id:<?php echo $tag['id'] ?></p>
                        <nav>
                            <a href="tags.php?tag_id=<?php echo $tag['id'] ?>">Messages</a>
                        </nav>
                    </article>
                <?php } ?>
            </aside>
            <main>
                <h2>Utilisatrices</h2>
                <?php
                
                // Etape 4 : trouver toutes les utilisatrices
                $usersInfo = sqlStructure(retrieveUsersInfo(), $mysqli);
                
                // Etape 5 : Afficher les utilisatrices en s'inspirant de ce qui a été fait dans news.php
                while ($user = $usersInfo->fetch_assoc())
                {
                    // echo "<pre>" . print_r($tag, 1) . "</pre>";
                    ?>
                    <article>
                        <h3><a href="wall.php?user_id=<?php echo $user['id'] ?>"><?php echo $user['alias'] ?></a></h3>
                        <p>id: <?php echo $user['id'] ?></p>
                        <nav>
                            <a href="wall.php?user_id=<?php echo $user['id'] ?>">Mur</a>
                            | <a href="feed.php?user_id=<?php echo $user['id'] ?>">Flux</a>
                            | <a href="settings.php?user_id=<?php echo $user['id'] ?>">Paramètres</a>
                            | <a href="followers.php?user_id=<?php echo $user['id'] ?>">Suiveurs</a>
                            | <a href="subscriptions.php?user_id=<?php echo $user['id'] ?>">Abonnements</a>
                        </nav>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
