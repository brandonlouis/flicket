<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movie_classes.php";

class MovieContr {

    public function retrieveAllMovies() {
        $m = new Movie();
        return $m->retrieveAllMovies();
    }

    public function retrieveOneMovie($id) {
        $m = new Movie();
        return $m->retrieveOneMovie($id);
    }
    
    public function retrieveAllLanguages() {
        $m = new Movie();
        return $m->retrieveAllLanguages();
    }

    public function retrieveAllGenres() {
        $m = new Movie();
        return $m->retrieveAllGenres();
    }

    public function createMovie($title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster) {
        $m = new Movie();
        $movie = $m->createMovie($title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster);
        
        setcookie('flash_message', $movie[0], time() + 3, '/');
        setcookie('flash_message_type', $movie[1], time() + 3, '/');

        header("location: ../views/movieMgmt/manageMovies.php");
        exit();
    }

    public function updateMovie($id, $title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster) {
        $m = new Movie();
        $movie = $m->updateMovie($id, $title, $synopsis, $runtimeMin, $trailerURL, $startDate, $endDate, $language, $genre, $poster);

        setcookie('flash_message', $movie[0], time() + 3, '/');
        setcookie('flash_message_type', $movie[1], time() + 3, '/');

        header("location: ../views/movieMgmt/manageMovies.php");
        exit();
    }

    public function deleteMovie($id) {
        $m = new Movie();
        $movie = $m->deleteMovie($id);

        setcookie('flash_message', $movie[0], time() + 3, '/');
        setcookie('flash_message_type', $movie[1], time() + 3, '/');

        header("location: ../views/movieMgmt/manageMovies.php");
        exit();
    }

    public function searchMovies($searchText, $filter) {
        $m = new Movie();
        $_SESSION['movies'] = $m->searchMovies($searchText, $filter);

        header("location: ../views/movieMgmt/searchMovies.php");
        exit();
    }
}