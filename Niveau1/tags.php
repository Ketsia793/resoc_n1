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
       
        <?php include 'header.php'; 
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
                $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $tag = $lesInformations->fetch_assoc();
                
                ($tag);
                ?>
                <img src="images/user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages comportant
                        le mot-clé <?php echo $tag['label'] ?>
                        (n° <?php echo $tagId ?>)
                    </p>

                </section>
            </aside>
            <main>
                <?php
                
                // Etape 4: récupérer tous les messages avec un mot clé donné
                $laQuestionEnSql = "
                    
                    SELECT posts.content,
                    posts.created,
                    posts.user_id,
                    posts.id as post_id,
                    users.alias as author_name,  
                    count(likes.id) as like_number,  
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist 
                    FROM posts_tags as filter 
                    JOIN posts ON posts.id=filter.post_id
                    JOIN users ON users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
                    LEFT JOIN likes      ON likes.post_id  = posts.id 
                    WHERE filter.tag_id = '$tagId' 
                    GROUP BY posts.id
                    ORDER BY posts.created DESC  
                    ";
                
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                include 'like.php';
              
                // Etape 5: Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                while ($post = $lesInformations->fetch_assoc())
                {

                     ($post);
                    ?>                
                    <?php include 'article.php'?>
                <?php } ?>


            </main>
        </div>
    </body>
</html>