<?php


if (empty($_POST['username'])){
    echo "aaa";
    header("Location:../index.php?error=emptyUsername");
    exit();
}

if (empty($_POST['password'])){
    echo "aaa";
    header("Location:../index.php?error=emptyPassword");
    exit();
}

require_once "conn.php";
require_once "functions.php";

if(usernameExists($_POST['username'],$conn)){
    header("Location:../index.php?error=usernameExists");
    exit();
}
$result = createUser($_POST['username'],$_POST['password'],$conn);

if(gettype($result) == "string"){
    header("Location:../index.php?error=$result");
    exit();
}

require "login.php";
header("Location:../index.php");
session_start();

exit();