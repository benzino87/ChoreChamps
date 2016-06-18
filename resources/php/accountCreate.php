<?php
//Check if there is a post value from sign up form
session_start();
if(!isset($_POST['groupName'])){
    header("Location: /index.html");
}
$root = $_SERVER['DOCUMENT_ROOT'];
include($root."/resources/php/dbcalls/signup-loginDBcalls.php");
$posts = array($_POST['email'],
                $_POST['firstName'],
                $_POST['lastName'],
                $_POST['groupName'],
                $_POST['kidNum'],
                $_POST['password1'],
                $_POST['password2']);
$data = array($email,
                $firstName,
                $lastName, 
                $groupName, 
                $kidNum, 
                $password1, 
                $password2);
                
$_SESSION['admAccName'] = $_POST['groupName'];
$_SESSION['kidNum'] = $_POST['kidNum'];

for($i = 0; $i < count($posts); $i++){
    if(isset($posts[$i])){
        $data[$i] = $posts[$i];
    }
}
if(insertIntoParent($data[3], $data[1], $data[2], $data[0], $data[5])==true){
    header("Location: /setup/setup-kids.php");
}else{
    header("Location: /index.html");
}
                    
?>