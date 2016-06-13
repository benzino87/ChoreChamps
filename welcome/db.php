<?php
/**
 * Creates new parent account when user hits sign up
 **/
function insertIntoParent($groupName, $firstName, $lastName, $email, $pwd){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
        return false;
    }else{
        echo "Connection sucessfull<br>";
    }
    
    $query = "INSERT INTO PARENT(groupName, firstName, lastName, email, pw)
                    VALUES('$groupName', '$firstName', '$lastName', '$email', '$pwd')";
                    
    if(mysqli_query($conn, $query)){
        print_r("INSERT SUCCESSFULL");
        return true;
    }else{
        print_r("ERROR INSERT('$groupName'): ".mysqli_error($conn). "<br>");
        return false;
    }
    mysqli_close($conn);
}

function insertIntoChamp($name, $groupName, $totalPoints, $pwd){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
        return false;
    }else{
        echo "Connection sucessfull<br>";
    }
    $query = "INSERT INTO CHAMP(name, groupName, totalPoints, pw)
                    VALUES('$name', '$groupName', '$totalPoints', '$pwd')";
    if(mysqli_query($conn, $query)){
        print_r("INSERT SUCCESSFULL");
        return true;
    }else{
        print_r("ERROR INSERT('$name'): ".mysqli_error($conn). "<br>");
        return false;
    }
    mysqli_close($conn);
}

function queryLoginBasic($accName, $groupName, $pwd){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
        return false;
    }else{
        echo "Connection sucessfull<br>";
    }
    
    $query = "SELECT * 
                FROM CHAMP 
                WHERE name = '$accName' AND 
                      groupName = '$groupName' AND
                      pw = '$pwd'";
    
    $result = mysqli_query($conn, $query);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            if($pwd == $row['pw']){
                return true;
            }else{
                return false;
            }
        }
    }
    
}
function queryLoginAdmin($groupName, $pwd){
    $servername = "127.0.0.1";
    $username = "benselj";
    $password = "";
    $db = "CHORECHAMPS";
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
        return false;
    }else{
        echo "Connection sucessfull<br>";
    }
    
    $query = "SELECT * 
                FROM PARENT 
                WHERE groupName = '$groupName' AND
                      pw = '$pwd'";
    
    $result = mysqli_query($conn, $query);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            if($pwd == $row['pw']){
                return true;
            }else{
                return false;
            }
        }
    }
}
?>