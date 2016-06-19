<!DOCTYPE html>
<?php
//Verify Session
session_start();
if(!isset($_SESSION['admAccName'])){
    header("Location: /index.html");
}
$root = $_SERVER['DOCUMENT_ROOT'];
include($root."/resources/php/dbcalls/dashboardDBcalls.php");

$admAcc = $_SESSION['admAccName'];
//get rooms and descriptions
$rooms = queryRoom();
$descriptions = queryDescription();
//get champ names from the admin's account
$champs = queryChamps($_SESSION['admAccName']);
//get data from db for uploading current chore list
$choresForChampOne = queryIncompleteChores($admAcc, $champs[0]);
$choresForChampTwo = queryIncompleteChores($admAcc, $champs[1]);
?>
    <html>

    <head>
        <title>Parent Dashboard</title>
        <link rel="stylesheet" href="/resources/css/home.css" type="text/css" />
    </head>

    <body>
        <div class="dashboard">
        <div class=header>
            <div class=logo>
                <img src=/resources/img/logo_tiny.png></img>
            </div>
             <div class="title">
                    <h4>Parent Dashboard</h4>
                </div>
            <div class=logout>
                <a href=logout.php>LOGOUT</a>
            </div>
        </div>
        <div class="toppane">
            <div class="user"><h4>Username:<?php echo $admAcc?></h4></div>
                <div class="main">
                    <ul>GOTO CHAMP DASHBOARD:
                        <li>
                            <a href="/home/dashboard.php?champ=<?php echo $champs[0]?>">
                                <?php echo $champs[0]?>
                            </a>
                        </li>
                        <li>
                            <a href="/home/dashboard.php?champ=<?php echo $champs[1]?>">
                                <?php echo $champs[1]?>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="info">
                    <p>Select the options for chores you would like to create. Select the submit button and you will see the chore created below the form. After that, select the newly created chore and drag it to the desired child.</p>
                </div>
            <div class="Form">
                <form id="choreForm">
                    ROOM:
                    <select id="roomType">
                <?php 
                foreach($rooms as $room){
                    echo "<option id=one type=text name=room value='$room'>$room</option>";
                }
                ?>
                </select> CHORE:
                    <select id="descripType">
                <?php
                foreach($descriptions as $description){
                    echo "<option id=two type=text name=descrip value='$description'>$description</option>";
                }
                ?>
                </select> POINT VALUE:
                    <select id="pointType">
                <?php
                for($i = 1; $i <= 10; $i++){
                    echo "<option id=three type=text name=pointValue value='$i'>$i</option>";
                }
                ?>
                </select>
                    <button type="button" onclick="addToList()">Submit</button>
                </form>
            </div>
        </div>
        <div class="choreList">
            <div class="unassignedChores">
                <ul id="unassigned" ondrop="drop(event)" ondragover="allowDrop(event)"><h2 id="unnasignedTitle">Unassigned chore list</h2>
                </ul>
            </div>
            <div class="assignedChoresOne">
                <ul id="champOne" ondrop="dropOne(event)" ondragover="allowDropOne(event)">
                    <h2 id="champNameOne"><?php echo $champs[0]?></h2>
                    
                    <?php
                    if(count($choresForChampOne) > 0){
                        for($i = 0; $i < count($choresForChampOne); $i++){
                            if($i % 3 == 0){   
                                echo "<li>";
                                echo "<h4>".$choresForChampOne[$i]."</h4>";
                            }else if($i % 3 == 1){
                                echo "<p>".$choresForChampOne[$i]."</p>";
                            }else{
                                echo "<p>Point value:".$choresForChampOne[$i]."</p>";
                                echo "</li>";
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="assignedChoresTwo">
                <ul id="champTwo" ondrop="dropTwo(event)" ondragover="allowDropTwo(event)">
                    <h2 id="champNameTwo"><?php echo $champs[1]?></h2>
                    <?php 
                    if(count($choresForChampTwo) > 0){
                        for($i = 0; $i < count($choresForChampTwo); $i++){
                            if($i % 3 == 0){   
                                echo "<li>";
                                echo "<h4>".$choresForChampTwo[$i]."</h4>";
                            }else if($i % 3 == 1){
                                echo "<p>".$choresForChampTwo[$i]."</p>";
                            }else{
                                echo "<p>Point value:".$choresForChampTwo[$i]."</p>";
                                echo "</li>";
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script type="text/javascript">
        jQuery.noConflict();

        function addToList() {
            /**
             * Retrieve text nodes from select tags after creating unnasigned chore
             */
            var roomType = document.getElementById("roomType");
            var room = roomType.options[roomType.selectedIndex].value;
            var descripType = document.getElementById("descripType");
            var descrip = descripType.options[descripType.selectedIndex].value;
            var pointType = document.getElementById("pointType");
            var point = pointType.options[pointType.selectedIndex].value;

            /**
             * 
             * Create list tag and append data from select tags
             * 
             */
            //create list object
            var list = document.getElementById("unassigned");
            var chore = document.createElement("LI");
            var header = document.createElement("h4");
            header.setAttribute("id", "roomName")
            var textHead = document.createTextNode(room);
            header.appendChild(textHead);
            chore.appendChild(header);

            //create content objects
            var paragraphOne = document.createElement("p");
            paragraphOne.setAttribute("id", "choredescrip");
            var textOne = document.createTextNode(descrip);
            paragraphOne.appendChild(textOne);
            chore.appendChild(paragraphOne);
            var paragraphTwo = document.createElement("p");
            var textTwo = document.createTextNode("Point value:" + point);

            //append content objects to list object
            paragraphTwo.appendChild(textTwo);
            chore.appendChild(paragraphTwo);
            chore.setAttribute("id", "listItem");
            chore.setAttribute("draggable", "true");
            chore.setAttribute("ondragstart", "drag(event)");
            list.appendChild(chore);
        }

        function allowDropOne(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function dropOne(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            // var getData = document.getElementById(data);
            ev.target.appendChild(document.getElementById(data));
            
            //after drop prevent list item from being draggable
            document.getElementById(data).removeAttribute("draggable")

            /**
             * Gets information about the node that was dropped and appends to 
             * a query string
             **/

            var childNameNode = document.getElementById("champOne");
            var childName = document.getElementById("champNameOne").firstChild.nodeValue;
            var temp = document.getElementById(data);
            var listNode = temp.childNodes;
            var room = listNode[0].firstChild.nodeValue;
            var description = listNode[1].firstChild.nodeValue;
            var pointValueTemp = listNode[2].firstChild.nodeValue;
            var pointValue = pointValueTemp.substr(12);
            //conver this to query string

            var admin = "<?php echo $admAcc?>";
            var postData = {
                postAdmin: admin,
                postRoom: room,
                postName: childName,
                postDescrip: description,
                postPoint: pointValue
            };
            console.log(postData);
            jQuery.post("ondragevents.php", postData, function() {
                alert("Chore Added!");
            });
        }

        function allowDropTwo(ev) {
            ev.preventDefault();
        }

        function dropTwo(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            // var getData = document.getElementById(data);
            ev.target.appendChild(document.getElementById(data));
            
            //after drop prevent list item from being draggable
            document.getElementById(data).removeAttribute("draggable")

            /**
             * Gets information about the node that was dropped and appends to 
             * a query string
             **/
            var childNameNode = document.getElementById("champTwo");
            var childName = document.getElementById("champNameTwo").firstChild.nodeValue;

            var temp = document.getElementById(data);
            var listNode = temp.childNodes;
            var room = listNode[0].firstChild.nodeValue;
            var description = listNode[1].firstChild.nodeValue;
            var pointValueTemp = listNode[2].firstChild.nodeValue;
            var pointValue = pointValueTemp.substr(12);

            var admin = "<?php echo $admAcc?>";
            var postData = {
                postAdmin: admin,
                postRoom: room,
                postName: childName,
                postDescrip: description,
                postPoint: pointValue
            };

            jQuery.post("ondragevents.php", postData, function() {
                alert("Added chore!");
            });

        }
    </script>

    </html>