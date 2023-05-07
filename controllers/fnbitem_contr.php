<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/fnbitem_classes.php";

class FnBItemContr {

    public function retrieveAllFnBitems() {
        $fnb = new FnBItem();
        return $fnb->retrieveAllFnBitems();
    }

    public function retrieveOneFnBItem($id) {
        $fnb = new FnBItem();
        return $fnb->retrieveOneFnBItem($id);
    }

    public function createFnBItem($itemName, $description, $price, $category, $suspendStatus, $image) {
        $fnb = new FnBItem();
        $fnbitem = $fnb->createFnBItem($itemName, $description, $price, $category, $suspendStatus, $image);
        
        setcookie('flash_message', $fnbitem[0], time() + 3, '/');
        setcookie('flash_message_type', $fnbitem[1], time() + 3, '/');

        header("location: ../views/fnbItemMgmt/manageFnBItems.php");
        exit();
    }

    public function updateFnBItem($id, $itemName, $description, $price, $category, $suspendStatus, $image) {
        $fnb = new FnBItem();
        $fnbItem = $fnb->updateFnBItem($id, $itemName, $description, $price, $category, $suspendStatus, $image);

        setcookie('flash_message', $fnbItem[0], time() + 3, '/');
        setcookie('flash_message_type', $fnbItem[1], time() + 3, '/');

        header("location: ../views/fnbItemMgmt/manageFnBItems.php");
        exit();
    }

    public function deleteFnBItem($id) {
        $fnb = new FnBItem();
        $fnbItem = $fnb->deleteFnBItem($id);

        setcookie('flash_message', $fnbItem[0], time() + 3, '/');
        setcookie('flash_message_type', $fnbItem[1], time() + 3, '/');

        header("location: ../views/fnbItemMgmt/manageFnBItems.php");
        exit();
    }

    public function searchFnBItems($searchText, $filter) {

        $fnb = new FnBItem();
        $_SESSION['fnbItems'] = $fnb->searchFnBItems($searchText, $filter);
        header("location: ../views/fnbItemMgmt/searchFnBItems.php");
        exit();
    }

    public function checkFnBitemInDeal($id) {
        $fnb = new FnBItem();
        return $fnb->checkFnBitemInDeal($id);
    }

    public function getFnBItemDeals($id) {
        $fnb = new FnBItem();
        return $fnb->getFnBItemDeals($id);
    }
}

if (isset($_GET['deleteId'])) {
    $fnbc = new FnBItemContr();
    $fnbc->deleteFnBItem($_GET['deleteId']);

} else if (isset($_POST['createFnBItem']) || isset($_POST['updateFnBItem'])) {
    $itemName = $_POST["itemName"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $suspendStatus = $_POST["suspendStatus"];
    $image = null;
    if (isset($_FILES["imgFile"]) && $_FILES["imgFile"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $imageContents = file_get_contents($_FILES["imgFile"]["tmp_name"]);
        $image = base64_encode($imageContents);
    }
    
    $fnbc = new FnBItemContr();

    if (isset($_POST['createFnBItem'])) {
        $fnbc->createFnBItem($itemName, $description, $price, $category, $suspendStatus, $image);
    } else if (isset($_POST['updateFnBItem']) && isset($_GET['fnbItemId'])) {
        $fnbc->updateFnBItem($_GET['fnbItemId'], $itemName, $description, $price, $category, $suspendStatus, $image);
    }
} else if (isset($_POST['filter'])) {
    $searchText = $_POST['searchText'];
    $filter = $_POST['filter'];

    if ($filter == 'suspendStatus'){
        if(preg_match('/not suspended/i',$searchText) == 1){
            $searchText = 0;
        } else if(preg_match('/suspended/i',$searchText) == 1) {
            $searchText = 1;
        }
    }

    $fnbc = new FnBItemContr();
    $fnbc->searchFnBItems($searchText, $filter);
} 