<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/seat_classes.php";

class CreateSeatContr {
    public function createSeat($hallId, $seatData, $status) {
        $s = new Seat();
        $seat = $s->createSeat($hallId, $seatData, $status);

        setcookie('flash_message', $seat[0], time() + 3, '/');
        setcookie('flash_message_type', $seat[1], time() + 3, '/');

        if ($seat[1] == 'danger') {
            header("location: ../../views/seat/createSeats.php?hallId=" . $hallId);
            exit();
        } else {
            header("location: ../../views/seat/manageSeats.php");
            exit();
        }
    }
}

$seatData = json_decode($_POST['seatData'], true);
$status = $_POST['status'];

$sc = new CreateSeatContr();
$sc->createSeat($_GET['hallId'], $seatData, $status);