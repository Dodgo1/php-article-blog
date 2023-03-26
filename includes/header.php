<!DOCTYPE html>

<?php
session_start();
require_once 'functions.php';
require_once 'conn.php';
?>
<html lang="pl">
<header>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="author">
    <meta charset="UTF-8">
    <title>Article-blog</title>

    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">

    <!--  js to compare passwords on register  -->

</header>
    <body>
        <?php
        if (isset($_GET['error'])){
            if ($_GET['error'] === "noUser"){
                // Overlaps whole body and asks user to register
                // Control if button is working by js comparing password fields
                echo '
                <div id="index-overlap">
                    <form  action="/includes/register.php" id="register_form" method="post">
                        <label id="register_label" for="nav_login">There is no such user - register!</label>
                        <input class="login_input" id="register_username" placeholder="Username" type="text" name="username">
                        <input class="login_input" id="register_password" placeholder="Password" type="password" name="password">
                        <input class="login_input" id="register_password2" placeholder="Repeat password" type="password" name="password2">
                        <button formaction="/index.php">Go Back</button>
                        <button id="register_submit">Register</button>
                    </form>
                </div>
                <script src="/js/register.js"></script>
                ';
            }
        }
        ?>

        <nav id="nav">
            <img src="/logos/svg/logo-no-background.svg" id="logo" alt="logo">
            <a id="nav_element" href="/index.php">Home</a>
            <a id="nav_element" href="/includes/user-articles.php">My articles</a>
        <?php
        if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] === true){
            echo '
                <a id="nav_element" href="/includes/create.php">Create</a>
                <a id="nav_element" href="/includes/log-out.php">Log Out</a>';
            if ($_SESSION['userStatus'] == "ADMIN"){
                echo '<a id="nav_element" href="/includes/admin.php">Admin</a>';
            }
        }
        if( ! isset($_SESSION['is_logged'])){
            echo '
                <form id="nav_form" action="/includes/login.php" method="post">
                    <label for="nav_login"></label>
                    <input class="login_input" id="nav_login" placeholder="Username" type="text" name="username">
                    <input class="login_input" placeholder="Password" type="password" name="password">
                    <input type="submit" value="Log in" id="nav_login_submit">
                </form>';

        }else if($_SESSION['is_logged']){
            echo '<a class="user_icon" href="/includes/user.php"><i class="icon-user icon-3x"></i></a>';
        }
        ?>


        </nav>

    