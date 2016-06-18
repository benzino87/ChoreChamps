<!DOCTYPE html>
<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root."/resources/php/dbcalls/dashboardDBcalls.php");
session_start();
/**
 * Check for admin or user session
 **/
if(!isset($_SESSION['accName']) && !isset($_SESSION['admAccName'])){
    header("Location: /welcome/login.html");
}
/**
 * Check for admin session and use query string to populate data
 **/
if(isset($_SESSION['admAccName']) && !isset($_SESSION['accName'])){
    //view chosen champ from query string
    if(isset($_GET['champ'])){
        $accName = $_GET['champ'];
        $admAcc = $_SESSION['admAccName'];
    }else{
        header("Location: /welcome/login.html");
    }
}
/**
 * Check for user session and use session variable to populate data
 **/
if(isset($_SESSION['accName']) && !isset($_SERVER['admAccName'])){
    //use the champ from session
    $accName = $_SESSION['accName'];
    //NEED TO FIND ADMIN ACCOUNT NAME;
}

$currentChores = queryChores($admAcc, $accName);

?>
<html>
    <head>
        <title>Champ Dashboard</title>
        <link rel="stylesheet" href="/resources/css/home.css" type="text/css" />
    </head>
    <body>
        <div class="dashboard">
        <div class=header>
            <div class=logo>
                <img src=/resources/img/logo_tiny.png></img>
            </div>
             <div class="title">
                    <h4>Champ Dashboard</h4>
                </div>
            <div class=logout>
                <a href=logout.php>LOGOUT</a><br>
                <?php if(isset($_SESSION['admAccName'])){
                    echo "<a href=adminDashboard.php>Admin Dashboard</a>";
                }
                ?>
            </div>
        </div>
            <div class="info-div">
                <div class="showaccname"><h4>Username:
                <?php if(isset($_SESSION['admAccName'])){
                    echo $admAcc;
                    }else{
                        echo $accName;
                        }
                        ?></h4></div>
                <div class="userinfo">
                <h3>Click and drag the chores you've completed! Once complete you will score some points!</h3>
                <p>Your total points are:</p>
                <div class="pointvalue">
                    <p>0</p>
                </div>
            </div>
            </div>
        </div>
        <div class="choreList">
            <div class="todo">
                <ul id="todoChores" ondrop="drop(event)" ondragover="allowDrop(event)">Chores not yet complete
                <?php
                    if(count($currentChores) > 0){
                        for($i = 0; $i < count($currentChores); $i++){
                            if($i % 3 == 0){   
                                echo "<li id=chore draggable=true ondragstart=drag(event)>";
                                echo "<h4>".$currentChores[$i]."</h4>";
                            }else if($i % 3 == 1){
                                echo "<p>".$currentChores[$i]."</p>";
                            }else{
                                echo "<p>Point value:".$currentChores[$i]."</p>";
                                echo "</li>";
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="done">
                <ul id="doneChores" ondrop="drop(event)" ondragover="allowDrop(event)">COMPLETE!
                </ul>
            </div>
        </div>
        
        
    </body>
    <script type="text/javascript">
        
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            // var getData = document.getElementById(data);
            ev.target.appendChild(document.getElementById(data));
            
            /**
             * Gets information about the node that was dropped and appends to 
             * a query string
             **/
           
            var childNameNode = document.getElementById("doneChores");
            var childName = childNameNode.firstChild.nodeValue;
            var temp = document.getElementById(data);
            var listNode = temp.childNodes;
            var room = listNode[0].firstChild.nodeValue;
            var description = listNode[1].firstChild.nodeValue;
            var pointValueTemp = listNode[2].firstChild.nodeValue;
            var pointValue = pointValueTemp.substr(12);
            //conver this to query string
            

            
            // var postData = {
            //     postAdmin : admin,
            //     postRoom : room,
            //     postName : childName,
            //     postDescrip : description,
            //     postPoint : pointValue
            // };
            // console.log(postData);
            // jQuery.post("ondragevents.php", postData, function(){
            //     alert("Added chore!");
            // });
        }
        
        
        
            
        
    </script>
</html>