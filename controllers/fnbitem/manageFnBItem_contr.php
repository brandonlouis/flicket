<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/fnbitem_classes.php";

class ManageFnBItemContr {
    public function retrieveAllFnBitems() {
        $fnb = new FnBItem();
        return $fnb->retrieveAllFnBitems();
    }

    public function retrieveOneFnBItem($id) {
        $fnb = new FnBItem();
        return $fnb->retrieveOneFnBItem($id);
    }

    public function retrieveAllAvailableFnBItem() {
        $ch = new FnBItem();
        return $ch->retrieveAllAvailableFnBItem();
    }
}