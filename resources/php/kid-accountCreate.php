<?php
session_start();
if(!isset($_SESSION['admAccName'])){
    header("Location: index.html");
}
$root = $_SERVER['DOCUMENT_ROOT'];
include($root."/resources/php/dbcalls/signup-loginDBcalls.php");
$admAccount = $_SESSION['admAccName'];
$numberOfChamps = $_SESSION['kidNum'];
$defaultpw = "chorechamp";
$champs = [];
for($i = 0; $i < $numberOfChamps; $i++){
    $champ = $_POST[$i];
    array_push($champs, $champ);
}
for($j = 0; $j < count($champs); $j++ ){
    echo "you made it here";
    $currentChamp = $champs[$j];
    if(insertIntoChamp($currentChamp, $admAccount, 0, $defaultpw)== true){
        header("Location: /home/adminDashboard.php");
    }else{
        header("Location: /setup/setup-kids.php");
    }
}