<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/seat_classes.php";

class ManageSeatContr {
    public function retrieveAllSeats($id) {
        $s = new Seat();
        return $s->retrieveAllSeats($id);
    }

    public function retrieveOneSeat($id) {
        $s = new Seat();
        return $s->retrieveOneSeat($id);
    }
}