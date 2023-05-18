<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemaUtil_classes.php";

class GenWeeklyCinemaUtilContr {
    public function genWeeklyCinemaUtil($weekDate) {
        $cu = new CinemaUtil();

        $_SESSION['cinemaUtil'] = $cu->retrieveWeeklyCinemaUtil($weekDate);
        $_SESSION['timeLevel'] = "Week";
        $_SESSION['startDate'] = $weekDate;
        $_SESSION['endDate'] = date('Y-m-d', strtotime("+1 week",strtotime($weekDate)));
        
        

        header("location: ../../views/cinemaUtilReport/viewCinemaUtilReport.php");
        exit();
    }
}
$weekDate = $_POST['weekDate'];
$gwcuc = new GenWeeklyCinemaUtilContr();
$gwcuc->genWeeklyCinemaUtil($weekDate);