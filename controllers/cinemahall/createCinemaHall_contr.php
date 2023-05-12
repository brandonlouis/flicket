<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemahall_classes.php";

class CreateCinemaHallContr {
    public function createCinemaHall($hallNumber, $name, $address, $capacity, $status) {
        $ch = new CinemaHall();
        $cinemahall = $ch->createCinemaHall($hallNumber, $name, $address, $capacity, $status);
        
        setcookie('flash_message', $cinemahall[0], time() + 3, '/');
        setcookie('flash_message_type', $cinemahall[1], time() + 3, '/');

        if ($cinemahall[1] == 'danger') {
            header("location: ../../views/cinemaHallsMgmt/createCinemaHall.php");
            exit();
        } else {
            header("location: ../../views/cinemaHallsMgmt/manageCinemaHalls.php");
            exit();
        }
    }
}

$hallNumber = $_POST["hallNumber"];
$name = $_POST["name"];
$address = $_POST["address"];
$capacity = $_POST["capacity"];

$cch = new CreateCinemaHallContr();
$status = $_POST["status"];
$cch->createCinemaHall($hallNumber, $name, $address, $capacity, $status);