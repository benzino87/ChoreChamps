<?php
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    $adm = $_POST['postAdmin'];
    $name = $_POST['postName'];
    $room = $_POST['postRoom'];
    $descrip = $_POST['postDescrip'];
    $point = $_POST['postPoint'];
    
    //need to get description id first
    $dID = "";
    $queryDescription = "SELECT dID FROM DESCRIPTION WHERE description = '$descrip'";
    $queryResult = mysqli_query($conn, $queryDescription);
    if($queryResult){
        while($tempRow = mysqli_fetch_assoc($queryResult)){
            $dID = $tempRow['dID'];
            print_r($dID);
        }
    }else{
        print_r("ERROR: ".mysqli_error($conn). "<br>");
    }
    $query = "INSERT INTO CHORE(rName, dID, groupName, cName, pointValue) 
                        VALUES('$room', '$dID', '$adm', '$name', '$point')";
    
    $result = mysqli_query($conn, $query);
    if($result){
        print_r($query);
    }else{
        print_r("ERROR: ".mysqli_error($conn). "<br>");
    }
   
?>