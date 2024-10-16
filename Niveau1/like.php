<?php 
$enCoursLike = isset($_POST['like']);

if ($enCoursLike) {
    
    // Vérifier si le post a déjà été liké
    $postId = intval($mysqli->real_escape_string($_POST['post_id']));
    $likedPost = "
        SELECT * FROM likes 
        WHERE user_id = " . $_SESSION["connected_id"] . " AND post_id = " . $_POST["post_id"] . ";";
        
    // Si le post a déjà été liké
    $likedPostResult = $mysqli->query($likedPost);
    $ok = $likedPostResult->fetch_assoc();
    
    if (!$ok) {
        $insertLike = "
            INSERT INTO likes (id, user_id, post_id) VALUES (NULL, " . $_SESSION["connected_id"] . ", " . $postId . ")"; 

        $ok = $mysqli->query($insertLike);

        // if ( ! $ok) {
        //         echo "Votre 'like' n'a pas été pris en compte" . $mysqli->error;
        //     } else {
        //         echo "Vous avez liké ce post";
        //     };

    } else {
        $removeLike = "
            DELETE FROM likes
            WHERE post_id = " . $postId . " AND user_id = " . $_SESSION["connected_id"] . ";"; 
            $ok = $mysqli->query($removeLike);
    } 
}
?> 