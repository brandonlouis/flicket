<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/session_classes.php";

class SessionContr {

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

    public function createSession($movieId, $hallId, $date, $startTime, $endTime, $status) {
        $s = new Session();
        $session = $s->createSession($movieId, $hallId, $date, $startTime, $endTime, $status);
        
        setcookie('flash_message', $session[0], time() + 3, '/');
        setcookie('flash_message_type', $session[1], time() + 3, '/');

        if ($session[1] == "danger") {
            header("location: ../views/sessionMgmt/createSession.php");
            exit();
        } else {
            header("location: ../views/sessionMgmt/manageSessions.php");
            exit();
        }
    }

    public function updateSession($sessionId, $movieId, $hallId, $date, $startTime, $endTime) {
        $s = new Session();
        $session = $s->updateSession($sessionId, $movieId, $hallId, $date, $startTime, $endTime);

        setcookie('flash_message', $session[0], time() + 3, '/');
        setcookie('flash_message_type', $session[1], time() + 3, '/');

        if ($session[1] == "danger") {
            header("location: ../views/sessionMgmt/updateSession.php?sessionId=" . $sessionId);
            exit();
        } else {
            header("location: ../views/sessionMgmt/manageSessions.php");
            exit();
        }

        exit();
    }

    public function suspendSession($id) {
        $s = new Session();
        $session = $s->suspendSession($id);

        setcookie('flash_message', $session[0], time() + 3, '/');
        setcookie('flash_message_type', $session[1], time() + 3, '/');

        header("location: ../views/sessionMgmt/manageSessions.php");
        exit();
    }
    public function activateSession($id) {
        $s = new Session();
        $session = $s->activateSession($id);

        setcookie('flash_message', $session[0], time() + 3, '/');
        setcookie('flash_message_type', $session[1], time() + 3, '/');

        header("location: ../views/sessionMgmt/manageSessions.php");
        exit();
    }

    public function searchSessions($searchText, $filter) {
        $s = new Session();
        $_SESSION['sessions'] = $s->searchSessions($searchText, $filter);

        header("location: ../views/sessionMgmt/searchSessions.php");
        exit();
    }
}


if (isset($_GET['suspendId'])) {
    $sc = new SessionContr();
    $sc->suspendSession($_GET['suspendId']);

} else if (isset($_GET['activateId'])) {
    $sc = new SessionContr();
    $sc->activateSession($_GET['activateId']);

} else if (isset($_POST['createSession']) || isset($_POST['updateSession'])) {
    $movieId = $_POST['movieId'];
    $hallId = $_POST['hallId'];
    $date = $_POST['date'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    
    $sc = new SessionContr();

    if (isset($_POST['createSession'])) {
        $status = $_POST['status'];
        $sc->createSession($movieId, $hallId, $date, $startTime, $endTime, $status);
    } else if (isset($_POST['updateSession']) && isset($_GET['sessionId'])) {
        $sc->updateSession($_GET['sessionId'], $movieId, $hallId, $date, $startTime, $endTime);
    }
} else if (isset($_POST['filter'])) {
    $searchText = $_POST['searchText'];
    $filter = $_POST['filter'];
    
    $sc = new SessionContr();
    $sc->searchSessions($searchText, $filter);
}