<?php
/**
 * Function used to populate descriptions in select tag for building chore list item
 **/
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
/**
 * Function used to populate room names in select tag for build chore list item
 **/
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
/**
 * Function used to populate kid names for admin dashboard chore distrubution
 **/
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
/**
 * Function used to query currently distributed INCOMPLETE chores
 **/
function queryIncompleteChores($gName, $cName){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    $query = "SELECT c.rName, d.description, c.pointValue
                FROM CHORE c, DESCRIPTION d
                WHERE c.dID = d.dID AND
                c.cName = '$cName' AND
                c.groupName = '$gName' AND
                c.status = 0";
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
/**
 * Function used to query currently distributed COMPLETE chores
 **/
function queryCompleteChores($gName, $cName){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    $query = "SELECT c.rName, d.description, c.pointValue
                FROM CHORE c, DESCRIPTION d
                WHERE c.dID = d.dID AND
                c.cName = '$cName' AND
                c.groupName = '$gName' AND
                c.status = 1";
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
function queryTotalPoints($gName, $cName){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    
    $query = "SELECT SUM(pointValue) AS totalPoints
                FROM CHORE
                WHERE groupName = '$gName' AND
                      cName = '$cName' AND
                      status = 1";
    $result = mysqli_query($conn, $query);
    $row = $result->fetch_assoc();
    $totalPoints = $row['totalPoints'];
    if(!is_null($totalPoints)){
        return $totalPoints;
    }
    return 0;
}
?>