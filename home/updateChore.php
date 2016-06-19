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
        }
    }else{
        print_r("ERROR: ".mysqli_error($conn). "<br>");
    }
    
    $query = "UPDATE CHORE
                SET status = 1
                WHERE rName = '$room' AND
                        dID = '$dID' AND
                        groupName = '$adm' AND
                        cName = '$name' AND
                        pointValue = '$point'";
    $result = mysqli_query($conn, $query);
    if($result){
        print_r($query);
    }else{
        print_r("ERROR: ".mysqli_error($conn). "<br>");
    }
?>