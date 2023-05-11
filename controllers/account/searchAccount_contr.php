<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/account_classes.php";

class SearchAccountContr {
    public function searchAccounts($searchText, $filter) {
        $a = new Account();
        $_SESSION['accounts'] = $a->searchAccounts($searchText, $filter);

        header("location: ../../views/account/searchAccounts.php");
        exit();
    }
}

$searchText = $_POST['searchText'];
$filter = $_POST['filter'];

$sac = new SearchAccountContr();
$sac->searchAccounts($searchText, $filter);