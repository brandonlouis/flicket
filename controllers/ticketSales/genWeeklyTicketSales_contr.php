<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/ticketSales_classes.php";

class GenWeeklyTicketSalesContr {
    public function genWeeklyTicketSales($startDate) {
        $ts = new TicketSales();
        $_SESSION['ticketSales'] = $ts->retrieveWeeklyTicketSales($startDate);

        $_SESSION['timeLevel'] = "Week";
        $_SESSION['startDate'] = $startDate;
        $_SESSION['endDate'] = date('Y-m-d', strtotime("+1 week",strtotime($startDate)));

        header("location: ../../views/ticketSalesReport/viewTicketSalesReport.php");
        exit();
    }
}

$startDate = $_POST['startDate'];
$gwtsc = new GenWeeklyTicketSalesContr();
$gwtsc->genWeeklyTicketSales($startDate);