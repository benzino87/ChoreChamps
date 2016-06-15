<?php
session_start();
if(!isset($_SESSION['admAccName'])){
    header("Location: login.php");
}
$numberOfKids = $_SESSION['kidNum'];
?>
<html>
    <link rel="stylesheet" type="text/css" href="champ.css" />
    <body>
    <div class="champ">
        <div class="champSetup">
        <h2>We're almost done!</h2>
            <h4>Enter the name(s) of your kids<br>
            This will set up accounts for them<br>
            Once they have accounts they will login under your Group name<br>
            EX: TheStarks.Rob</h4>
        <div class="champForm"> 
        <form method="POST" action="createChamps.php" name="kidForm" onsubmit="return checkFields()">
            <?php
            for($i = 0; $i < $numberOfKids; $i++){
                echo "Kid name:<br>";
                echo "<input type=text name='$i'/><br>";
            }
            ?>
            <input type="submit" value="Submit"/>
        </form>
        </div>
        <div class="invalid_response">
            <p id="response"></p>
        </div>
     </div>
    </div>
    </body>
    <script type="text/javascript">
        var numOfKids = "<?php echo $numberOfKids?>";
        console.log(numOfKids);
        function checkFields(){
            for(var i = 0; i < numOfKids; i++){
                var field = document.forms["kidForm"][i].value;
                if(field == "" || field == null){
                    var response = document.getElementById("response");
                    response.innerHTML = "You must enter names for each child";
                    return false;
                }
            }
        }
    </script>
</html>