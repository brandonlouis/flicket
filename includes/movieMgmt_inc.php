<?php

include "../classes/dbh_classes.php";
include "../controllers/movie_contr.php";
include "../classes/movie_classes.php";

if (isset($_GET['deleteId'])) {
    $mc = new MovieContr();
    $mc->deleteMovie($_GET['deleteId']);

} else if (isset($_POST['createMovieSession']) || isset($_POST['updateMovieSession'])) {
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
    
    $mc = new MovieContr();

    if (isset($_POST['createMovieSession'])) {
        $mc->createMovie($title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster);
    } else if (isset($_POST['updateMovieSession']) && isset($_GET['movieId'])) {
        $mc->updateMovie($_GET['movieId'], $title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster);
    }
} else if (isset($_POST['filter'])) {
    $searchText = $_POST['searchText'];
    $filter = $_POST['filter'];
    
    $mc = new MovieContr();
    $mc->searchMovies($searchText, $filter);
}