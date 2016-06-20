<!DOCTYPE html>
<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include($root."/resources/php/dbcalls/dashboardDBcalls.php");
session_start();
/**
 * Check for admin or user session
 **/
if(!isset($_SESSION['accName']) && !isset($_SESSION['admAccName'])){
    header("Location: /index.html");
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
        header("Location: /index.html");
    }
}
/**
 * Check for user session and use session variable to populate data
 **/
if(isset($_SESSION['accName']) && !isset($_SESSION['admAccName'])){
    //use the champ from session
    $accName = $_SESSION['accName'];
    $admAcc = $_SESSION['userGroup'];
    //NEED TO FIND ADMIN ACCOUNT NAME;
}
$currentChores = queryIncompleteChores($admAcc, $accName);
$completedChores = queryCompleteChores($admAcc, $accName);
$totalPoints = queryTotalPoints($admAcc, $accName);

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
                    <p id="totalPoints"><?php echo $totalPoints?></p>
                </div>
            </div>
            </div>
        </div>
        <div class="choreList">
            <div class="todo">
                <ul id="todoChores">Chores not yet complete
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
                <?php
                    if(count($completedChores) > 0){
                        for($i = 0; $i < count($completedChores); $i++){
                            if($i % 3 == 0){   
                                echo "<li>";
                                echo "<h4>".$completedChores[$i]."</h4>";
                            }else if($i % 3 == 1){
                                echo "<p>".$completedChores[$i]."</p>";
                            }else{
                                echo "<p>Point value:".$completedChores[$i]."</p>";
                                echo "</li>";
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        
        
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script type="text/javascript">
    jQuery.noConflict();
        
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
            
            //after drop prevent list item from being draggable
            //document.getElementById(data).removeAttribute("draggable");
            
            /**
             * Gets information about the node that was dropped and appends to 
             * a query string
             **/
           
            var childNameNode = document.getElementById("doneChores");
            var temp = document.getElementById(data);
            var listNode = temp.childNodes;
            var room = listNode[0].firstChild.nodeValue;
            var description = listNode[1].firstChild.nodeValue;
            var pointValueTemp = listNode[2].firstChild.nodeValue;
            var pointValue = pointValueTemp.substr(12);
            //conver this to query string
            
            
            //Use Jquery AJAX call to update database
            var admin = "<?php echo $admAcc?>";
            var user = "<?php echo $accName?>";
            var postData = {
                postAdmin : admin,
                postRoom : room,
                postName : user,
                postDescrip : description,
                postPoint : pointValue
            };
            console.log(postData);
            jQuery.post("updateChore.php", postData, function(){
                alert("Chore complete!!");
            });
            
            var currentPoints = "<?php echo $totalPoints?>";
            var postData2 = {
                postAdmin : admin,
                postName : user
            };
            jQuery.post("countPoints.php", postData2, function(response, status){
                document.getElementById("totalPoints").innerHTML = response;
            });
        }
        
        
            
        
    </script>
</html>