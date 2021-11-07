<?php

$servername = "195.154.174.181";
$username = "ploux";
$password = "I0u9ik?3";
$dbname = "kosmix_ploux";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);}



  
?>

