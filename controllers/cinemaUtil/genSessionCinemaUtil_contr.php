<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemaUtil_classes.php";

class GenSessionCinemaUtilContr {
    public function genSessionCinemaUtil($sessionID) {
        $cu = new CinemaUtil();

            $_SESSION['cinemaUtil'] = $cu->retrieveSessionCinemaUtil($sessionID);
            $_SESSION['timeLevel'] = "Session";
            $_SESSION['sessionID'] = $sessionID;
        
        

        header("location: ../../views/cinemaUtilReport/viewCinemaUtilReport.php");
        exit();
    }
}

$sessionID = $_POST['sessionID'];
$gscuc = new GenSessionCinemaUtilContr();
$gscuc->genSessionCinemaUtil($sessionID);

