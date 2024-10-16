<?php
$likeNumber = $post['like_number'];
if (isset($_SESSION['connected_id'])) {
    $userId = $_SESSION['connected_id'];

    $testLikeRequest = sqlStructure(didLike($userId, $post['post_id']), $mysqli);
    $postDejaLike = $testLikeRequest->fetch_assoc();
    
    // echo "<pre>" . print_r($postDejaLike, 1) . "</pre>";

    
    if (isset($_POST['postId']) && $_POST['postId'] == $post['post_id']) {
        if (mysqli_num_rows($testLikeRequest) == 0) {
            $addLikeData = sqlStructure(addLike($userId, $post['post_id']), $mysqli);
            if (!$addLikeData) {
                echo("Échec de la requete : " . $mysqli->error);
            }
            $likeNumber += 1;    
        } else {
            // Ajout de la suppression de la ligne en base
            if (mysqli_num_rows($testLikeRequest) == 1){
                $removeLikeData = sqlStructure(removeLike($userId, $post['post_id']), $mysqli);
                if (!$removeLikeData) {
                    echo("Échec de la requete : " . $mysqli->error);
                }
            }
            $likeNumber -= 1;
        }
    }
}
?>
<form action="#" method="post">
    <?php // echo "<pre>" . print_r($post, 1) . "</pre>"; ?>
    <input type="hidden" name="postId" value=<?php echo $post['post_id']; ?>>
    <button type="submit" name="like_button" class="like-button">
        <small>♥ <?php echo $likeNumber ?> </small>
    </button>
</form>