<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movie_classes.php";

class ManageMovieContr {

    public function retrieveAllMovies() {
        $m = new Movie();
        return $m->retrieveAllMovies();
    }

    public function retrieveOneMovie($id) {
        $m = new Movie();
        return $m->retrieveOneMovie($id);
    }

    public function retrieveAllAvailableMovies() {
        $m = new Movie();
        return $m->retrieveAllAvailableMovies();
    }
    
    public function retrieveAllLanguages() {
        $m = new Movie();
        return $m->retrieveAllLanguages();
    }

    public function retrieveAllGenres() {
        $m = new Movie();
        return $m->retrieveAllGenres();
    }
}