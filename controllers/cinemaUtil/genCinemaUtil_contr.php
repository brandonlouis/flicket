<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemaUtil_classes.php";

class GenCinemaUtilContr {
    public function genCinemaUtil($timeLevel, $input) {
        $cu = new CinemaUtil();

        if($timeLevel == "session"){
            $_SESSION['cinemaUtil'] = $cu->retrieveSessionUtil($input);
            $_SESSION['timeLevel'] = "Session";
            $_SESSION['sessionID'] = $input;
        } else if($timeLevel == "day") {
            $_SESSION['cinemaUtil'] = $cu->retrieveDailyUtil($input);
            $_SESSION['timeLevel'] = "Day";
            $_SESSION['dayDate'] = $input;
        } else if($timeLevel == "week") {
            $_SESSION['cinemaUtil'] = $cu->retrieveWeeklyUtil($input);
            $_SESSION['timeLevel'] = "Week";
            $_SESSION['startDate'] = $input;
            $_SESSION['endDate'] = date('Y-m-d', strtotime("+1 week",strtotime($input)));;
        }
        

        header("location: ../../views/cinemaUtilReport/viewCinemaUtilReport.php");
        exit();
    }
}

$timeLevel = $_POST['timeLevel'];
if($timeLevel == "session") {
    $gcuc = new GenCinemaUtilContr();
    $gcuc->genCinemaUtil($timeLevel, $_POST['sessionID']);
} else if($timeLevel == "day") {
    $gcuc = new GenCinemaUtilContr();
    $gcuc->genCinemaUtil($timeLevel, $_POST['dayDate']);
} else if($timeLevel == "week") {
    $gcuc = new GenCinemaUtilContr();
    $gcuc->genCinemaUtil($timeLevel, $_POST['weekDate']);
} 

