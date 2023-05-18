<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketSales_classes.php";

class GenWeeklyTicketSalesContr {
    public function genWeeklyTicketSales($weekDate) {
        $ts = new TicketSales();
        $_SESSION['ticketSales'] = $ts->retrieveWeeklyTicketSales($weekDate);

        $_SESSION['timeLevel'] = "Week";
        $_SESSION['startDate'] = $weekDate;
        $_SESSION['endDate'] = date('Y-m-d', strtotime("+1 week",strtotime($weekDate)));

        header("location: ../../views/ticketSalesReport/viewTicketSalesReport.php");
        exit();
    }
}

$weekDate = $_POST['weekDate'];
$gwtsc = new GenWeeklyTicketSalesContr();
$gwtsc->genWeeklyTicketSales($weekDate);