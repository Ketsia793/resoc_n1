    <article>
        <h3>
            <time><?php echo $post['created'] ?></time>
        </h3>
        <address>
            par <a href="wall.php?user_id=<?php echo $post['user_id'] ?>"><?php echo $post['author_name'] ?></a>
        </address>
        <div>
            <p><?php echo $post['content'] ?></p>
        </div>
        <footer>
            <small>♥ <?php echo $post['like_number'] ?> </small>
            <a href=""><?php 
                $alltags = $post['taglist'];
                $tag = explode(",", $alltags);
            
                for ($i = 0; $i < count($tag); $i++) {
                    if ($i == count($tag) - 1) {
                        echo ("#" . $tag[$i] . "");
                    } else {
                        echo ("#" . $tag[$i] . ", ");
                    }
                }
            ?></a>
        </footer>
    </article>
