<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/session_classes.php";

class SuspendSessionContr {
    public function suspendSession($id) {
        $s = new Session();
        $session = $s->suspendSession($id);

        setcookie('flash_message', $session[0], time() + 3, '/');
        setcookie('flash_message_type', $session[1], time() + 3, '/');

        header("location: ../../views/sessionMgmt/manageSessions.php");
        exit();
    }
    public function activateSession($id) {
        $s = new Session();
        $session = $s->activateSession($id);

        setcookie('flash_message', $session[0], time() + 3, '/');
        setcookie('flash_message_type', $session[1], time() + 3, '/');

        header("location: ../../views/sessionMgmt/manageSessions.php");
        exit();
    }
}

if (isset($_GET['suspendId'])) {
    $sc = new SuspendSessionContr();
    $sc->suspendSession($_GET['suspendId']);

} else if (isset($_GET['activateId'])) {
    $sc = new SuspendSessionContr();
    $sc->activateSession($_GET['activateId']);

}