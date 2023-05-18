<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/cinemaUtil_classes.php";

class GenDailyCinemaUtilContr {
    public function genDailyCinemaUtil($dayDate) {
        $cu = new CinemaUtil();

        $_SESSION['cinemaUtil'] = $cu->retrieveDailyCinemaUtil($dayDate);
        $_SESSION['timeLevel'] = "Day";
        $_SESSION['dayDate'] = $dayDate;

        header("location: ../../views/cinemaUtilReport/viewCinemaUtilReport.php");
        exit();
    }
}
$dayDate = $_POST['dayDate'];
$gdcuc = new GenDailyCinemaUtilContr();
$gdcuc->genDailyCinemaUtil($dayDate);