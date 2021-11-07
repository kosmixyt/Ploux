<?php
$filmsdir = json_decode(file_get_contents("config.json"))->filmsdir;
require("bdd.php");


$proxyfilmsid = $_GET["proxy_id"];
$sql = "SELECT * FROM media WHERE proxy_id='$proxyfilmsid'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

$file = $filmsdir . $row["media_path"];
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.$row["name"].".".pathinfo($row["media_path"], PATHINFO_EXTENSION).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);

    exit;



}else{
    echo "0 founds";
}


$conn->close();

?>