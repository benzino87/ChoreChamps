<?php
include('sqlFunctions.php');


 /*Default variable names*/
$servername = "127.0.0.1";
$username = "benselj";
$password = "";
$db = "CHORECHAMPS";

createTables($servername, $username, $password, $db);
?>