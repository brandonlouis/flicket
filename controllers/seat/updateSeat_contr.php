<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/seat_classes.php";

class UpdateSeatContr {
    public function updateSeat($hallId, $selectedSeats, $seatStatus) {
        $s = new Seat();
        $seat = $s->updateSeat($hallId,  $selectedSeats, $seatStatus);

        setcookie('flash_message', $seat[0], time() + 3, '/');
        setcookie('flash_message_type', $seat[1], time() + 3, '/');

        header("location: ../../views/seat/updateSeats.php?hallId=" . $hallId);
        exit();
    }
}

$nameHallNumber = explode(", Hall ", $_POST['nameHallNumber']);

$selectedSeats = explode(", ", $_POST['seatLocation']);
$seatStatus = $_POST['seatStatus'];

$sc = new UpdateSeatContr();
$sc->updateSeat($_GET['hallId'], $selectedSeats, $seatStatus);