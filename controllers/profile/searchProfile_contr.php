<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/profile_classes.php";

class SearchProfileContr {
    public function searchProfiles($searchText, $filter) {
        $p = new Profile();
        $_SESSION['profiles'] = $p->searchProfiles($searchText, $filter);

        header("location: ../../views/profile/searchProfiles.php");
        exit();
    }
}

$searchText = $_POST['searchText'];
$filter = $_POST['filter'];

$spc = new SearchProfileContr();
$spc->searchProfiles($searchText, $filter);