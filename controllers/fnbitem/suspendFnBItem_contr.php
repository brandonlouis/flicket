<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/fnbitem_classes.php";

class SuspendFnBItemContr {
    public function suspendFnBItem($id) {
        $fnb = new FnBItem();
        $fnbItem = $fnb->suspendFnBItem($id);

        setcookie('flash_message', $fnbItem[0], time() + 3, '/');
        setcookie('flash_message_type', $fnbItem[1], time() + 3, '/');

        header("location: ../../views/fnbItemMgmt/manageFnBItems.php");
        exit();
    }
    public function activateFnBitem($id) {
        $fnb = new FnBItem();
        $fnbItem = $fnb->activateFnBitem($id);

        setcookie('flash_message', $fnbItem[0], time() + 3, '/');
        setcookie('flash_message_type', $fnbItem[1], time() + 3, '/');

        header("location: ../../views/fnbItemMgmt/manageFnBItems.php");
        exit();
    }
}

if (isset($_GET['suspendId'])) {
    $fnbc = new SuspendFnBItemContr();
    $fnbc->suspendFnBItem($_GET['suspendId']);

} else if (isset($_GET['activateId'])) {
    $fnbc = new SuspendFnBItemContr();
    $fnbc->activateFnBitem($_GET['activateId']);

}