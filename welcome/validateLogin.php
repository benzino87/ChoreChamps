<?php
include('db.php');
session_start();
$accName = $_POST['accName'];
$pwd = $_POST['password'];

/**
 * check post to verify basic user or admin user
 **/
if(strpos($accName, '.') == true){
    $pos = strpos($accName, '.');
    $tempPos = $pos--;
    $group = substr($accName, 0, $tempPos);
    $pos = $pos+2;
    $account = substr($accName, $pos);
    if(queryLoginBasic($account, $group, $pwd) == true){
        $_SESSION['accName'] = $accName;
        header("Location: /home/dashboard.php");
    }else{
        header("Location: login.html");
    }
}else{
    if(queryLoginAdmin($accName, $pwd) == true){
        $_SESSION['admAccName'] = $accName;
        header("Location: /home/adminDashboard.php");
    }else{
        header("Location: login.html");
    }
}


?>