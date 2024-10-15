<article>
    <h3>
        <time>
            <?php 
                $date = date_create($post['created']);
                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                echo date_format($date, '\L\e d/m/Y \à H\hi');  
            ?>

        </time>
    </h3>
    <address>
        par <a href="wall.php?user_id=<?php echo $post['user_id'] ?>"><?php echo $post['author_name'] ?></a>
    </address>
    <div>
        <p><?php echo $post['content'] ?></p>
    </div>
    <footer>
        <small>
            <?php 
                $enCoursLike = isset($_POST['like']);
                if ($enCoursLike) {
                    $postId = $post['id'];
                    
                    $lesInformations = sqlStructure(insertNewLike($_SESSION['connected_id'], $postId), $mysqli);
                    
                    // header("Location: " . $_SERVER['HTTP_REFERER']);
                    // exit();
                }
            ?>
            <form action="<?php $_SERVER['REQUEST_URI'] ?>" method="post">
                <input type='hidden' name='like' value='true'>
                <input type='submit' value='♥ <?php echo $post['like_number'] ?>'>
            </form> 
        </small>

        <?php 
            if (! $post['taglist']) {
                echo ("There is no #tag" . $mysqli->error);
            } else {
                $alltags = $post['taglist'];
                $tag = explode(",", $alltags);
            
                for ($i = 0; $i < count($tag); $i++) {


                    $laQuestionEnSQl = "
                    SELECT id FROM tags WHERE label = '$tag[$i]'
                    ";
                    $tagid_info = $mysqli->query($laQuestionEnSQl);
                    
                if (! $tagid_info) {
                    echo ("Echec de la reqûete : " . $mysqli->error);
                }

                $tag_id = $tagid_info->fetch_assoc();
                    if ($i == count($tag) - 1) {
                        ?><a href="tags.php?tag_id=<?php echo $tag_id["id"] ?>"><?php echo (" #" . $tag[$i] . "");
                    } else {
                        ?><a href="tags.php?tag_id=<?php echo $tag_id["id"] ?>"><?php echo ("#" . $tag[$i] . ",");
                    }
                }
            }
        ?>
    </footer>
</article>