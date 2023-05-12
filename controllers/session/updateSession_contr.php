<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/session_classes.php";

class UpdateSessionContr {
    public function updateSession($sessionId, $movieId, $hallId, $date, $startTime, $endTime) {
        $s = new Session();
        $session = $s->updateSession($sessionId, $movieId, $hallId, $date, $startTime, $endTime);

        setcookie('flash_message', $session[0], time() + 3, '/');
        setcookie('flash_message_type', $session[1], time() + 3, '/');

        if ($session[1] == "danger") {
            header("location: ../../views/sessionMgmt/updateSession.php?sessionId=" . $sessionId);
            exit();
        } else {
            header("location: ../../views/sessionMgmt/manageSessions.php");
            exit();
        }

        exit();
    }
}

$movieId = $_POST['movieId'];
$hallId = $_POST['hallId'];
$date = $_POST['date'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];

$sc = new UpdateSessionContr();
$sc->updateSession($_GET['sessionId'], $movieId, $hallId, $date, $startTime, $endTime);