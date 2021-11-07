<?php
require("bdd.php");

if(isset($_SESSION["token"]) && isset($_SESSION["id"])){
$token = $_SESSION["token"];
$id = $_SESSION["id"];
$sql = "SELECT * FROM users WHERE uuid='$token' AND id=$id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $logged = true;

} else {
  session_unset();
  $logged = false;
}
$conn->close();
}else{
$logged = false;
}








?>