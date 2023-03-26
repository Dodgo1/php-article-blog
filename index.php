<?php
include_once("includes/header.php");
?>

<div id="main">


    <div id="column_left">
        <?php
            require_once 'includes/functions.php';
            require_once 'includes/conn.php';
            $newest_articles = array_slice(get_articles($conn),0,10);
            foreach ($newest_articles as $article) {
                $title = $article['articleTitle'];
                $content = cut_article_content($article['articleContent'],80);
                $date = date("H:i d-m-Y", substr($article['articleCreationDate'], 0, 10));
                $author = $article['articleAuthor'];
                $img = explode(",",$article['articlePhoto']);

                echo "
                    <div class='article_main'>
                        <h1 class='article_title'>$title</h1>
                        <div>
                        <img class='article_icon' src='$img[0]' alt='article_icon'>
                        <p class='article_content'>$content ... <a class='article_more' href='#'>Read more here</a></p>
                        </div>
                        <p class='article_author'>Author: $author</p>
                        <p class='article_creation'>$date</p>
                    </div>";
            }
        ?>



    </div>


    <!-- TODO: when mobile hide this column as tray to right or create another one?-->
    <div id="column_right">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid nam nulla obcaecati ex omnis error!
        Assumenda, ipsa. Nostrum minus eos doloribus ratione qui voluptatum,
        obcaecati tenetur nobis repellendus itaque eligendi.
    </div> 
    
</div>



<?php
include_once("includes/footer.php");

