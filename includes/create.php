<?php
require_once "header.php";

if (isset($_POST['article_title']) && isset($_POST['article_text'])){
    require_once "conn.php";
    require_once "functions.php";



//    save images

    if ( ! empty($_FILES["article_images"]["size"])) {
        //TODO: fix condition - currently an img has to be provided otherwise article isnt uploaded
        // tmpPathError
        try {
            $paths = save_img($_SESSION['userName']);
            $creation_time = time();

            $stmt = "INSERT INTO articles
                (articleAuthor, articleCreationDate, articlePhoto, articleTitle,articleContent)
                VALUES (?,?,?,?,?)
                ";

            $stmt = $conn->prepare($stmt);
            $stmt->bind_param(
                'sssss',
                $_SESSION['userName'],
                $creation_time,
                $paths,
                $_POST['article_title'],
                $_POST['article_text']);
            echo $stmt->execute();

        } catch (Exception $e) {
            echo "<p class='error_message' >ERROR:" . $e->getMessage(). "</p>";
        }
    }


}
?>

<!--TODO: Preview on right-->

<script type="text/javascript">
    $( function() {
        $( "#article_text" ).resizable();
    } );
</script>

<form id="article_form" method="post" enctype="multipart/form-data">
    <label>Create Article</label>
    <input class="title_input ui-widget-content" type="text" placeholder="Title" name="article_title">
    <textarea id='article_text' placeholder="Article Text" name="article_text"></textarea>
    <input type="file" placeholder="Image" name="article_images[]" multiple>
<!--    TODO: display images selected to upload  https://stackoverflow.com/questions/12368910/html-display-image-after-selecting-filename -->
<!--    USE GRID DUMBASS -->
    <br>
    <button type="submit" id="article_submit">Send</button>


</form>
