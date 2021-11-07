<?php
session_start();
if(!empty($_SESSION["id"]) && !empty($_SESSION["token"])){
$api_key = "51357bd7d6ecb359fc0eb90e574080a2";
$id = strstr(substr(strstr($_GET["tmdb"], "/movie/"), 7), '-', true);
require("get_media.php");
function getName($l) {
    $characters = '0123456789';
    $randomString = '';
  
    for ($i = 0; $i < $l; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}

// downloading minia 
$proxy_id = getName(5);
$base_image_dir = json_decode(file_get_contents("config.json"))->miniadir;
file_put_contents($base_image_dir.$proxy_id.".png", file_get_contents($media_minia));
$file_name = $_GET["file_name"];

if($_GET["type"] == "tmdb")
{
require("bdd.php");
$media_path = $_GET["file_name"];
$name = $media_title;
$parution_date = $media_date; 
$id = $_SESSION["id"];
$description = $media_description;
$description = str_replace("'", "\'", $description);
$name = str_replace("'", "\'", $name);

$media_type = 'film';
$count = 0;
$tmdb_url = $media_tmdb_url;
$miniature_path = $base_image_dir.$proxy_id.".png";

$tag = "";while(isset($media_tag[$count])){$tag = $tag."#".$media_tag[$count]->name;$count = $count + 1;}




$sql = "INSERT INTO media (name, parution_date, byusersid, description, media_type, media_path, tag, tmdburlifexist, proxy_id, miniature_path)
VALUES ('$name', '$parution_date', $id, '$description', '$media_type',  '$media_path', '$tag', '$tmdb_url',  '$proxy_id', '$miniature_path')";

if ($conn->query($sql) === TRUE) {
  echo '{"statut":"success"}';
} else {
  echo  $sql;
}









}



















}




?>






