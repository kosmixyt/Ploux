<?php
$base_image_dir = json_decode(file_get_contents("config.json"))->miniadir;

$proxypngid = $_GET["proxy_id"];
header ('Content-Type: image/png');
readfile($base_image_dir . $proxypngid . ".png");







?>