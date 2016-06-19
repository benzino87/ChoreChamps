<?php
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    $gName = $_POST['postAdmin'];
    $cName = $_POST['postName'];
    
    $query = "SELECT SUM(pointValue) AS totalPoints
                FROM CHORE
                WHERE groupName = '$gName' AND
                      cName = '$cName' AND
                      status = 1";
    $result = mysqli_query($conn, $query);
    $row = $result->fetch_assoc();
    $totalPoints = $row['totalPoints'];
    echo $totalPoints;
    
?>