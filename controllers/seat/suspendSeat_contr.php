<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/seat_classes.php";

class SuspendSeatContr {
    public function suspendSeat($id) {
        $s = new Seat();
        $seat = $s->suspendSeat($id);

        setcookie('flash_message', $seat[0], time() + 3, '/');
        setcookie('flash_message_type', $seat[1], time() + 3, '/');

        header("location: ../../views/seat/manageSeats.php");
        exit();
    }
    public function activateSeat($id) {
        $s = new Seat();
        $seat = $s->activateSeat($id);

        setcookie('flash_message', $seat[0], time() + 3, '/');
        setcookie('flash_message_type', $seat[1], time() + 3, '/');

        header("location: ../../views/seat/manageSeats.php");
        exit();
    }
}

if (isset($_GET['suspendId'])) {
    $sc = new SuspendSeatContr();
    $sc->suspendSeat($_GET['suspendId']);

} else if (isset($_GET['activateId'])) {
    $sc = new SuspendSeatContr();
    $sc->activateSeat($_GET['activateId']);

}