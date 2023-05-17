<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemahall_classes.php";

class SuspendCinemaHallContr {
    public function suspendCinemaHall($id) {
        $ch = new CinemaHall();
        $cinemahall = $ch->suspendCinemaHall($id);

        setcookie('flash_message', $cinemahall[0], time() + 3, '/');
        setcookie('flash_message_type', $cinemahall[1], time() + 3, '/');

        header("location: ../../views/cinemaHallsMgmt/manageCinemaHalls.php");
        exit();
    }
    public function activateCinemaHall($id) {
        $ch = new CinemaHall();
        $cinemahall = $ch->activateCinemaHall($id);

        setcookie('flash_message', $cinemahall[0], time() + 3, '/');
        setcookie('flash_message_type', $cinemahall[1], time() + 3, '/');

        header("location: ../../views/cinemaHallsMgmt/manageCinemaHalls.php");
        exit();
    }
}

if (isset($_GET['suspendId'])) {
    $sch = new SuspendCinemaHallContr();
    $sch->suspendCinemaHall($_GET['suspendId']);

} else if (isset($_GET['activateId'])) {
    $ach = new SuspendCinemaHallContr();
    $ach->activateCinemaHall($_GET['activateId']);

}