<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/session_classes.php";

class CreateSessionContr {
    public function createSession($movieId, $hallId, $date, $startTime, $endTime, $status) {
        $s = new Session();
        $session = $s->createSession($movieId, $hallId, $date, $startTime, $endTime, $status);
        
        setcookie('flash_message', $session[0], time() + 3, '/');
        setcookie('flash_message_type', $session[1], time() + 3, '/');

        if ($session[1] == "danger") {
            header("location: ../../views/sessionMgmt/createSession.php");
            exit();
        } else {
            header("location: ../../views/sessionMgmt/manageSessions.php");
            exit();
        }
    }
}

$movieId = $_POST['movieId'];
$hallId = $_POST['hallId'];
$date = $_POST['date'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];

$sc = new CreateSessionContr();
$status = $_POST['status'];
$sc->createSession($movieId, $hallId, $date, $startTime, $endTime, $status);