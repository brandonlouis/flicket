<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/session_classes.php";

class ManageSessionContr {

    public function retrieveAllSessions() {
        $s = new Session();
        return $s->retrieveAllSessions();
    }

    public function retrieveOneSession($id) {
        $s = new Session();
        return $s->retrieveOneSession($id);
    }

    public function retrieveAllAvailableSessions() {
        $s = new Session();
        return $s->retrieveAllAvailableSessions();
    }
}