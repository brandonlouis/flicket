<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemaUtil_classes.php";

class GenWeeklyCinemaUtilContr {
    public function genWeeklyCinemaUtil($startDate) {
        $cu = new CinemaUtil();

        $_SESSION['cinemaUtil'] = $cu->retrieveWeeklyCinemaUtil($startDate);
        $_SESSION['timeLevel'] = "Week";
        $_SESSION['startDate'] = $startDate;
        $_SESSION['endDate'] = date('Y-m-d', strtotime("+1 week",strtotime($startDate)));
        
        

        header("location: ../../views/cinemaUtilReport/viewCinemaUtilReport.php");
        exit();
    }
}
$startDate = $_POST['startDate'];
$gwcuc = new GenWeeklyCinemaUtilContr();
$gwcuc->genWeeklyCinemaUtil($startDate);