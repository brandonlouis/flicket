<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/fnbitem_classes.php";

class UpdateFnBItemContr {
    public function updateFnBItem($id, $itemName, $description, $price, $category, $image) {
        $fnb = new FnBItem();
        $fnbItem = $fnb->updateFnBItem($id, $itemName, $description, $price, $category, $image);

        setcookie('flash_message', $fnbItem[0], time() + 3, '/');
        setcookie('flash_message_type', $fnbItem[1], time() + 3, '/');

        header("location: ../../views/fnbItemMgmt/manageFnBItems.php");
        exit();
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

$fnbc = new UpdateFnBItemContr();
$fnbc->updateFnBItem($_GET['fnbItemId'], $itemName, $description, $price, $category, $image);