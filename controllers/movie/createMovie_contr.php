<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movie_classes.php";

class CreateMovieContr {
    public function createMovie($title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster, $status) {
        $m = new Movie();
        $movie = $m->createMovie($title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster, $status);
        
        setcookie('flash_message', $movie[0], time() + 3, '/');
        setcookie('flash_message_type', $movie[1], time() + 3, '/');

        if ($movie[1] == 'danger') {
            header("location: ../../views/movieMgmt/createMovie.php");
            exit();
        } else {
            header("location: ../../views/movieMgmt/manageMovies.php");
            exit();
        }
    }
}

$title = $_POST["title"];
$synopsis = $_POST["synopsis"];
$runtimeMin = $_POST["runtimeMin"];
$trailerURL = $_POST["trailerURL"];
$startDate = $_POST["startDate"];
$endDate = $_POST["endDate"];
$language = $_POST["language"];
$genre = explode(", ", $_POST["genre"]);
$poster = null;
if (isset($_FILES["posterFile"]) && $_FILES["posterFile"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $posterContents = file_get_contents($_FILES["posterFile"]["tmp_name"]);
    $poster = base64_encode($posterContents);
}

$cmc = new CreateMovieContr();
$status = $_POST["status"];
$cmc->createMovie($title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster, $status);