<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['admAccName'])){
    header("Location: /welcome/login.html");
}
include('db.php');
$rooms = queryRoom();
$descriptions = queryDescription();
$champs = queryChamps($_SESSION['admAccName']);
?>
<html>
    <head>
        <title>Parent Dashboard</title>
        <link rel="stylesheet" href="dashboards.css" type="text/css" />
    </head>
    <body>
        <div class="titelbar">
            <div class="title">
                <h4>Parent Dashboard</h4>
            </div>
            <div class="info">
                <p>Select the options for chores you would like to create. 
                Select the submit button and you will see the chore created below the form.
                After that, select the newly created chore and drag it to the desired child.</p>
            </div>
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
                </select>
                CHORE:
                <select id="descripType">
                <?php
                foreach($descriptions as $description){
                    echo "<option id=two type=text name=descrip value='$description'>$description</option>";
                }
                ?>
                </select>
                POINT VALUE:
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
        <div class="choreList">
            <div class="unassignedChores">
            <ul id="unassigned" ondrop="drop(event)" ondragover="allowDrop(event)">
                <li>Unassigned chore list</li>
            </ul>
            </div>
            <div class="assignedChoresOne">
                <ul id="champOne" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <li><?php echo $champs[0]?></li>
                </ul>
            </div>
            <div class="assignedChoresTwo">
                <ul id="champTwo" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <li><?php echo $champs[1]?></li>
                </ul>
            </div>
        </div>
        
        
    </body>
    <script type="text/javascript">
        
        function addToList(){
            /**
             * Retrieve text nodes from select tags
             */
            var roomType = document.getElementById("roomType");
            var room = roomType.options[roomType.selectedIndex].value;
            var descripType = document.getElementById("descripType");
            var descrip = descripType.options[descripType.selectedIndex].value;
            var pointType = document.getElementById("pointType");
            var point = pointType.options[pointType.selectedIndex].value;
            
            /**
             * Create list tag and append data from select tags
             */
            var list = document.getElementById("unassigned");
            var chore = document.createElement("LI");
            var header = document.createElement("h4");
            var textHead = document.createTextNode(room);
            header.appendChild(textHead);
            chore.appendChild(header);
            var paragraphOne = document.createElement("p");
            var textOne = document.createTextNode(descrip);
            paragraphOne.appendChild(textOne);
            chore.appendChild(paragraphOne);
            var paragraphTwo = document.createElement("p");
            var textTwo = document.createTextNode("Point value:"+point);
            paragraphTwo.appendChild(textTwo);
            chore.appendChild(paragraphTwo);
            chore.setAttribute("id", "listItem");
            chore.setAttribute("draggable", "true");
            chore.setAttribute("ondragstart", "drag(event)");
            list.appendChild(chore);
        }
        
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
            
        }
        
        
        
            
        
    </script>
</html>