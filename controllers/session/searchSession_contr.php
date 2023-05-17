<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/session_classes.php";

class SearchSessionContr {
    public function searchSessions($searchText, $filter) {
        $s = new Session();
        $_SESSION['sessions'] = $s->searchSessions($searchText, $filter);

        header("location: ../../views/sessionMgmt/searchSessions.php");
        exit();
    }
}

$searchText = $_POST['searchText'];
$filter = $_POST['filter'];

$sc = new SearchSessionContr();
$sc->searchSessions($searchText, $filter);