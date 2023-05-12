<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemahall_classes.php";

class ManageCinemaHallContr {

    public function retrieveAllCinemaHalls() {
        $ch = new CinemaHall();
        return $ch->retrieveAllCinemaHalls();
    }

    public function retrieveOneCinemaHall($id) {
        $ch = new CinemaHall();
        return $ch->retrieveOneCinemaHall($id);
    }

    public function retrieveAllAvailableCinemaHalls() {
        $ch = new CinemaHall();
        return $ch->retrieveAllAvailableCinemaHalls();
    }
}