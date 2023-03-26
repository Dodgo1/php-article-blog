<?php
require_once 'header.php';

$articles = get_articles($conn,$author=$_SESSION['userName']);

if (isset($_POST['article_id'])){

    $article = get_article($conn,$_POST['article_id']);
    $id = $_POST['article_id'];
    $title = $article['articleTitle'];
    $content = $article['articleContent'];
    $icon = $_SERVER['DOCUMENT_ROOT'] . explode(",",$article['articlePhoto'])[0];

//    TODO: handle images - display and ui edit?
//    TODO!: send edits = function is ready just pass params

    echo"
    <script type=\'text/javascript\'>
        $( function() {
            $( '#article_text' ).resizable();
        } );
    </script>
    
    <form id='article_form' action='/includes/edit-article.php' method='post' enctype='multipart/form-data'>
        <label>Create Article</label>
        <input type='hidden' name='article_id' value='$id'>
        <input class='title_input ui-widget-content' value='$title' type='text' placeholder='Title' name='article_title'>
        <textarea id='article_text' placeholder='Article Text' name='article_text'>$content</textarea>
        <input type='file' placeholder='Image' name='article_images[]' multiple>
    <!--    TODO: display images selected to upload  https://stackoverflow.com/questions/12368910/html-display-image-after-selecting-filename -->
    <!--    USE GRID DUMBASS -->
        <br>
        <button type='submit' id='article_submit'>Send</button>
    
    
    </form>";
    
    exit();
}

foreach ($articles as $article){
    $id = $article['articleId'];
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
                <p class='article_content'>$content ... 
                    <form action='#' method='post'>
                        <input type='hidden' name='article_id' value='$id' />
                        <button class='article_more' type='submit'>EDIT</button>
                    </form>
                </p>
                </div>
                <p class='article_author'>Author: $author</p>
                <p class='article_creation'>$date</p>
            </div>";
}