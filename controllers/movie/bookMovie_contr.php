<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movie_classes.php";

class BookMovieContr {
    public function bookMovie($fullName, $email, $movieId, $sessionId, $movieQty) {
        $movie = new Movie();
        $movieBooking = $movie->bookMovie($fullName, $email, $movieId, $sessionId, $movieQty);
        
        setcookie('flash_message', $movieBooking[0], time() + 3, '/');
        setcookie('flash_message_type', $movieBooking[1], time() + 3, '/');

        header("location: ../../views/movies.php");
        exit();
    }
}

$fullName = $_POST['fullName'];
$email = $_POST['email'];
$movieId = $_GET['movieId'];
$sessionId = $_POST['sessionId'];
$movieQty = $_POST['quantity'];

$bmc = new BookMovieContr();
$bmc->bookMovie($fullName, $email, $movieId, $sessionId, $movieQty);