<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/seat_classes.php";

class SeatContr {

    // TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TO MOVE TO CINEMAHALL
    public function retrieveAllHalls() {
        $s = new Seat();
        return $s->retrieveAllHalls();
    }

    public function retrieveOneHall($id) {
        $s = new Seat();
        return $s->retrieveOneHall($id);
    }
    // TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TEMPORARY TO MOVE TO CINEMAHALL

    public function retrieveAllSeats($id) {
        $s = new Seat();
        return $s->retrieveAllSeats($id);
    }

    public function retrieveOneSeat($id) {
        $s = new Seat();
        return $s->retrieveOneSeat($id);
    }

    public function createSeat($hallId, $seatData, $status) {
        $s = new Seat();
        $seat = $s->createSeat($hallId, $seatData, $status);

        setcookie('flash_message', $seat[0], time() + 3, '/');
        setcookie('flash_message_type', $seat[1], time() + 3, '/');

        if ($seat[1] == 'danger') {
            header("location: ../views/seat/createSeats.php?hallId=" . $hallId);
            exit();
        } else {
            header("location: ../views/seat/manageSeats.php");
            exit();
        }
    }

    public function updateSeat($hallId, $selectedSeats, $seatStatus) {
        $s = new Seat();
        $seat = $s->updateSeat($hallId,  $selectedSeats, $seatStatus);

        setcookie('flash_message', $seat[0], time() + 3, '/');
        setcookie('flash_message_type', $seat[1], time() + 3, '/');

        header("location: ../views/seat/updateSeats.php?hallId=" . $hallId);
        exit();
    }

    public function suspendSeat($id) {
        $s = new Seat();
        $seat = $s->suspendSeat($id);

        setcookie('flash_message', $seat[0], time() + 3, '/');
        setcookie('flash_message_type', $seat[1], time() + 3, '/');

        header("location: ../views/seat/manageSeats.php");
        exit();
    }
    public function activateSeat($id) {
        $s = new Seat();
        $seat = $s->activateSeat($id);

        setcookie('flash_message', $seat[0], time() + 3, '/');
        setcookie('flash_message_type', $seat[1], time() + 3, '/');

        header("location: ../views/seat/manageSeats.php");
        exit();
    }

    public function searchSeats($searchText, $filter) {
        $s = new Seat();
        $_SESSION['seats'] = $s->searchSeats($searchText, $filter);

        header("location: ../views/seat/searchSeats.php");
        exit();
    }
}


if (isset($_GET['suspendId'])) {
    $sc = new SeatContr();
    $sc->suspendSeat($_GET['suspendId']);

} else if (isset($_GET['activateId'])) {
    $sc = new SeatContr();
    $sc->activateSeat($_GET['activateId']);

} else if (isset($_POST['createSeats']) && isset($_GET['hallId'])) {
    $nameHallNumber = explode(", Hall ", $_POST['nameHallNumber']);

    $cinemaName = $nameHallNumber[0];
    $hallNumber = $nameHallNumber[1];
    $seatData = json_decode($_POST['seatData'], true);
    $status = $_POST['status'];

    $sc = new SeatContr();
    $sc->createSeat($_GET['hallId'], $seatData, $status);
    
} else if (isset($_POST['updateSeat']) && isset($_GET['hallId'])) {
    $selectedSeats = explode(", ", $_POST['seatLocation']);
    $seatStatus = $_POST['seatStatus'];

    $sc = new SeatContr();
    $sc->updateSeat($_GET['hallId'], $selectedSeats, $seatStatus);

} else if (isset($_POST['filter']) || isset($_GET['search'])) {
    $searchText = $_POST['searchText'];
    $filter = isset($_POST['filter']) ? $_POST['filter'] : "None";
    
    $sc = new SeatContr();
    $sc->searchSeats($searchText, $filter);
}