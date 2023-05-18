<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movieBooking_classes.php";

class CreateMovieBookingContr {
    public function createMovieBooking($hallId, $sessionId, $ticketType, $seatLocation) {
        $movie = new MovieBooking();
        $movieBooking = $movie->createMovieBooking($hallId, $sessionId, $ticketType, $seatLocation);
        
        setcookie('flash_message', $movieBooking[0], time() + 3, '/');
        setcookie('flash_message_type', $movieBooking[1], time() + 3, '/');

        header("location: ../../views/movies.php");
        exit();
    }
}

$hallId = $_GET['hallId'];
$sessionId = $_GET['sessionId'];
$ticketType = explode('|', $_POST['ticketType'])[0];
$seatLocation = explode(', ', $_POST['seatLocation']);

$bmc = new CreateMovieBookingContr();
$bmc->createMovieBooking($hallId, $sessionId, $ticketType, $seatLocation);