<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/profile_classes.php";

class ManageProfileContr {
    public function retrieveAllProfiles() {
        $p = new Profile();
        return $p->retrieveAllProfiles();
    }

    public function retrieveOneProfile($userType) {
        $p = new Profile();
        return $p->retrieveOneProfile($userType);
    }
}