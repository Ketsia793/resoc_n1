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
        <title>ReSoC - Mes abonnés </title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style.css"/>
    </head>
    <body>
    <?php 
        include 'partials/header.php';
        ?>
        </header>
        <div id="wrapper">          
            <aside>
                <img src = "images/user.jpg" alt = "Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes qui suivent les messages de l'utilisatrice n° <?php echo intval($_GET['user_id']) ?></p>
                </section>
            </aside>

            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);
                
                // Etape 2: se connecter à la base de donnée
                $mysqli = connectToDatabase();
                
                // Etape 3: récupérer les infos des abonnés
                $followersInfo = sqlStructure(retrieveFollowersInfo($userId), $mysqli);

                // Etape 4: boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous 
                while ($followers = $followersInfo->fetch_assoc()){
                    // echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>
                    <article> 
                    <img src="images/user.jpg" alt="blason"/>
                    <h3><a href="wall.php?user_id=<?php echo $followers['id'] ?>"><?php echo $followers['alias'] ?></a></h3>
            
                </article>
                <?php
                }
                ?>
            </main>
        </div>
    </body>
</html>
