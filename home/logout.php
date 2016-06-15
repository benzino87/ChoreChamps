<?php
session_start();
if(isset($_SESSION['admAccName'])){
    unset($_SESSION['admAccName']);
    session_destroy();
}else if(isset($_SESSION['accName'])){
    unset($_SESSION['accName']);
    session_destroy();
}
?>
<html>
    <body>
        <div>
            <h2>You have been logged out</h2>
            <p>If you're not redirected in 5 seconds click <a href="/welcome/login.html">here</a></p>
        </div>
    </body>
</html>

<?
header("Location: /welcome/login.html");
?>