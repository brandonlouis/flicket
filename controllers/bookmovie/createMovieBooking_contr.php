<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movieBooking_classes.php";

class CreateMovieBookingContr {
    public function createMovieBooking($sessionId, $ticketType) {
        $movie = new MovieBooking();
        $movieBooking = $movie->createMovieBooking($sessionId, $ticketType);
        
        setcookie('flash_message', $movieBooking[0], time() + 3, '/');
        setcookie('flash_message_type', $movieBooking[1], time() + 3, '/');

        header("location: ../../views/movies.php");
        exit();
    }
}

$sessionId = $_POST['sessionId'];
$ticketType = $_POST['ticketType'];

$bmc = new CreateMovieBookingContr();
$bmc->createMovieBooking($sessionId, $ticketType);