<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/account_classes.php";

class ManageAccountContr {
    public function retrieveAllAccounts() {
        $a = new Account();
        return $a->retrieveAllAccounts();
    }

    public function retrieveOneAccount($id) {
        $a = new Account();
        return $a->retrieveOneAccount($id);
    }
}