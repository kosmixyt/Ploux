#EXTM3U
<?php
$proxy_media_id = $_GET["proxy_media_id"];
require($_SERVER["DOCUMENT_ROOT"]."/static/php/bdd.php");
$sql = "SELECT * FROM encoder WHERE proxy_id_of_media='$proxy_media_id' ORDER BY weight";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row

?>
#EXT-X-VERSION:3<?php 
  
  while($row = $result->fetch_assoc()) {
    
          
?>

#EXT-X-STREAM-INF:RESOLUTION=<?php echo $row["weight"] ?>x<?php echo $row["height"]; ?>,NAME="<?php echo $row["height"]; ?>"
<?php echo "/stream/encoder/".$row["proxy_stream"]."/";?>stream_<?php echo $row["height"];?>p.m3u8<?php 
    
  }
} else {
  echo "0 results";
}
$conn->close();

header('Content-Type:text/plain; charset=UTF-8');


?>