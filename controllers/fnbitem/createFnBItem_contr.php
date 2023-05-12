<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/fnbitem_classes.php";

class CreateFnBItemContr {
    public function createFnBItem($itemName, $description, $price, $category, $status, $image) {
        $fnb = new FnBItem();
        $fnbitem = $fnb->createFnBItem($itemName, $description, $price, $category, $status, $image);
        
        setcookie('flash_message', $fnbitem[0], time() + 3, '/');
        setcookie('flash_message_type', $fnbitem[1], time() + 3, '/');

        if ($fnbitem[1] == "danger") {
            header("location: ../../views/fnbItemMgmt/createFnBItem.php");
            exit();
        } else {
            header("location: ../../views/fnbItemMgmt/manageFnBItems.php");
            exit();
        }
    }
}

$itemName = $_POST["itemName"];
$description = $_POST["description"];
$price = $_POST["price"];
$category = $_POST["category"];
$image = null;
if (isset($_FILES["imgFile"]) && $_FILES["imgFile"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $imageContents = file_get_contents($_FILES["imgFile"]["tmp_name"]);
    $image = base64_encode($imageContents);
}

$fnbc = new CreateFnBItemContr();
$status = $_POST["status"];
$fnbc->createFnBItem($itemName, $description, $price, $category, $status, $image);