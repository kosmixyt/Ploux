<?php
session_start();
if(!empty($_SESSION["id"]) && !empty($_SESSION["token"])){

	$filmsdir = json_decode(file_get_contents("config.json"))->filmsdir;

//upload.php


if(isset($_FILES['images']))
{
	for($count = 0; $count < count($_FILES['images']['name']); $count++)
	{
		$extension = pathinfo($_FILES['images']['name'][$count], PATHINFO_EXTENSION);



		move_uploaded_file($_FILES['images']['tmp_name'][$count], $filmsdir . $_GET["id"].".".$extension);
	}

	echo 'success';
}

}

?>