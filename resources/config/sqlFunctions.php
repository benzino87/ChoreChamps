<?php
/**
 * @Author Jason Bensel
 * @Date 29-MAY-2016
 * @Version CIS370 Semester Project
 * Contains all function calls to the mysql database
 */

/**
 * 
 * Establish a connection and create the Chore Champs database.
 * (Only needs to be run once)
 * 
 */
function createDB($servername, $username, $password, $db){
    $conn = mysqli_connect($servername, $username, $password);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
    }else{
        print_r("Connection sucessfull<br>");
    }
    
    $sql = "CREATE DATABASE $db";
    
    if(mysqli_query($conn, $sql)){
        print_r("'$db' Created successfully!<br>");
    }else{
        print_r("ERROR: ".mysqli_error($conn)."<br>");
    }
}

/**
 * 
 * Establish a connection and create all the tables for the database
 *
 */
function createTables($servername, $username, $password, $db){
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
    }else{
        print_r("Connection sucessfull<br>");
    }
    
    /**
     * Table: Description
     * Description of specific chores
     */
    $description = "CREATE TABLE DESCRIPTION(
        dID INT(6) AUTO_INCREMENT PRIMARY KEY,
        description VARCHAR(200) NOT NULL
        )";
    
    /**
     * Table: Rooms
     * Rooms are associated with the various locations of the house
     */
    $room = "CREATE TABLE ROOM(
        name VARCHAR(30) NOT NULL,
        dID INT(6) NOT NULL,
        CONSTRAINT FOREIGN KEY(dID) REFERENCES DESCRIPTION(dID),
        PRIMARY KEY(name, dID)
        )";
        
    /**
     * Table: Parent
     * Parents can assign chores, they also contain the information regarding
     * ChoreChamp account.
     */
    $parent = "CREATE TABLE PARENT(
        groupName VARCHAR(30) PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        pw VARCHAR(30) NOT NULL
        )";
    
    /**
     * Table Champ(child)
     * Champs are the receipients of the chores, they receive a point value
     * based on the number of chores they complete
     **/
    $champ = "CREATE TABLE CHAMP(
        name VARCHAR(30) NOT NULL, 
        groupName VARCHAR(30) NOT NULL,
        totalPoints INT(6),
        CONSTRAINT FOREIGN KEY(groupName) REFERENCES PARENT(groupName),
        pw VARCHAR(30),
        PRIMARY KEY(name, groupName)
        )";
    
    /**
     * Table: Comments
     * Comments are used by both Parents and Champs to set reminders for 
     * specific chores
     **/
    $comments = "CREATE TABLE COMMENT(
        comID INT(6) AUTO_INCREMENT PRIMARY KEY,
        comment VARCHAR(200) NOT NULL
        )";
    
    /**
     * Table: Chores
     * Chores contain a list of all of the chores, the asigner and the asignee.
     * Chores also contain a point value wich will be derived when the Champ
     * moves a chore status to "Done".
     **/
    $chores = "CREATE TABLE CHORE(
        cID INT(6) AUTO_INCREMENT PRIMARY KEY,
        rName VARCHAR(30) NOT NULL,
        dID INT(6) NOT NULL,
        groupName VARCHAR(30) NOT NULL,
        cName VARCHAR(30) NOT NULL,
        comID INT(6),
        pointValue INT(6) NOT NULL,
        status TINYINT(1) DEFAULT 0,
        CONSTRAINT FOREIGN KEY(rName) REFERENCES ROOM(name),
        CONSTRAINT FOREIGN KEY(dID) REFERENCES DESCRIPTION(dID),
        CONSTRAINT FOREIGN KEY(groupName) REFERENCES PARENT(groupName),
        CONSTRAINT FOREIGN KEY(cName) REFERENCES CHAMP(name),
        CONSTRAINT FOREIGN KEY(comID) REFERENCES COMMENT(comID)
        )";
    
    /**
     * Store the table creations in an array list for running queries
     **/
    $createTables = array($description, $room, $parent, $champ, $comments, 
                            $chores);
    
    foreach($createTables as $element){
        print_r($element);
        if(mysqli_query($conn, $element)){
        $tableName = substr($element, 13, strpos($element, '('));
        print_r("TABLE: '$tableName' SUCCESSFULLY CREATED<br><br>");
    }else{
        print_r("ERROR TABLE('$tableName'): ".mysqli_error($conn). "<br><br>");
        }
    }
    mysqli_close($conn);
}

/**
 * DROP ALL TABLES
 */
function dropTables($servername, $username, $password, $db){
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
    }else{
        echo "Connection sucessfull<br>";
    }
    
    $dropDescription = "DROP TABLE DESCRIPTION";
    $dropRoom = "DROP TABLE ROOM";
    $dropParent = "DROP TABLE PARENT";
    $dropChamp = "DROP TABLE CHAMP";
    $dropComment = "DROP TABLE COMMENT";
    $dropChore = "DROP TABLE CHORE";
    $dropStatus = "DROP TABLE STATUS";
    
    
    /**
     * Drops need to happen in reverse order because of dependencies
     **/
    $dropArray = array($dropStatus, $dropChore, $dropComment, $dropChamp, 
                        $dropParent, $dropRoom, $dropDescription);
    
    foreach($dropArray as $element){
        if(mysqli_query($conn, $element)){
              $tableName = substr($element, 11);
        print_r("TABLE: '$tableName' SUCCESSFULLY DROPPED<br>");
    }else{
        print_r("ERROR TABLE('$tableName'): ".mysqli_error($conn). "<br>");
    }
    }
    mysqli_close($conn);
}
?>