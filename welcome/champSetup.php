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
        <div class="champSetup">
        <h2>We're almost done!</h2>
            <h4>Enter the name(s) of your kids<br>
            This will set up accounts for them<br>
            Once they have accounts they will login under your Group name<br>
            EX: TheStarks.Rob</h4>
            
        <form method="POST" action="createChamps.php" name="kidForm" onsubmit="return checkFields()">
            <?php
            for($i = 0; $i < $numberOfKids; $i++){
                echo $i.". Kid name:<br>";
                echo "<input type=text name='$i'/><br>";
            }
            ?>
            <input type="submit" value="Submit"/>
        </form>
    </body>
    </div>
    <script type="text/javascript">
        var numOfKids = "<?php echo $numberOfKids?>";
        console.log(numOfKids);
        function checkFields(){
            for(var i = 0; i < numOfKids; i++){
                var field = document.forms["kidForm"][i].value;
                if(field == "" || field == null){
                    alert("You're missing a kid!");
                    return false;
                }
            }
        }
    </script>
</html>