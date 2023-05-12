<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/seat_classes.php";

class SearchSeatContr {
    public function searchSeats($searchText, $filter) {
        $s = new Seat();
        $_SESSION['seats'] = $s->searchSeats($searchText, $filter);

        header("location: ../../views/seat/searchSeats.php");
        exit();
    }
}

$searchText = $_POST['searchText'];
$filter = isset($_POST['filter']) ? $_POST['filter'] : "None";

$sc = new SearchSeatContr();
$sc->searchSeats($searchText, $filter);