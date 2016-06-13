<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['accName'])){
    header("Location: /welcome/login.html");
}
include('db.php');
$accName = $_SESSION['accName'];
// $chores = queryChores($accName);

?>
<html>
    <head>
        <title>Champ Dashboard</title>
        <link rel="stylesheet" href="dashboards.css" type="text/css" />
    </head>
    <body>
        <div class="titelbar">
            <div class="title">
                <h4>Champ Dashboard</h4>
            </div>
            <div class="info">
                <p>Click and drag the chores you've completed! Once complete you will score some points!</p>
            </div>
        </div>
        <div class="choreList">
            <div class="todo">
                <ul id="todoChores" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <li>Chores not yet complete</li>
                </ul>
            </div>
            <div class="done">
                <ul id="doneChores" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <li>COMPLETE!</li>
                </ul>
            </div>
        </div>
        
        
    </body>
    <script type="text/javascript">
        
        function addToList(){
        //     /**
        //      * Retrieve text nodes from select tags
        //      */
        //     var roomType = document.getElementById("roomType");
        //     var room = roomType.options[roomType.selectedIndex].value;
        //     var descripType = document.getElementById("descripType");
        //     var descrip = descripType.options[descripType.selectedIndex].value;
        //     var pointType = document.getElementById("pointType");
        //     var point = pointType.options[pointType.selectedIndex].value;
            
        //     /**
        //      * Create list tag and append data from select tags
        //      */
        //     var list = document.getElementById("unassigned");
        //     var chore = document.createElement("LI");
        //     var header = document.createElement("h4");
        //     var textHead = document.createTextNode(room);
        //     header.appendChild(textHead);
        //     chore.appendChild(header);
        //     var paragraphOne = document.createElement("p");
        //     var textOne = document.createTextNode(descrip);
        //     paragraphOne.appendChild(textOne);
        //     chore.appendChild(paragraphOne);
        //     var paragraphTwo = document.createElement("p");
        //     var textTwo = document.createTextNode("Point value:"+point);
        //     paragraphTwo.appendChild(textTwo);
        //     chore.appendChild(paragraphTwo);
        //     chore.setAttribute("id", "listItem");
        //     chore.setAttribute("draggable", "true");
        //     chore.setAttribute("ondragstart", "drag(event)");
        //     list.appendChild(chore);
        // }
        
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