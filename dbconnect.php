<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fooddelivery";

$conn = new mysqli($servername,$username,$password);

if($conn->connect_error){
    die("Connection Error".$conn->connect_error);
}else{
    mysqli_select_db($conn, $database);
}
?>