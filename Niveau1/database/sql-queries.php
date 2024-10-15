<?php 

function sqlStructure($sqlQuery, $mysqli) {
    // $laQuestionEnSql = $sqlQuery;
    $lesInformations = $mysqli->query($sqlQuery);

    // Vérification
    if ( ! $lesInformations)
    {
        echo("Échec de la requete : " . $mysqli->error);
    }
    return $lesInformations;
}


// ---------- RETRIEVE REQUESTS ---------- // 

// Récupérer le user_name dans wall.php, feed.php
function retrieveUserName($userId) {
    $UserName = "SELECT * FROM users WHERE id = '$userId'";
    return $UserName;
}

// Récupérer les infos de la page news.php
function retrieveNewsPosts() {
    $posts = "
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
    return $posts;
}

// Récupérer les infos de la page wall.php 
function retrieveWallPosts($userId) {
    $posts = "
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
    return $posts;
}

// Récupérer les posts de la page feed.php
function retrieveFeedPosts($userId) {
    $posts = "
        SELECT posts.content,
        posts.created,
        users.alias as author_name,  
        users.id as user_id,
        count(likes.id) as like_number,  
        GROUP_CONCAT(DISTINCT tags.label) AS taglist 
        FROM followers 
        JOIN users ON users.id=followers.followed_user_id
        JOIN posts ON posts.user_id=users.id
        LEFT JOIN posts_tags ON posts.id = posts_tags.post_id  
        LEFT JOIN tags       ON posts_tags.tag_id  = tags.id 
        LEFT JOIN likes      ON likes.post_id  = posts.id 
        WHERE followers.following_user_id='$userId' 
        GROUP BY posts.id
        ORDER BY posts.created DESC  
        ";
    return $posts;
}


// ---------- INSERT REQUESTS ---------- // 

// Insertion des valeurs du formulaire dans users (table registration.php)
function insertNewUser($new_email, $new_alias, $new_passwd) {
    $new_passwd = md5($new_passwd);
    $newUser = "
        INSERT INTO users (id, email, password, alias) "
        . "VALUES (NULL, "
        . "'" . $new_email . "', "
        . "'" . $new_passwd . "', "
        . "'" . $new_alias . "'"
        . ");
        ";
    return $newUser;
}


// Insertion des nouveaux posts (table new-article.php)
function insertNewPost() {
    $newPost = "
        INSERT INTO posts "
        . "(id, user_id, content, created, parent_id) "
        . "VALUES (NULL, "
        . $authorId . ", "
        . "'" . $postContent . "', "
        . "NOW(), "
        . "NULL);
        ";
    return $newPost;
}

// Insertion d'un nouvel abonnement (wall.php) 
function insertNewSubscription($userId, $connectedId) {
    $newSubscription = "
        INSERT INTO followers "
        . "(id, followed_user_id, following_user_id) "
        . "VALUES (NULL, "
        . "'" . $userId . "', "
        . "'" . $connectedId . "');
        ";

    echo ('New subscription');  
    return $newSubscription;
}

// Insertion d'un nouveau like (article.php)
function insertNewLike($userId, $postId) {
    $newLike = "
        INSERT INTO likes "
        . "(id, user_id, post_id) "
        . "VALUES (NULL, "
        . "'" . $userId . "', "
        . "'" . $postId . "');
        ";
    return $newLike;
}

?>