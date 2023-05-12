<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/fnbitem_classes.php";

class PurchaseFnBItemContr {
    public function purchaseFnBItem($fnbItemID, $fnbQty, $buyerName, $email) {
        $fnb = new FnBItem();
        $fnbitem = $fnb->purchaseFnBItem($fnbItemID, $fnbQty, $buyerName, $email);
        
        setcookie('flash_message', $fnbitem[0], time() + 3, '/');
        setcookie('flash_message_type', $fnbitem[1], time() + 3, '/');

        header("location: ../../views/foodDrinks.php");
        exit();
    }
}

$buyerName = $_POST['buyerName'];
$email = $_POST['email'];
$fnbItem = $_GET['fnbItemId'];
$fnbQty = $_POST['quantity'];

$fnbc = new PurchaseFnBItemContr();
$fnbc->purchaseFnBItem($fnbItem, $fnbQty, $buyerName, $email);