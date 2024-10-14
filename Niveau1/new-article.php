
<article>
    <h2>Poster un message sur mon mur</h2>
    <?php

    // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
    $enCoursDeTraitement = isset($_POST['message']);
    if ($enCoursDeTraitement && !empty($_POST['message'])) {
        // Etape 2: récupérer ce qu'il y a dans le formulaire 
        echo "<pre>" . print_r($_POST, 1) . "</pre>";

        $authorId = $_SESSION['connected_id'];
        $postContent = $_POST['message'];

        //Etape 3 : Petite sécurité
        // pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
        $authorId = intval($mysqli->real_escape_string($authorId));
        $postContent = $mysqli->real_escape_string($postContent);

        //Etape 4 : construction de la requete
        $lInstructionSql = "INSERT INTO posts "
                . "(id, user_id, content, created, parent_id) "
                . "VALUES (NULL, "
                . $authorId . ", "
                . "'" . $postContent . "', "
                . "NOW(), "
                . "NULL);"
                ;
        echo "<pre>" . $lInstructionSql . "</pre>";

        // Etape 5 : execution
        $ok = $mysqli->query($lInstructionSql);
        if ( ! $ok)
        {
            echo "Impossible d'ajouter le message: " . $mysqli->error;
        } else
        {
            echo "Message posté en tant que : " . $listAuteurs[$authorId];
            header("Location: wall.php?user_id=" . $_GET['user_id']);
        }
    } else {
        echo ("Erreur : Entrer un message");
    }
    ?>                     
    <form action="wall.php?user_id=<?php echo $_GET['user_id'] ?>" method="post">
        <dl>
            <dt><label for='message'>Message</label></dt>
            <dd><textarea name='message'></textarea></dd>
        </dl>
        <input type='submit'>
    </form>               
</article>