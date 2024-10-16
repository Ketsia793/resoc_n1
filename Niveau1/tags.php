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
        <title>ReSoC - Les message par mot-clé</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style.css"/>
    </head>
    <body>
       
        <?php include 'partials/header.php'; 
        ?>
       
        <div id="wrapper">
            <?php
            
            // Etape 1: Le mur concerne un mot-clé en particulier
            $tagId = $_GET['tag_id'];
            
            ?>
            <?php
            
            // Etape 2: se connecter à la base de donnée
            $mysqli = connectToDatabase();
            ?>
            <aside>
                <?php
                
                // Etape 3: récupérer le nom du mot-clé
                $tagInfos = sqlStructure(retrieveTagById($tagId), $mysqli);
               
                $tag = $tagInfos->fetch_assoc();
                
                ($tag);
                ?>
                <img src="images/user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages comportant le mot-clé <?php echo $tag['label'] ?> (n° <?php echo $tagId ?>)</p>
                </section>
            </aside>
            <main>
                <?php
                
                // Etape 4: récupérer tous les messages avec un mot clé donné
                $postsByTag = sqlStructure(retrievePostByTags($tagId), $mysqli);
              
                // Etape 5: Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                while ($post = $postsByTag->fetch_assoc())
                {
                     ($post);
                    ?>                
                    <?php include 'partials/article.php'?>
                <?php } ?>


            </main>
        </div>
    </body>
</html>