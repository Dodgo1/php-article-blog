<?php

require_once "conn.php";
require_once "functions.php";

if(!usernameExists($_POST['username'],$conn)){
    header("Location:../index.php?error=noUser");
    exit();
}

if (isUserBlocked($_POST['username'],$conn)){
    header("Location:../index.php?error=userBlocked");
    exit();
}

if (!compare_passwords($_POST['username'],$_POST['password'],$conn)){
    header("Location:../index.php?error=badPassword");
    exit();
}

session_start();

$_SESSION['is_logged'] = true;
foreach(get_user($_POST['username'],$conn) as $key => $value){
    $_SESSION[$key] = $value;
};


header("Location:../index.php");
exit();




