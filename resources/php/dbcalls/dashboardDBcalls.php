<?php

function queryDescription(){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    $query = "SELECT description
                FROM DESCRIPTION";
    
    $result = mysqli_query($conn, $query);
    $descriptions = array();
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            array_push($descriptions, $row['description']);
        }
        return $descriptions;
    }
}
function queryRoom(){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    $query = "SELECT DISTINCT name
                FROM ROOM";
    
    $result = mysqli_query($conn, $query);
    $rooms = array();
    if($result){
        $count = 0;
        while($row = mysqli_fetch_assoc($result)){
             array_push($rooms, $row['name']);
        }
        return $rooms;
    }
}
function queryChamps($groupName){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    $query = "SELECT name
                FROM CHAMP
                WHERE groupName = '$groupName'";
    
    $result = mysqli_query($conn, $query);
    $rooms = array();
    if($result){
        $count = 0;
        while($row = mysqli_fetch_assoc($result)){
             array_push($rooms, $row['name']);
        }
        return $rooms;
    }
}
function queryChores($gName, $cName){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    $query = "SELECT c.rName, d.description, c.pointValue
                FROM CHORE c, DESCRIPTION d
                WHERE c.dID = d.dID AND
                c.cName = '$cName' AND
                c.groupName = '$gName'";
    $result = mysqli_query($conn, $query);
    $choreDescription = array();
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            array_push($choreDescription, $row['rName']);
            array_push($choreDescription, $row['description']);
            array_push($choreDescription, $row['pointValue']);
        }
    }
    return $choreDescription;
}
?>