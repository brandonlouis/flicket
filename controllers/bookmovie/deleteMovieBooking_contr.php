<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movieBooking_classes.php";

class DeleteMovieBookingContr {
    public function deleteMovieBooking($id) {
        $mb = new MovieBooking();
        $booking = $mb->deleteMovieBooking($id);
        
        setcookie('flash_message', $booking[0], time() + 3, '/');
        setcookie('flash_message_type', $booking[1], time() + 3, '/');

        header("location: ../../views/movieBookingMgmt/manageMovieBooking.php");
        exit();
    }
}

$dmbc = new DeleteMovieBookingContr();
$dmbc->deleteMovieBooking($_GET['deleteId']);