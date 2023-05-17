<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketType_classes.php";

class SearchTicketTypeContr {
    public function searchTicketTypes($searchText, $filter) {
        $tt = new TicketType();
        $_SESSION['ticketTypes'] = $tt->searchTicketTypes($searchText, $filter);

        header("location: ../../views/ticketType/searchTicketTypes.php");
        exit();
    }
}

$searchText = $_POST['searchText'];
$filter = $_POST['filter'];

$ttc = new SearchTicketTypeContr();
$ttc->searchTicketTypes($searchText, $filter);