<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/movieBooking_classes.php";

class ManageMovieBookingContr {

    public function retrieveAllMovieBookings($email) {
        $mb = new MovieBooking();
        return $mb->retrieveAllMovieBookings($email);
    }

    public function retrieveOneMovieBooking($id) {
        $mb = new MovieBooking();
        return $mb->retrieveOneMovieBooking($id);
    }
}