<?php

session_start();

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/fnbitem_classes.php";

class PurchaseFnBItemContr {
    public function purchaseFnBItem($fnbItemID, $fnbQty, $accountId) {
        $fnb = new FnBItem();
        $fnbitem = $fnb->purchaseFnBItem($fnbItemID, $fnbQty, $accountId);
        
        setcookie('flash_message', $fnbitem[0], time() + 3, '/');
        setcookie('flash_message_type', $fnbitem[1], time() + 3, '/');

        header("location: ../../views/foodDrinks.php");
        exit();
    }
}

$fnbItemID = $_GET['fnbItemId'];
$fnbQty = $_POST['hiddenQuantity'];
$accountId = $_SESSION['id'];

$fnbc = new PurchaseFnBItemContr();
$fnbc->purchaseFnBItem($fnbItemID, $fnbQty, $accountId);