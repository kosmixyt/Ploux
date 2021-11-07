<?php
// page de details du media
$id = $_GET["proxy_id"];
require("bdd.php");
$sql = "SELECT * FROM media WHERE proxy_id='$id'";
$result = $conn->query($sql);
$config = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/static/php/config.json"));
if ($result->num_rows > 0) {  // output data of each row
$row = $result->fetch_assoc();
?>
<h1 class="media_name"  id="nameof" style="color: white; "><?php echo $row["name"]; ?></h1>
<br>

<img  style="width: 450px; height: 600px" src="/static/php/pngproxy.php?proxy_id=<?php echo $row["proxy_id"]; ?>">
<p id="desc">
<?php echo $row["description"]; ?>
</p> <button  id='trbutton'onClick="gettranslate()">Traduire</button>
<h5 class="par">Sortie : <?php echo $row["parution_date"];?></h5>
<h5 class="mt">Type de média : <?php echo $row["media_type"];?></h5>
<h5 class="tmurl"><a href='<?php echo $row["tmdburlifexist"];?>'>Voir plus</a></h5>
<a href="/static/php/filmsproxy.php?proxy_id=<?php echo $row["proxy_id"]?>">Télécharger</a><br>
<h5  class="stream" > Streamer


<?php require($_SERVER["DOCUMENT_ROOT"]."/stream/tostream_quality_selector.php");?>
 
</h5>


<button onClick="getstream()">Streamer ! </button></h5>
<?php 
}else{
    echo "0results";
}



?>