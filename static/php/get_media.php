<?php

$response = json_decode(file_get_contents("https://api.themoviedb.org/3/movie/".$id."?api_key=".$api_key."&language=en-US"));
$response_video = json_decode(file_get_contents("https://api.themoviedb.org/3/movie/".$id."/videos?api_key=".$api_key."&language=en-US"));
$response_date = json_decode(file_get_contents("https://api.themoviedb.org/3/movie/".$id."/release_dates?api_key=".$api_key));
$media_minia = "https://image.tmdb.org/t/p/w500".$response->poster_path;
$media_title = $response->original_title;
$media_description = $response->overview;
$media_tag = $response->genres;
$media_lang = $response->original_language;
$media_date = $response_date->results[0]->release_dates[0]->release_date;
$media_budget = $response->budget;
$media_tmdb_url = "https://www.themoviedb.org/movie/".$response->id;
$count = 0;
$find = false;
while(isset($response_video->results[$count]->site) && $find == false){if($response_video->results[$count]->site == "YouTube"){$find = true;$media_trailer_url = "https://www.youtube.com/watch?v=".$response_video->results[$count]->key;}$count = $count + 1;}








?>