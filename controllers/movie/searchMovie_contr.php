<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movie_classes.php";

class SearchMovieContr {
    public function searchMovies($searchText, $filter) {
        $m = new Movie();
        $_SESSION['movies'] = $m->searchMovies($searchText, $filter);

        header("location: ../../views/movieMgmt/searchMovies.php");
        exit();
    }
}

$searchText = $_POST['searchText'];
$filter = $_POST['filter'];

$smc = new SearchMovieContr();
$smc->searchMovies($searchText, $filter);