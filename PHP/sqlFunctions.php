<?php
/**
 * @Author Jason Bensel
 * @Date 29-MAY-2016
 * @Version CIS370 Semester Project
 * Contains all function calls to the mysql database
 */
 
 /*Default variable names*/
$servername = "127.0.0.1";
$username = "benselj";
$password = "";
$db = "ChoreChamps"

/**
 * 
 * Establish a connection and create the Chore Champs database.
 * (Only needs to be run once)
 * 
 */
function createDB(){
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
    }else{
        echo "Connection sucessfull<br>";
    }
    
    $sql = "CREATE DATABASE $db";
    
    if(mysqli_query($conn, $create)){
        echo "$db Created successfully!<br>";
    }else{
        echo "ERROR: ".mysqli_error($conn); "<br>";
    }
    mysqli_close($conn);
}

/**
 * 
 * Establish a connection and create all the tables for the database
 *
 */
function createTables(){
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
    }else{
        echo "Connection sucessfull<br>";
    }
    
    /**
     * Table: Attribute
     * Attributes are descriptions of specific chores
     */
    $attribute = "CREATE TABLE ATTRIBUTE(
        aID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        description VARCHAR(200) NOT NULL
        )";
    
    /**
     * Table: Rooms
     * Rooms are associated with the various locations of the house
     */
    $room = "CREATE TABLE ROOM(
        rID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        aID INT(6) NOT NULL,
        FOREIGN KEY(aID) REFERENCES ATTRIBUTE(aID)
        )";
        
    /**
     * Table: Parent
     * Parents can assign chores, they also contain the information regarding
     * ChoreChamp account.
     */
    $parent = "CREATE TABLE PARENT(
        pID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        groupName = VARCHAR(50),
        pw = VARCHAR(30)
        )";
    
    /**
     * Table Champ(child)
     * Champs are the receipients of the chores, they receive a point value
     * based on the number of chores they complete
     **/
    $champ = "CREATE TABLE CHAMP(
        champID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL, 
        totalPoints INT(6)
        )";
    
    /**
     * Table: Comments
     * Comments are used by both Parents and Champs to set reminders for 
     * specific chores
     **/
    $comments = "CREATE TABLE COMMENT(
        comID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        comment VARCHAR(200) NOT NULL
        )";
    
    /**
     * Table: Chores
     * Chores contain a list of all of the chores, the asigner and the asignee.
     * Chores also contain a point value wich will be derived when the Champ
     * moves a chore status to "Done".
     **/
    $chores = "CREATE TABLE CHORE(
        cID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        rID INT(6) NOT NULL,
        aID INT(6) NOT NULL,
        pID INT(6) NOT NULL,
        comID INT(6) NOT NULL,
        pointValue INT(6) NOT NULL,
        FOREIGN KEY(rID) REFERENCES ROOM(rID),
        FOREIGN KEY(aID) REFERENCES ATTRIBUTE(aID),
        FOREIGN KEY(pID) REFERENCES PARENT(pID),
        FOREIGN KEY(comID) REFERENCES COMMENT(comID)
        )";
    
    /**
     * Table: Status
     * Status contains the chore assigned to the champ and monitors its progress
     * ("TODO", "INPROGRESS", "DONE")
     **/
    $status = "CREATE TABLE STATUS(
        status VARCHAR(20) PRIMARY KEY,
        cID INT(6) NOT NULL,
        champID INT(6) NOT NULL,
        FOREIGN KEY(cID) REFERENCES CHORE(cID),
        FOREIGN KEY(champID) REFERENCES CHAMP(champID)
        );"
    
    /**
     * Actually create the above tables
     **/
    if(mysqli_query($conn, $attribute)){
        echo "TABLE: ATTRIBUTES SUCCESSFULLY CREATED<br>";
    }else{
        echo "ERROR TABLE(ATTRIBUTES): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $room)){
        echo "TABLE: ROOMS SUCCESSFULLY CREATED<br>";
    }else{
        echo "ERROR TABLE(ROOM): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $parent)){
        echo "TABLE: PARENTS SUCCESSFULLY CREATED<br>";
    }else{
        echo "ERROR TABLE(PARENT): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $champ)){
        echo "TABLE: CHAMPS SUCCESSFULLY CREATED<br>";
    }else{
        echo "ERROR TABLE(CHAMP): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $comments)){
        echo "TABLE: COMMENTS SUCCESSFULLY CREATED<br>";
    }else{
        echo "ERROR TABLE(COMMENT): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $chores)){
        echo "TABLE: CHORES SUCCESSFULLY CREATED<br>";
    }else{
        echo "ERROR TABLE(CHORES): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $status)){
        echo "TABLE: STATUS SUCCESSFULLY CREATED<br>";
    }else{
        echo "ERROR TABLE(STATUS): ".mysqli_error($conn); "<br>";
    }
    mysqli_close($conn);
}

/**
 * DROP ALL TABLES
 */
function dropTables(){
    $conn = mysqli_connect($servername, $username, $password, $db);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error())."<br>";
    }else{
        echo "Connection sucessfull<br>";
    }
    
    $dropAttribute = "DROP TABLE ATTRIBUTE";
    $dropRoom = "DROP TABLE ROOM";
    $dropParent = "DROP TABLE PARENT";
    $dropChamp = "DROP TABLE CHAMP";
    $dropComment = "DROP TABLE COMMENT";
    $dropChore = "DROP TABLE CHORE";
    $dropStatus = "DROP TABLE STATUS";
    
    if(mysqli_query($conn, $attribute)){
        echo "TABLE: ATTRIBUTES SUCCESSFULLY DROPPED<br>";
    }else{
        echo "ERROR TABLE(ATTRIBUTES): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $room)){
        echo "TABLE: ROOMS SUCCESSFULLY DROPPED<br>";
    }else{
        echo "ERROR TABLE(ROOM): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $parent)){
        echo "TABLE: PARENTS SUCCESSFULLY DROPPED<br>";
    }else{
        echo "ERROR TABLE(PARENT): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $champ)){
        echo "TABLE: CHAMPS SUCCESSFULLY DROPPED<br>";
    }else{
        echo "ERROR TABLE(CHAMP): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $comments)){
        echo "TABLE: COMMENTS SUCCESSFULLY DROPPED<br>";
    }else{
        echo "ERROR TABLE(COMMENT): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $chores)){
        echo "TABLE: CHORES SUCCESSFULLY DROPPED<br>";
    }else{
        echo "ERROR TABLE(CHORES): ".mysqli_error($conn); "<br>";
    }
    
    if(mysqli_query($conn, $status)){
        echo "TABLE: STATUS SUCCESSFULLY DROPPED<br>";
    }else{
        echo "ERROR TABLE(STATUS): ".mysqli_error($conn); "<br>";
    }
    mysqli_close($conn);
}
