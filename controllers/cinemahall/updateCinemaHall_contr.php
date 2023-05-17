<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemahall_classes.php";

class UpdateCinemaHallContr {
    public function updateCinemaHall($id, $hallNumber, $name, $address, $capacity) {
        $ch = new CinemaHall();
        $cinemahall = $ch->updateCinemaHall($id, $hallNumber, $name, $address, $capacity);

        setcookie('flash_message', $cinemahall[0], time() + 3, '/');
        setcookie('flash_message_type', $cinemahall[1], time() + 3, '/');

        header("location: ../../views/cinemaHallsMgmt/manageCinemaHalls.php");
        exit();
    }
}

$hallNumber = $_POST["hallNumber"];
$name = $_POST["name"];
$address = $_POST["address"];
$capacity = $_POST["capacity"];

$uch = new UpdateCinemaHallContr();
$uch->updateCinemaHall($_GET['movieId'], $hallNumber, $name, $address, $capacity);