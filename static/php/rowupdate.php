<?php

session_start();
$id = $_SESSION["id"];
$token = $_SESSION["token"];



$sql = "SELECT * FROM users WHERE uuid='$token' AND id=$id";
require("bdd.php");

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$conn->close();
if(password_verify($_GET["password"], $row["password"])){

    


$newmail = $_GET["mail"];
$newname = $_GET["name"];
$newlastname = $_GET["lastname"];

$sql = "UPDATE users SET email='$newmail', name='$newname', lastname='$newlastname' WHERE id=$id AND uuid='$token'";
require("bdd.php");
if ($conn->query($sql) === TRUE) {
    echo '{"status":"success"}';


}
}else{

    echo '{"status":"error invalid password"}';
}





$conn->close();









?>
