<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movie_classes.php";

class UpdateMovieContr {
    public function updateMovie($id, $title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster) {
        $m = new Movie();
        $movie = $m->updateMovie($id, $title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster);

        setcookie('flash_message', $movie[0], time() + 3, '/');
        setcookie('flash_message_type', $movie[1], time() + 3, '/');

        header("location: ../../views/movieMgmt/manageMovies.php");
        exit();
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

$umc = new UpdateMovieContr();
$umc->updateMovie($_GET['movieId'], $title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster);