<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/fnbitem_classes.php";

class SearchFnBItemContr {
    public function searchFnBItems($searchText, $filter) {
        $fnb = new FnBItem();
        $_SESSION['fnbItems'] = $fnb->searchFnBItems($searchText, $filter);
        echo $_SESSION['fnbItems'];
        header("location: ../../views/fnbItemMgmt/searchFnBItems.php");
        exit();
    }
}

$searchText = $_POST['searchText'];
$filter = $_POST['filter'];

$fnbc = new SearchFnBItemContr();
$fnbc->searchFnBItems($searchText, $filter);