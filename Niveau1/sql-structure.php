<?php 

function sqlStructure($sqlQuery, $mysqli) {

    // $laQuestionEnSql = $sqlQuery;
    $lesInformations = $mysqli->query($sqlQuery);

    // Vérification
    if ( ! $lesInformations)
    {
        echo "<article>";
        echo("Échec de la requete : " . $mysqli->error);
        echo("<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$sqliQuery</code></p>");
        exit();
    }

    return $lesInformations;
}


// Récupérer les infos de la page news.php_check_syntax
$retrieveNews = "
    SELECT posts.content,
    posts.id,
    posts.created,
    users.alias as author_name,  
    posts.user_id,
    count(likes.id) as like_number,  
    GROUP_CONCAT(DISTINCT tags.label) AS taglist,
    GROUP_CONCAT(DISTINCT tags.id) AS tag_idlist
    FROM posts
    JOIN users ON  users.id=posts.user_id
    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
    LEFT JOIN likes      ON likes.post_id  = posts.id 
    GROUP BY posts.id
    ORDER BY posts.created DESC  
    LIMIT 5
";

// Récupérer les infos de la page wall.php 
$retrieveWall = "
    SELECT posts.content, posts.created, users.alias as author_name, posts.user_id,
    COUNT(likes.id) as like_number, GROUP_CONCAT(DISTINCT tags.label) AS taglist,
    GROUP_CONCAT(DISTINCT tags.id) AS tag_idlist
    FROM posts
    JOIN users ON  users.id=posts.user_id
    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
    LEFT JOIN likes      ON likes.post_id  = posts.id 
    WHERE posts.user_id='$userId' 
    GROUP BY posts.id
    ORDER BY posts.created DESC  
    ";

?>