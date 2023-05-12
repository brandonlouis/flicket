<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemahall_classes.php";

class SearchCinemaHallContr {
    public function searchCinemaHalls($searchText, $filter) {
        $ch = new CinemaHall();
        $_SESSION['cinemaHalls'] = $ch->searchCinemaHalls($searchText, $filter);

        header("location: ../../views/cinemaHallsMgmt/searchCinemaHalls.php");
        exit();
    }
}

$searchText = $_POST['searchText'];
$filter = $_POST['filter'];

$sch = new SearchCinemaHallContr();
$sch->searchCinemaHalls($searchText, $filter);