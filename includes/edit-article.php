<?php

session_start();

if ( !isset($_POST['article_title'],$_POST['article_text'],$_FILES['article_images'],$_POST['article_id'])){
    exit("something is wrong");
}
require_once 'functions.php';
require_once 'conn.php';

try{
$paths = save_img($_SESSION['userName']);

//TODO: delete old imgs

if (edit_article(
    $conn,
    $_POST['article_id'],
    $_POST['article_title'],
    $_POST['article_text'],
    $paths
)){
    header('Location: ../index.php?error=none');
    exit();
}
}catch (Exception $e){
    header("Location: ../index.php?error=$e");
    exit();
}

header("Location: ../index.php?error=someErrorXD");
exit();



