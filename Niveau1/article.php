
    <article>
        <h3>
            <time>
                <?php $date = date_create($post['created']);
                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                echo date_format($date, 'l d-m-Y H:i:s'); ?>
            </time>
        </h3>
        <address>
            par <a href="wall.php?user_id=<?php echo $post['user_id'] ?>"><?php echo $post['author_name'] ?></a>
        </address>
        <div>
            <p><?php echo $post['content'] ?></p>
        </div>
        <footer>
            <small>♥ <?php echo $post['like_number'] ?> </small>
            <!-- <a href=""> -->
                <?php 

                if (! $post['taglist']) {
                    echo ("There is no #tag");
                } else {
                    $alltags = $post['taglist'];
                    $alltag_ids = $post['tag_idlist'];
                    $tag = explode(",", $alltags);
                    $tag_id = explode(",", $alltag_ids);

                    // var_dump($alltag_ids);
                    // var_dump($post);
                
                    for ($i = 0; $i < count($tag); $i++) {
                        if ($i == count($tag) - 1) {
                            ?><a href="tags.php?tag_id=<?php echo $tag_id[$i] ?>"><?php echo (" #" . $tag[$i] . "");
                        } else {
                            ?><a href="tags.php?tag_id=<?php echo $tag_id[$i] ?>"><?php echo ("#" . $tag[$i] . ",");
                        }
                    }
                }
            ?>
            <!-- </a> -->
        </footer>
    </article>