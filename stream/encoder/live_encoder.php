<?php
use Streaming\Representation;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;


error_reporting(E_ALL ^ E_NOTICE);  
session_start();
if(empty($_SESSION["id"])){
    echo "not logged";
    die;
}
require($_SERVER['DOCUMENT_ROOT']."/stream/vendor/autoload.php");
require($_SERVER["DOCUMENT_ROOT"]."/static/php/bdd.php");
$format = new Streaming\Format\X264();
$id_of_user = $_SESSION["id"];

function getName($l) {
  $characters = '0123456789';
  $randomString = '';

  for ($i = 0; $i < $l; $i++) {
      $index = rand(0, strlen($characters) - 1);
      $randomString .= $characters[$index];
  }

  return $randomString;
}

$proxy_id = $_GET["proxy_id"];
$config_json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/static/php/config.json"));
$base_film_dir= $config_json->filmsdir;
$proxy_stream = getName(9);
$_SESSION["temp_proxy_stream"] = $proxy_stream;

$sql = "SELECT * FROM media WHERE proxy_id='$proxy_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {}else{ echo "no media found"; die;}
  // output data of each row
$row = $result->fetch_assoc();
/*  Vérification de la base de données pour savoir si il n'existe pas déjà  */






$config = [
    'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
    'ffprobe.binaries' => '/usr/bin/ffprobe',
    'timeout'          => 86400, // The timeout for the underlying process
    'ffmpeg.threads'   => 12,   // The number of threads that FFmpeg should use
];


$ffmpeg = Streaming\FFMpeg::create($config);
$video = $ffmpeg->open("/plex/films/".$row["media_path"]);

