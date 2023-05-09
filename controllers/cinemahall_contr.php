<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemahall_classes.php";

class CinemaHallContr {

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
    
    public function retrieveAllLanguages() {
        $ch = new CinemaHall();
        return $ch->retrieveAllLanguages();
    }

    public function retrieveAllGenres() {
        $ch = new CinemaHall();
        return $ch->retrieveAllGenres();
    }

    public function createCinemaHall($hallNumber, $name, $address, $capacity, $status) {
        $ch = new CinemaHall();
        $cinemahall = $ch->createCinemaHall($hallNumber, $name, $address, $capacity, $status);
        
        setcookie('flash_message', $cinemahall[0], time() + 3, '/');
        setcookie('flash_message_type', $cinemahall[1], time() + 3, '/');

        if ($cinemahall[1] == 'danger') {
            header("location: ../views/cinemaHallsMgmt/createCinemaHall.php");
            exit();
        } else {
            header("location: ../views/cinemaHallsMgmt/manageCinemaHalls.php");
            exit();
        }
    }

    public function updateCinemaHall($id, $hallNumber, $name, $address, $capacity, $status) {
        $ch = new CinemaHall();
        $cinemahall = $ch->updateCinemaHall($id, $hallNumber, $name, $address, $capacity, $status);

        setcookie('flash_message', $cinemahall[0], time() + 3, '/');
        setcookie('flash_message_type', $cinemahall[1], time() + 3, '/');

        header("location: ../views/cinemaHallsMgmt/manageCinemaHalls.php");
        exit();
    }

    public function suspendCinemaHall($id) {
        $ch = new CinemaHall();
        $cinemahall = $ch->suspendCinemaHall($id);

        setcookie('flash_message', $cinemahall[0], time() + 3, '/');
        setcookie('flash_message_type', $cinemahall[1], time() + 3, '/');

        header("location: ../views/cinemaHallsMgmt/manageCinemaHalls.php");
        exit();
    }
    public function activateCinemaHall($id) {
        $ch = new CinemaHall();
        $cinemahall = $ch->activateCinemaHall($id);

        setcookie('flash_message', $cinemahall[0], time() + 3, '/');
        setcookie('flash_message_type', $cinemahall[1], time() + 3, '/');

        header("location: ../views/cinemaHallsMgmt/manageCinemaHalls.php");
        exit();
    }

    public function searchCinemaHalls($searchText, $filter) {
        $ch = new CinemaHall();
        $_SESSION['cinemaHalls'] = $ch->searchCinemaHalls($searchText, $filter);

        header("location: ../views/cinemaHallsMgmt/searchCinemaHalls.php");
        exit();
    }
}


if (isset($_GET['suspendId'])) {
    $chc = new CinemaHallContr();
    $chc->suspendCinemaHall($_GET['suspendId']);

} else if (isset($_GET['activateId'])) {
    $chc = new CinemaHallContr();
    $chc->activateCinemaHall($_GET['activateId']);

} else if (isset($_POST['createCinemaHall']) || isset($_POST['updateCinemaHall'])) {
    $hallNumber = $_POST["hallNumber"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $capacity = $_POST["capacity"];
    
    $chc = new CinemaHallContr();

    if (isset($_POST['createCinemaHall'])) {
        $status = $_POST["status"];
        $chc->createCinemaHall($hallNumber, $name, $address, $capacity, $status);
    } else if (isset($_POST['updateCinemaHall']) && isset($_GET['movieId'])) {
        $chc->updateCinemaHall($_GET['movieId'], $hallNumber, $name, $address, $capacity, $status);
    }
} else if (isset($_POST['filter'])) {
    $searchText = $_POST['searchText'];
    $filter = $_POST['filter'];
    
    $chc = new CinemaHallContr();
    $chc->searchCinemaHalls($searchText, $filter);
}