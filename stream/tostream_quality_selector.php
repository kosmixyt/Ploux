<select name="pets" id="default_str">
<?php
require($_SERVER["DOCUMENT_ROOT"]."/static/php/bdd.php");

$sql = "SELECT * FROM encoder WHERE proxy_id_of_media='$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
$default = "Réutiliser le(s) encodage(s) existant(s) (";
$pre = "";
while($row = $result->fetch_assoc()) {$default = $default.", ".$row["height"]; $pre = $pre."_".$row["height"];}

$default = str_replace("(,", "(", $default.")");
$default_value = "already_encoded";
$noal = false;

}else{
$default = "Live encoder 720p, 144p 5k bitrates";
$default_value = "live_encoder_720_144_5000";
$noal = true;
}
if($noal == true){

$les = '
<option value="live144">Live encoder 144p</option>
<option value="live240">Live encoder 240p</option>
<option value="live360">Live encoder 360p</option>
<option value="live480">Live encoder 480p</option>
<option value="live720">Live encoder 720p</option>
<option value="live1080">Live encoder 1080p</option>
<option value="live1080with720">Live encoder High quality 1080p,720p</option>
<option value="live720with480">Live encoder Medium quality 720p,480p</option>
<option value="live240with360with144">Live encoder low quality 240p,360p and 144p</option>
<option value="live1080with480with240">Live encoder Mitigated quality 1080p, 480p and 240p</option>
';
 
}else{



    
}







?>

<option value="<?php $default_value; ?>"><?php echo $default; ?></option>
<option value="custom">Live encoder custom Resolution</option>

<?php echo $les; ?>



</select>