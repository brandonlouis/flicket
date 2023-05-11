<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movie_classes.php";

class SuspendMovieContr {
    public function suspendMovie($id) {
        $m = new Movie();
        $movie = $m->suspendMovie($id);

        setcookie('flash_message', $movie[0], time() + 3, '/');
        setcookie('flash_message_type', $movie[1], time() + 3, '/');

        header("location: ../../views/movieMgmt/manageMovies.php");
        exit();
    }
    public function activateMovie($id) {
        $m = new Movie();
        $movie = $m->activateMovie($id);

        setcookie('flash_message', $movie[0], time() + 3, '/');
        setcookie('flash_message_type', $movie[1], time() + 3, '/');

        header("location: ../../views/movieMgmt/manageMovies.php");
        exit();
    }
}

if (isset($_GET['suspendId'])) {
    $smc = new SuspendMovieContr();
    $smc->suspendMovie($_GET['suspendId']);

} else if (isset($_GET['activateId'])) {
    $smc = new SuspendMovieContr();
    $smc->activateMovie($_GET['activateId']);

}