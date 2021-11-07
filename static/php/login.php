<?php 
session_start();
if(empty($_GET["type"])){

?>

<h2>Connection</h4>
<p>Username : <br><input type="text" id="usrnm" name="username"><br>Password : <br><input id="pwd" type="password" name="password">
<br>
<button onClick="submit_login()" >Soumettre</button></p>


<?php
}else if($_GET["type"] == "login"){


require("bdd.php");





$username = $_GET["username"];
$pasword = $_GET["pwd"];
$sql = "SELECT * FROM users WHERE  username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
if(password_verify($pasword, $row["password"])){
    $_SESSION["token"] = $row["uuid"];
    $_SESSION["id"] = $row["id"];
    $_SESSION["user_type"] = $row["type_user"];
    echo '{"success":"logged"}';

}




  }

$conn->close();





} else if ($_GET["type"] == "logout"){

    session_unset();
}


?>