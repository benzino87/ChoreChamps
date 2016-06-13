<?php
$f = fopen("insertData.txt", "r");
$servername = "127.0.0.1";
$username = "benselj";
$password = "";
$db = "CHORECHAMPS";
$conn = mysqli_connect($servername, $username, $password, $db);
if(!$conn){
    die("Connection failed: " . mysqli_connect_error())."<br>";
}else{
    echo "Connection sucessfull<br>";
}
// Read line by line until end of file
while(!feof($f)) { 
    $query = fgets($f);
    if(mysqli_query($conn, $query)){
        print_r("INSERT: '$query' SUCCESSFULLY INSERTED<br>");
    }else{
        print_r("ERROR TABLE('$query'): ".mysqli_error($conn). "<br>");
    }
}
fclose($f);

?>