if(isset($_GET["type"]) && $_GET["type"] == "multigen"){
$num = intval($_GET["num"]);

if($num == 3){

  // vérification
  $sql = "SELECT * FROM encoder WHERE proxy_id_of_media='$proxy_id' AND height=".$_GET["height1"]." OR weight=".$_GET["weight1"];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) { echo "un encodage de meme longueur / largeur existe déjà veuiller l'utiliser (Interdit d'avoir 2 encodage de meme longueur / largeur du meme média)"; die;} 
  
  $sql1 = "INSERT INTO encoder (proxy_id_of_media, id_of_user, type_encodage, apache_path_output_hls, proxy_stream, bitrate, height, weight) VALUES ('$proxy_id', $id_of_user, 'live', '/stream/encoder/$proxy_stream/stream_".$_GET["height1"]."p.m3u8', '$proxy_stream', ".$_GET["bitrate1"].", ".$_GET["height1"].", ".$_GET["weight1"].")";
  $sql2 = "INSERT INTO encoder (proxy_id_of_media, id_of_user, type_encodage, apache_path_output_hls, proxy_stream, bitrate, height, weight) VALUES ('$proxy_id', $id_of_user, 'live', '/stream/encoder/$proxy_stream/stream_".$_GET["height2"]."p.m3u8', '$proxy_stream', ".$_GET["bitrate2"].", ".$_GET["height2"].", ".$_GET["weight2"].")";
  $sql3 = "INSERT INTO encoder (proxy_id_of_media, id_of_user, type_encodage, apache_path_output_hls, proxy_stream, bitrate, height, weight) VALUES ('$proxy_id', $id_of_user, 'live', '/stream/encoder/$proxy_stream/stream_".$_GET["height3"]."p.m3u8', '$proxy_stream', ".$_GET["bitrate3"].", ".$_GET["height3"].", ".$_GET["weight3"].")";
  
  $conn->query($sql1);
  $conn->query($sql2);
  $conn->query($sql3);

  $re1 = (new Representation)->setKiloBitrate($_GET["bitrate1"])->setResize($_GET["weight1"], $_GET["height1"]);
  $re2 = (new Representation)->setKiloBitrate($_GET["bitrate2"])->setResize($_GET["weight2"], $_GET["height2"]);
  $re3 = (new Representation)->setKiloBitrate($_GET["bitrate3"])->setResize($_GET["weight3"], $_GET["height3"]);


  $format->on('progress', function ($video, $format, $percentage){
    $updateproxy_stream = $_SESSION["temp_proxy_stream"];
    echo $percentage." ".$updateproxy_stream."<br>";
    $sqlupdate = "UPDATE encoder SET percentage=$percentage WHERE proxy_stream='$updateproxy_stream'";
    $connu = new mysqli("195.154.174.181", "ploux", "I0u9ik?3", "kosmix_ploux");
    $connu->query($sqlupdate);
    $connu->close();
    
      });

      die;
      $video
      ->hls()
      ->setFormat($format)
      ->addRepresentations([$re1, $re2, $re3])
      ->save("/var/www/html/stream/encoder/".$proxy_stream."/stream.m3u8");


}else if($num == 2){
  $sql1 = "INSERT INTO encoder (proxy_id_of_media, id_of_user, type_encodage, apache_path_output_hls, proxy_stream, bitrate, height, weight) VALUES ('$proxy_id', $id_of_user, 'live', '/stream/encoder/$proxy_stream/stream_".$_GET["height1"]."p.m3u8', '$proxy_stream', ".$_GET["bitrate1"].", ".$_GET["height1"].", ".$_GET["weight1"].")";
  $sql2 = "INSERT INTO encoder (proxy_id_of_media, id_of_user, type_encodage, apache_path_output_hls, proxy_stream, bitrate, height, weight) VALUES ('$proxy_id', $id_of_user, 'live', '/stream/encoder/$proxy_stream/stream_".$_GET["height2"]."p.m3u8', '$proxy_stream', ".$_GET["bitrate2"].", ".$_GET["height2"].", ".$_GET["weight2"].")";

  
  $conn->query($sql1);
  $conn->query($sql2);



  $re1 = (new Representation)->setKiloBitrate($_GET["bitrate1"])->setResize($_GET["weight1"], $_GET["height1"]);
  $re2 = (new Representation)->setKiloBitrate($_GET["bitrate2"])->setResize($_GET["weight2"], $_GET["height2"]);


  $format->on('progress', function ($video, $format, $percentage){
    $updateproxy_stream = $_SESSION["temp_proxy_stream"];
    echo $percentage." ".$updateproxy_stream."<br>";
    $sqlupdate = "UPDATE encoder SET percentage=$percentage WHERE proxy_stream='$updateproxy_stream'";
    $connu = new mysqli("195.154.174.181", "ploux", "I0u9ik?3", "kosmix_ploux");
    $connu->query($sqlupdate);
    $connu->close();
    
      });


      $video
      ->hls()
      ->setFormat($format)
      ->addRepresentations([$re1, $re2])
      ->save("/var/www/html/stream/encoder/".$proxy_stream."/stream.m3u8");








}else if($num == 1){

  $sql = "SELECT * FROM encoder WHERE proxy_id_of_media=$proxy_id AND height=".$_GET["height1"]." OR weight=".$_GET["weight1"];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) { echo "un encodage de meme longueur / largeur existe déjà veuiller l'utiliser (Interdit d'avoir 2 encodage de meme longueur / largeur du meme média)"; die;} 

  $sql1 = "INSERT INTO encoder (proxy_id_of_media, id_of_user, type_encodage, apache_path_output_hls, proxy_stream, bitrate, height, weight) VALUES ($proxy_id, $id_of_user, 'live', '/stream/encoder/$proxy_stream/stream_".$_GET["height1"]."p.m3u8', '$proxy_stream', ".$_GET["bitrate1"].", ".$_GET["height1"].", ".$_GET["weight1"].")";
  $conn->query($sql1);


  $format->on('progress', function ($video, $format, $percentage){
$updateproxy_stream = $_SESSION["temp_proxy_stream"];
echo $percentage." ".$updateproxy_stream."<br>";
$sqlupdate = "UPDATE encoder SET percentage=$percentage WHERE proxy_stream='$updateproxy_stream'";
$connu = new mysqli("195.154.174.181", "ploux", "I0u9ik?3", "kosmix_ploux");
$connu->query($sqlupdate);
$connu->close();

  });



  $re1 = (new Representation)->setKiloBitrate(intval($_GET["bitrate1"]))->setResize(intval($_GET["weight1"]), intval($_GET["height1"]));

  $video
  ->hls()
  ->setFormat($format)
  ->addRepresentations([$re1])
  ->save("/var/www/html/stream/encoder/".$proxy_stream."/stream.m3u8");


}






} else if(isset($_GET["type"]) && $_GET["type"] == "onegen"){




$conn->query($sql);

$rep1 = (new Representation)->setKiloBitrate($_GET["bitrate"])->setResize($_GET["weight"], $_GET["height"]);





}



echo "good";

$conn->close();

















?>


