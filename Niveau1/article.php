
    <article>
        <h3>
            <time>
                <?php $date = date_create($post['created']);
                setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
                echo date_format($date, 'l d-m-Y H:i:s'); ?>
            </time>
        </h3>
        <address>
            <?php 
            echo "par <a href='wall.php?user_id=" .$post['user_id']."'> ".$post['author_name']."</a>";
            ?>
            
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
                    // $alltag_ids = $post['tag_idlist'];
                    $tag = explode(",", $alltags);
                    // $tag_id = explode(",", $alltag_ids);

                    // var_dump($alltag_ids);
                    // var_dump($post);
                
                    for ($i = 0; $i < count($tag); $i++) {
                        $laQuestionEnSql = "
                    SELECT id FROM tags WHERE label = '$tag[$i]' 
                    ";
                $tagid_info = $mysqli->query($laQuestionEnSql);
                if ( ! $tagid_info)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }
                     $tagid_querry = $tagid_info->fetch_assoc();
                        if ($i == count($tag) - 1) {
                            ?><a href="tags.php?tag_id=<?php echo $tagid_querry ?>"><?php echo (" #" . $tag[$i] . "");
                        } else {
                            ?><a href="tags.php?tag_id=<?php echo $tagid_querry ?>"><?php echo ("#" . $tag[$i] . ",");
                        }
                    }
                }
            ?>
            <!-- </a> -->
        </footer>
    </article>