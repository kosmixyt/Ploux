<?php
session_start();
require("token_verif.php");

if($logged == false){
    echo '{"status":"error", "errors":"notconnected"}';
    die;
}

$uuid = $_SESSION["token"];
$id = $_SESSION["id"];

$sql = "SELECT * FROM users WHERE uuid='$uuid' AND id=$id";
require("bdd.php");
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>


<h1>Salut <?php echo $row["username"]?> !</h1>
<br>
<p>Bonjour <?php echo $row["username"]?> vous etes <?php echo $row["type_user"]?> 


Voici vos informations  : </p>
<br>
<p>Votre email : <input type="text" id="email_edit"  value="<?php echo $row["email"]?>" name="email"></p>
<p>Nom : <input type="text" size="8" id="name_edit"  value="<?php echo $row["name"]?>" name="name"></p>
<p>Nom de famille : <input type="text" size="8" id="lastname_edit" value="<?php echo $row["lastname"]?>" name="lastname"></p>
<br>

<p>Confirmer votre mots de passe : <input type="password" id="password_edit" ></p>
<br><button onclick="if(document.getElementById('password_edit').value !== ''){  edit_credential(); Swal.fire('Good job!','Credential edited !', 'success');  }else{ Swal.fire({icon: 'error',title: 'Oops...',text: 'You must confirm your password !',})}">Editer</button>



















<br>
<button onClick="logout()">Se déconnecter</button>

<p>Votre ip <?php echo $_SERVER["REMOTE_ADDR"]; ?></p>
<?php 
$conn->close();
?>